<?php
/**
 * Administrador/generatexml_publicados.php
 * Genera un XML Crossref 4.4.2 con TODOS los artículos Publicados = 1
 */

session_start();
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../verificacion.php";
Nolink();

if (empty($_SESSION["id"])) { header("Location: index.php"); exit; }

date_default_timezone_set("America/Mexico_City");

$pdo = conectar();
$pdo->exec("SET NAMES utf8mb4");

function norm_issn($raw){
  $s = strtoupper(preg_replace('/[^0-9X]/','',(string)$raw));
  if (strlen($s)!==8) return '';
  return substr($s,0,4).'-'.substr($s,4,4);
}
function valid_orcid($raw){
 
  $s = preg_replace('~^(?:https?://)?orcid\.org/~i','',trim((string)$raw));
  $s = strtoupper(preg_replace('/\s+/', '', $s));
  if (preg_match('/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9X]$/', $s)) {
    return "https://orcid.org/".$s;
  }
  return '';
}
function cr_text($s){

  return trim((string)$s);
}


$param = [
  'Nombre_Revista'   => 'Revista',
  'ISSN'             => '',
  'Doi'              => '',                 // prefijo+anio, p.ej. 10.62805/cid2025
  'Base_URL_Landing' => '',                 // p.ej. https://revistacid.itslerdo.edu.mx/revistacid2025/
  'Link_Publicacion' => '',                 // no se usa como resource; solo respaldo
  'Anio'             => '',                 // volumen/numero de número
  'Volumen'          => '',
  'Numero'           => '',
  'Dia_publicacion'  => '',
  'Mes_publicacion'  => '',
  'Año_publicacion'  => '',
  'Email_Revista'    => 'revistacid@itslerdo.edu.mx',
];

try {
  /*
  $rowP = $pdo->query("SELECT * FROM parametros LIMIT 1")->fetch(PDO::FETCH_ASSOC);
  if ($rowP) {
    foreach ($param as $k => $v) {
      if (array_key_exists($k,$rowP) && $rowP[$k] !== null && $rowP[$k] !== '') {
        $param[$k] = $rowP[$k];
      }
    }
  }*/
    
  $rowP = $pdo->query("SELECT * FROM parametros_revista LIMIT 1")->fetch(PDO::FETCH_ASSOC);
  if ($rowP) {
    foreach ($param as $k => $v) {
      if (array_key_exists($k,$rowP) && $rowP[$k] !== null && $rowP[$k] !== '') {
        $param[$k] = $rowP[$k];
      }
    }
  }

  $rowR = $pdo->query("SELECT * FROM registro ORDER BY id_registro DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
  if ($rowR) {
    foreach ($param as $k => $v) {
      if (array_key_exists($k,$rowR) && $rowR[$k] !== null && $rowR[$k] !== '') {
        $param[$k] = $rowR[$k];
      }
    }
  }
} catch (Throwable $e) { /* usar defaults */ }


$year  = (string)$param['Año_publicacion'];
$month = (string)$param['Mes_publicacion'];
$day   = (string)$param['Dia_publicacion'];

if ($year==='')  $year  = date('Y');
if ($month==='') $month = date('n'); 
if ($day==='')   $day   = date('j');

$issn_fmt = norm_issn($param['ISSN']);
$ts       = date("YmdHis");
$batch_id = $ts;  

$sqlArt = "SELECT a.idArticulo, a.Clave_Articulo, a.Nombre_Articulo,
                  a.Anio, a.Volumen, a.Numero, a.doi, a.Url_Landing, a.url
           FROM articulo a
           WHERE a.Publicado = b'1'
           ORDER BY a.idArticulo ASC";
$arts = $pdo->query($sqlArt)->fetchAll(PDO::FETCH_ASSOC);


$doc = new DOMDocument('1.0','UTF-8');
$doc->formatOutput = true;

$ns_cr   = "http://www.crossref.org/schema/4.4.2";
$ns_xsi  = "http://www.w3.org/2001/XMLSchema-instance";
$ns_jats = "http://www.ncbi.nlm.nih.gov/JATS1";
$xsi_loc = "http://www.crossref.org/schema/4.4.2 http://www.crossref.org/schema/deposit/crossref4.4.2.xsd";

$root = $doc->createElementNS($ns_cr, 'doi_batch');
$root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xsi',  $ns_xsi);
$root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:jats', $ns_jats);
$root->setAttribute('version', '4.4.2');
$root->setAttributeNS($ns_xsi, 'xsi:schemaLocation', $xsi_loc);
$doc->appendChild($root);

$head = $doc->createElement('head');
$head->appendChild($doc->createElement('doi_batch_id', $batch_id));
$head->appendChild($doc->createElement('timestamp', $ts));

$depositor = $doc->createElement('depositor');
$depositor->appendChild($doc->createElement('depositor_name','lerdo:lerdo'));
$depositor->appendChild($doc->createElement('email_address',$param['Email_Revista']));
$head->appendChild($depositor);

$head->appendChild($doc->createElement('registrant','WEB-FORM'));
$root->appendChild($head);


$body    = $doc->createElement('body');
$journal = $doc->createElement('journal');
$body->appendChild($journal);
$root->appendChild($body);


$jm = $doc->createElement('journal_metadata');
$jm->setAttribute('language','es');
$jm->appendChild($doc->createElement('full_title', cr_text($param['Nombre_Revista'])));
$jm->appendChild($doc->createElement('abbrev_title', 'CID Tec Lerdo'));
if ($issn_fmt !== '') {
  $issn = $doc->createElement('issn', $issn_fmt);
  $issn->setAttribute('media_type','electronic');
  $jm->appendChild($issn);
}
$journal->appendChild($jm);


$ji = $doc->createElement('journal_issue');

$ji_pd_print = $doc->createElement('publication_date');
$ji_pd_print->setAttribute('media_type','print');
$ji_pd_print->appendChild($doc->createElement('month', (string)(int)$month));
$ji_pd_print->appendChild($doc->createElement('day',   (string)(int)$day));
$ji_pd_print->appendChild($doc->createElement('year',  (string)(int)$year));
$ji->appendChild($ji_pd_print);

$ji_pd_online = $doc->createElement('publication_date');
$ji_pd_online->setAttribute('media_type','online');
$ji_pd_online->appendChild($doc->createElement('month', (string)(int)$month));
$ji_pd_online->appendChild($doc->createElement('day',   (string)(int)$day));
$ji_pd_online->appendChild($doc->createElement('year',  (string)(int)$year));
$ji->appendChild($ji_pd_online);


if (!empty($param['Volumen'])) {
  $jv = $doc->createElement('journal_volume');
  $jv->appendChild($doc->createElement('volume', cr_text($param['Volumen'])));
  $ji->appendChild($jv);
}
if (!empty($param['Numero'])) {
  $ji->appendChild($doc->createElement('issue', cr_text($param['Numero'])));
}
$journal->appendChild($ji);

foreach ($arts as $a) {
  $idArt   = (int)$a['idArticulo'];
  $clave   = (string)$a['Clave_Articulo'];
  $titulo  = cr_text($a['Nombre_Articulo']);
  $doi     = trim((string)$a['doi']);
  $landing = trim((string)$a['Url_Landing']);
  $urlPub  = trim((string)$a['url']);

  
  if ($doi === '' && $param['Doi'] !== '' && $clave !== '') {
    $base = rtrim($param['Doi'], '.'); // evita ".."
    $doi  = $base . '.' . $clave;
  }

  // Asegurar resource 
  if ($landing === '') {
    if ($urlPub !== '') {
      $landing = $urlPub;
    } elseif (!empty($param['Base_URL_Landing']) && $clave !== '') {
      $landing = rtrim($param['Base_URL_Landing'], '/').'/'.$clave;
    }
  }

  $ja = $doc->createElement('journal_article');
  $ja->setAttribute('publication_type','full_text');
  $journal->appendChild($ja);

  // Título
  $titles = $doc->createElement('titles');
  $titles->appendChild($doc->createElement('title', $titulo));
  $ja->appendChild($titles);

  // Autores
  $sqlAut = "SELECT Nombres, Apellido_Paterno, Apellido_Materno, ORCID, Principal
             FROM autores
             WHERE idArticulo = :id
             ORDER BY CAST(Principal AS UNSIGNED) DESC, idautor ASC";
  $stA = $pdo->prepare($sqlAut);
  $stA->execute([':id'=>$idArt]);
  $auts = $stA->fetchAll(PDO::FETCH_ASSOC);

  if ($auts) {
    $contributors = $doc->createElement('contributors');
    $isFirst = true;
    foreach ($auts as $au) {
      $given   = cr_text($au['Nombres']);
      $surname = cr_text(trim(($au['Apellido_Paterno'] ?? '').' '.($au['Apellido_Materno'] ?? '')));

      $pn = $doc->createElement('person_name');
      $pn->setAttribute('contributor_role','author');
      $pn->setAttribute('sequence', $isFirst ? 'first' : 'additional');
      $isFirst = false;

      if ($given !== '')   $pn->appendChild($doc->createElement('given_name', $given));
      if ($surname !== '') $pn->appendChild($doc->createElement('surname', $surname));

      $orcid = valid_orcid($au['ORCID'] ?? '');
      if ($orcid !== '') {
        $pn->appendChild($doc->createElement('ORCID', $orcid));
      }
      $contributors->appendChild($pn);
    }
    $ja->appendChild($contributors);
  }

  // Abstract desde tabla resumen
  try {
    $stR = $pdo->prepare("SELECT Resumen_Art FROM resumen WHERE idArticulo = :id LIMIT 1");
    $stR->execute([':id'=>$idArt]);
    $abs = cr_text($stR->fetchColumn());
    if ($abs !== '') {
      $jabst = $doc->createElement('jats:abstract');
      $jabst->appendChild($doc->createElement('jats:p', $abs));
      $ja->appendChild($jabst);
    }
  } catch (Throwable $e) { /* sin abstract */ }

  // Fechas del ARTÍCULO
  $pd_print  = $doc->createElement('publication_date');
  $pd_print->setAttribute('media_type','print');
  $pd_print->appendChild($doc->createElement('month', (string)(int)$month));
  $pd_print->appendChild($doc->createElement('day',   (string)(int)$day));
  $pd_print->appendChild($doc->createElement('year',  (string)(int)$year));
  $ja->appendChild($pd_print);

  $pd_online = $doc->createElement('publication_date');
  $pd_online->setAttribute('media_type','online');
  $pd_online->appendChild($doc->createElement('month', (string)(int)$month));
  $pd_online->appendChild($doc->createElement('day',   (string)(int)$day));
  $pd_online->appendChild($doc->createElement('year',  (string)(int)$year));
  $ja->appendChild($pd_online);

  // doi_data 
  $dd = $doc->createElement('doi_data');
  if ($doi !== '') {
    $dd->appendChild($doc->createElement('doi', $doi));
  }
  if ($landing !== '') {
    $dd->appendChild($doc->createElement('resource', $landing));
  } else {
 
    $dd->appendChild($doc->createElement('timestamp', $ts));
  }
  $ja->appendChild($dd);
}

/* ==================== Descargar ==================== */
$filename = "xml_publicados_$ts.xml";
header('Content-Type: application/xml; charset=utf-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');
echo $doc->saveXML();
exit;