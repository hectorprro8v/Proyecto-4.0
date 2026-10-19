<?php
// generatexml_publicados.php
session_start();
require_once __DIR__ . "/../../conexion.php";
require_once __DIR__ . "/../../verificacion.php";
Nolink();

if (empty($_SESSION["id"])) { header("Location: ../index.php"); exit; }

$pdo = conectar();
$pdo->exec("SET NAMES utf8mb4");

/* ===================== HELPERS ===================== */
function normalize_orcid($orcidRaw) {
  $o = trim((string)$orcidRaw);
  if ($o === '') return '';
  $o = preg_replace('\s+', '', $o);
  if (preg_match('^[0-9Xx]{16}$', $o)) {
    $o = substr($o,0,4).'-'.substr($o,4,4).'-'.substr($o,8,4).'-'.substr($o,12,4);
  }
  $o = preg_replace('~^https?://~i', '', $o);
  if (stripos($o, 'orcid.org/') !== 0) $o = 'orcid.org/' . $o;
  $o = 'https://' . $o;
  if (!preg_match('~^https://orcid\.org/[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9X]$~i', $o)) {
    return '';
  }
  return $o;
}

function appendContributors(DOMDocument $dom, DOMElement $artNode, PDO $pdo, $idArticulo) {
  static $st = null;
  if ($st === null) {
    $sql = "SELECT Nombres, Apellido_Paterno, Apellido_Materno, Institucion, ORCID, Principal, idautor
            FROM autores
            WHERE idArticulo = :id
            ORDER BY CASE WHEN Principal = 1 THEN 0 ELSE 1 END, idautor ASC";
    $st = $pdo->prepare($sql);
  }
  $st->execute([':id' => $idArticulo]);
  $rows = $st->fetchAll(PDO::FETCH_ASSOC);
  if (!$rows) return;

  $contributors = $dom->createElement('contributors');

  foreach ($rows as $i => $r) {
    $sequence = ($i === 0) ? 'first' : 'additional';
    $given = trim((string)$r['Nombres']);
    $apPat = trim((string)$r['Apellido_Paterno']);
    $apMat = trim((string)$r['Apellido_Materno']);
    $surname = trim($apPat . ($apMat !== '' ? ' ' . $apMat : ''));
    $affil = trim((string)$r['Institucion']);
    $orcid = normalize_orcid($r['ORCID']);

    if ($given === '' && $surname === '') continue;

    $p = $dom->createElement('person_name');
    $p->setAttribute('sequence', $sequence);
    $p->setAttribute('contributor_role', 'author');
    if ($given !== '')   $p->appendChild($dom->createElement('given_name', $given));
    if ($surname !== '') $p->appendChild($dom->createElement('surname', $surname));
    if ($affil !== '')   $p->appendChild($dom->createElement('affiliation', $affil));
    if ($orcid !== '')   $p->appendChild($dom->createElement('ORCID', $orcid));
    $contributors->appendChild($p);
  }

  if ($contributors->hasChildNodes()) $artNode->appendChild($contributors);
}

/* ============ IDS seleccionados (opcional) ============ */
$ids = [];
if (!empty($_POST['ids'])) {
  foreach (explode(',', $_POST['ids']) as $id) {
    $id = (int)trim($id);
    if ($id > 0) $ids[] = $id;
  }
}
$whereIds = $ids ? " AND a.idArticulo IN (" . implode(',', $ids) . ") " : "";

/* ===================== PARÁMETROS ===================== */
/*
$sqlParams = "SELECT
                Nombre_Revista,
                ISSN,
                Anio, Volumen, Numero,
                Dia_Publicacion      AS dia_pub,
                Mes_Publicacion      AS mes_pub,
                Año_Publicacion    AS anio_pub,
                Doi                  AS doi_revista_base,
                Base_URL_Landing,
                Link_Publicacion
              FROM parametros
              LIMIT 1";
$P = $pdo->query($sqlParams)->fetch(PDO::FETCH_ASSOC);
if (!$P) { die("Faltan parámetros de revista."); }
*/ 
$sqlParams = "SELECT
                Nombre_Revista,
                ISSN,
                Anio, Volumen, Numero,
                Doi                  AS doi_revista_base,
                Base_URL_Landing,
                Link_Publicacion
              FROM parametros_revista
              LIMIT 1";
$P = $pdo->query($sqlParams)->fetch(PDO::FETCH_ASSOC);
if (!$P) { die("Faltan parámetros de revista."); }

$sqlReg = "SELECT
                Dia_publicacion      AS dia_pub,
                Mes_publicacion      AS mes_pub,
                Año_publicacion    AS anio_pub
              FROM registro
              ORDER BY id_registro DESC
              LIMIT 1";

              
$R = $pdo->query($sqlReg)->fetch(PDO::FETCH_ASSOC);
if (!$R) { die("Faltan datos de convocatoria (registro)."); }

$P['dia_pub']  = $R['dia_pub'];
$P['mes_pub']  = $R['mes_pub'];
$P['anio_pub'] = $R['anio_pub'];


$diaPub  = str_pad((string)(int)$P['dia_pub'], 2, '0', STR_PAD_LEFT);
$mesPub  = str_pad((string)(int)$P['mes_pub'], 2, '0', STR_PAD_LEFT);
$anioPub = (string)$P['anio_pub'];

$nombreRevista = $P['Nombre_Revista'] ?: 'Revista';

$issn = '';
$issnRaw = strtoupper(trim((string)$P['ISSN']));
$issnRaw = preg_replace('\s+','', $issnRaw);
if (preg_match('^[0-9]{4}-?[0-9]{3}[0-9X]$', $issnRaw)) {
  if (strpos($issnRaw, '-') === false) $issnRaw = substr($issnRaw, 0, 4) . '-' . substr($issnRaw, 4);
  $issn = $issnRaw;
}

/* ===================== ARTÍCULOS PUBLICADOS ===================== */
$sqlArt = "SELECT
             a.idArticulo,
             a.Clave_Articulo,
             a.Nombre_Articulo,
             a.Anio, a.Volumen, a.Numero,
             a.doi,
             a.Url_Landing,
             a.url,
             r.Resumen_Art AS abstracto
           FROM articulo a
           LEFT JOIN resumen r ON r.idArticulo = a.idArticulo
           WHERE a.Publicado = b'1' {$whereIds}
           ORDER BY a.idArticulo";
$arts = $pdo->query($sqlArt)->fetchAll(PDO::FETCH_ASSOC);
if (!$arts) { die("No hay artículos PUBLICADOS para generar XML."); }

/* ===================== XML (Crossref 4.4.2) ===================== */
$nsCR   = 'http://www.crossref.org/schema/4.4.2';
$nsJATS = 'http://www.ncbi.nlm.nih.gov/JATS1';

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;

$doi_batch = $dom->createElementNS($nsCR, 'doi_batch');
$doi_batch->setAttribute('version', '4.4.2');
$doi_batch->setAttributeNS(
  'http://www.w3.org/2001/XMLSchema-instance',
  'xsi:schemaLocation',
  'http://www.crossref.org/schema/4.4.2 http://www.crossref.org/schema/deposit/crossref4.4.2.xsd'
);
$doi_batch->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:jats',$nsJATS);
$dom->appendChild($doi_batch);

/* head */
$head = $dom->createElement('head');
$doi_batch->appendChild($head);
$head->appendChild($dom->createElement('doi_batch_id', uniqid('pub_')));
$head->appendChild($dom->createElement('timestamp', date('YmdHis').'000'));

$depositor = $dom->createElement('depositor');
$depositor->appendChild($dom->createElement('depositor_name', 'lerdo:lerdo'));
$depositor->appendChild($dom->createElement('email_address', 'revistacid@itslerdo.edu.mx'));
$head->appendChild($depositor);
$head->appendChild($dom->createElement('registrant', 'WEB-FORM'));

/* body/journal */
$body = $dom->createElement('body');
$doi_batch->appendChild($body);
$journal = $dom->createElement('journal');
$body->appendChild($journal);

/* journal_metadata */
$jm = $dom->createElement('journal_metadata');
$journal->appendChild($jm);
$jm->appendChild($dom->createElement('full_title', $nombreRevista));
$jm->appendChild($dom->createElement('abbrev_title', 'CID TEC LERDO'));
if ($issn !== '') {
  $issnEl = $dom->createElement('issn', $issn);
  $issnEl->setAttribute('media_type', 'electronic');
  $jm->appendChild($issnEl);
}

/* journal_issue */
$ji = $dom->createElement('journal_issue');
$journal->appendChild($ji);

/* publication_date ONLINE ÚNICO */
$pdOnline = $dom->createElement('publication_date');
$pdOnline->setAttribute('media_type','online');
$pdOnline->appendChild($dom->createElement('month', $mesPub));
$pdOnline->appendChild($dom->createElement('day',   $diaPub));
$pdOnline->appendChild($dom->createElement('year',  $anioPub));
$ji->appendChild($pdOnline);

/* volumen/numero (toma del primer art o de parámetros) */
if (!empty($arts)) {
  $vol  = $arts[0]['Volumen'] ?: ($P['Volumen'] ?? '');
  $num  = $arts[0]['Numero']  ?: ($P['Numero']  ?? '');
  if ($vol) {
    $jv = $dom->createElement('journal_volume');
    $jv->appendChild($dom->createElement('volume', $vol));
    $ji->appendChild($jv);
  }
  if ($num) $ji->appendChild($dom->createElement('issue', $num));
}

/* ====== journal_article(s) solo PUBLICADOS ====== */
foreach ($arts as $r) {
  $art = $dom->createElement('journal_article');
  $art->setAttribute('publication_type','full_text');
  $journal->appendChild($art);

  /* titles */
  $titles = $dom->createElement('titles');
  $titles->appendChild($dom->createElement('title', $r['Nombre_Articulo']));
  $art->appendChild($titles);

  /* contributors */
  appendContributors($dom, $art, $pdo, (int)$r['idArticulo']);

  /* abstract (JATS) */
  if (!empty($r['abstracto'])) {
    $ab = $dom->createElementNS($nsJATS, 'jats:abstract');
    $ab->setAttribute('xml:lang','es');
    $p  = $dom->createElementNS($nsJATS, 'jats:p');
    $p->appendChild($dom->createTextNode($r['abstracto']));
    $ab->appendChild($p);
    $art->appendChild($ab);
  }

  /* publication_date solo ONLINE */
  $ao = $dom->createElement('publication_date');
  $ao->setAttribute('media_type','online');
  $ao->appendChild($dom->createElement('month', $mesPub));
  $ao->appendChild($dom->createElement('day',   $diaPub));
  $ao->appendChild($dom->createElement('year',  $anioPub));
  $art->appendChild($ao);

  /* doi_data del artículo */
  $dd = $dom->createElement('doi_data');
  $dd->appendChild($dom->createElement('doi', $r['doi']));

  $resource = trim((string)($r['Url_Landing'] ?: $r['url'] ?: ''));
  if ($resource === '' && !empty($P['Base_URL_Landing']) && !empty($r['Clave_Articulo'])) {
    $resource = rtrim($P['Base_URL_Landing'], '/') . '/' . rawurlencode($r['Clave_Articulo']);
  }
  if ($resource === '') {
    $resource = 'https://doi.org/' . $r['doi'];
  }
  $dd->appendChild($dom->createElement('resource', $resource));
  $art->appendChild($dd);
}

/* ====== salida ====== */
$xml = $dom->saveXML();
$filename = "crossref_publicados_".date('Ymd_His').".xml";
header("Content-Type: application/xml; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
echo $xml;