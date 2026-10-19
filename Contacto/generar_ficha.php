<?php
    include("consulta_art_fich.php");
    $color = color_revista();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        
        <link href="../css/index/indexstyle.css" rel="stylesheet" media="screen">
        <link href="../css/index/menu.css" rel="stylesheet" media="screen">
        <link href="../css/index/estilos.css" rel="stylesheet" media="screen">
        <link href="../css/index/navbar-fixed-left.min.css" rel="stylesheet">

        <!-- Alertify (mensajes) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
        <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script src="../js/jquery-3.2.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <title>CID TEC LERDO - INICIO</title>
        <style>
            /* Resalta filas seleccionadas */
            #tabla_art_pagos tbody tr.seleccionada { background-color:#BEDAE8; }
        </style>
    </head>
    <body>
        <br/>
        <div class="logos">
            <img class="imagenlogo" src="../img/header_portal_vigente_1170.png"/>
        </div>

        <br>
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-left" role="navigation">
                <div class="navbar-header">
                    <button type="button" style="color:red;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse" >
                        <img src=../img/menu.png>
                    </button>
                    <a class="navbar-brand" href="index.php" style="margin-left:15px;">SICSACID</a>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <div class="image">
                            <img src="../img/Logo_Revista.png" width="90" height="120" alt="User" style="margin-left:40px;">     
                        </div>
                        <br>
                        <li class="dropdown">
                            <button href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" type="button" style="margin-left:10px;"><?php echo $_SESSION["nameuser"]?> <b class="caret"></b></button>
                            <ul class="dropdown-menu"> 
                                <li class=""><a href="perfil.php"><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="../destruir_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                            </ul>
                        </li>
                        <?php /*
                        <li class="" style="margin-left:20px"><a href="resumenes.php">Resumen </a></li>
                        */?>
                        <li class="" style="margin-left:20px"><a href="resumenes.php">Registro </a></li>
                        <li class="" style="margin-left:20px"><a href="articulos.php">Artículos</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="margin-left:20px"> Documentos <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="divider"></li>
                                <li class=""><a href="generar_ficha.php">Generar Ficha de Pago</a></li>
                                <li class=""><a href="fichas_de_pago.php">Recibos y Comprobantes</a></li>
                                <li class="divider"></li>
                                <li class=""><a href="subir_documentos.php">Subir Documentos</a></li>
                                <li class="divider"></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Respaldo de mensaje si Alertify no carga -->
        <?php if (!empty($_SESSION['mensaje_texto'])): ?>
            <div class="container">
                <div class="alert alert-info" role="alert">
                    <?php echo htmlspecialchars($_SESSION['mensaje_texto']); $_SESSION['mensaje_texto']=null; ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="envia_recibo.php" method="post" enctype="multipart/form-data">
            <div class="container-fluid">
                <div class="panel panel-default" id="sombra">
                    <div class="panel-body">
                        <h2>FICHAS DE PAGO</h2>
                        <hr>
                        <div class="container-fluid">
                            <div class="panel panel-default">
                                <div class="panel panel-heading" style="background-color: <?=$color?>"></div>
                                <div class="panel-body">
                                    <div class="row container-fluid" id="división_datos">
                                        <div class="col-sm-12">
                                            <h4>Razón Social</h4>
                                            <input type="text" class="form-control" style="text-align: center;" name="razonsocial" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>RFC</h4>
                                            <input type="text" class="form-control" style="text-align: center;" name="rfc" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>País</h4>
                                            <input type="text" class="form-control" style="text-align: center;" name="pais" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>Estado</h4>
                                            <input type="text" class="form-control" style="text-align: center;" name="estado" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>Ciudad</h4>
                                            <input type="text" class="form-control" style="text-align: center;" name="ciudad" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>Domicilio</h4>
                                            <input type="text" class="form-control" style="text-align: center;" name="domicilio" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>Código Postal</h4>
                                            <input type="text" class="form-control" style="text-align: center;" name="cp" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row container-fluid">
                                        <div class="col-sm-6">
                                            <h4>Selecciona el tipo de pago</h4>
                                            <?=precio_articulo();?>
                                        </div>
                                    </div>  
                                    <hr>
                                    <div class="row container-fluid" id="division_seleccionar">
                                        <h4>Selecciona los artículos que pagarás...</h4>
                                        <div class="table-responsive" id="tabla"> 
                                            <?=mostrar_art_pagos();?>
                                        </div>
                                        <!-- el servidor no depende de esto, pero lo mantenemos -->
                                        <input type="text" name="cant_art" id="cantidad" value="0" hidden>
                                        <br>
                                    </div>
                                    <hr>
                                    <div class="row container-fluid" id="division_pagar">
                                        <div class="col-sm-4">
                                            <h4>Subtotal</h4>
                                            <input type="text" class="form-control" style="text-align: center;" name="subtotal" value="$0" id="subt" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>+IVA</h4>
                                            <input type="text" class="form-control" style="text-align: center;" name="iva" value="$0" id="ivat" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>Total</h4>
                                            <input type="text" class="form-control" style="text-align: center;" name="total" value="$0" id="totalt" readonly>
                                        </div>
                                        <br>
                                        <div class="col-sm-4">
                                            <input type="checkbox" name="facturar" id="facturar"> 
                                            <label>SOLICITAR FACTURA</label>
                                        </div>

                                        <div id="factura-extra" style="display:none; margin-top:10px;">
                                            <div class="row container-fluid">
                                                <div class="col-sm-4">
                                                    <h4>Forma de Pago</h4>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        style="text-align:center;"
                                                        name="forma_pago"
                                                        id="forma_pago"
                                                        maxlength="200"
                                                        placeholder="Ej. Transferencia SPEI, Tarjeta de crédito, Efectivo, etc."
                                                    />
                                                </div>
                                                <div class="col-sm-4">
                                                    <h4>Régimen Fiscal</h4>
                                                    <input type="text" class="form-control" style="text-align:center;" name="regimen_fiscal" id="regimen_fiscal" />
                                                </div>
                                                <div class="col-sm-4">
                                                    <h4>Uso del CFDI</h4>
                                                    <input type="text" class="form-control" style="text-align:center;" name="uso_cfdi" id="uso_cfdi" />
                                                </div>
                                            </div>

                                            <div class="row container-fluid" style="margin-top:10px;">
                                                <div class="col-sm-6">
                                                    <h4>Situación Fiscal (PDF)</h4>
                                                    <input type="file" class="form-control" name="situacion_fiscal_pdf" id="situacion_fiscal_pdf" accept="application/pdf" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="container-fluid">
                                        <button class="btn btn-lg btn-block btn-primary" type="submit" name="enviar">Enviar y generar recibo de pago</button>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /container-fluid -->
                    </div>
                </div>
            </div>
        </form>

        <div class="lineasep"><img src="../img/line.gif"/></div>
        <div class="contactos">
            <table>
                <tr>
                    <td><a href="https://www.facebook.com/pages/Instituto-Tecnol%C3%B3gico-Superior-de-Lerdo-P%C3%A1gina-Oficial/285056498195463"><img 
                    src="../img/face.jpg"/></a></td>
                    <td><a href="https://twitter.com/ITSLerdo?ref_src=twsrc%5Etfw&ref_url=http%3A%2F%2Fwww.itslerdo.edu.mx%2F"><img src="../img/tw.jpg"/></a></td>
                    <td><a><img src="../img/correoitsl.gif"/></a></td>
                </tr>
            </table>
        </div>

        <div class="pie_pagina">   
            <img src="../img/pie_pagina.jpg"/>
            <p>Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                <br/>C.P. 35150 Cd. Lerdo, Dgo
                <br/>Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
            </p>
        </div>
    </body>
</html>

<!-- ====================== SCRIPTS ====================== -->
<script>
  // Precio actual seleccionado en el combo
  var precio = 0;

  // Click en toda la fila: togglear el checkbox
  function filaClick(tr) {
    var chk = tr.querySelector('.art-chk');
    if (!chk) return;
    chk.checked = !chk.checked;
    tr.classList.toggle('seleccionada', chk.checked);
    recalc();
  }

  // Click directo en el checkbox: solo recalcula/estilos
  function onChkClick(el) {
    var tr = el.closest('tr');
    if (tr) tr.classList.toggle('seleccionada', el.checked);
    recalc();
  }

  // Seleccionar/deseleccionar todos
  function toggleTodos(master) {
    var marcados = master.checked;
    document.querySelectorAll('.art-chk').forEach(function(chk) {
      chk.checked = marcados;
      var tr = chk.closest('tr');
      if (tr) tr.classList.toggle('seleccionada', marcados);
    });
    recalc();
  }

  // Recalcular totales con base en # de seleccionados
  function recalc() {
    var cantidad = document.querySelectorAll('.art-chk:checked').length;
    var subtotal = +(precio * cantidad).toFixed(2);

    // Dejas tu cálculo original; si quieres IVA=16% dime y lo cambio.
    var iva   = subtotal;
    var total = subtotal;

    document.getElementById("subt").value   = "$" + subtotal;
    document.getElementById("ivat").value   = "$" + iva;
    document.getElementById("totalt").value = "$" + total;

    // Solo informativo; el servidor cuenta check[] igualmente
    var cantHidden = document.getElementById("cantidad");
    if (cantHidden) cantHidden.value = cantidad;
  }

  // Al cambiar el tipo de pago, actualiza precio y reinicia totales/selecciones
  function seleccionar_precio() {
    var el = document.getElementById("precios");
    precio = parseFloat(el.value || 0);

    // Reinicia selección
    document.getElementById('chk_all') && (document.getElementById('chk_all').checked = false);
    document.querySelectorAll('.art-chk').forEach(function(chk) {
      chk.checked = false;
      var tr = chk.closest('tr');
      if (tr) tr.classList.remove('seleccionada');
    });

    // Limpia montos
    document.getElementById("subt").value   = "$0";
    document.getElementById("ivat").value   = "$0";
    document.getElementById("totalt").value = "$0";
    document.getElementById("cantidad").value = 0;
  }
</script>

<!-- Mostrar/ocultar campos de facturación -->
<script>
  $(function() {
    function toggleFacturaExtra() {
      if ($('#facturar').is(':checked')) {
        $('#factura-extra').slideDown(150);
        $('#forma_pago, #regimen_fiscal, #uso_cfdi, #situacion_fiscal_pdf').attr('required', true);
      } else {
        $('#factura-extra').slideUp(150);
        $('#forma_pago, #regimen_fiscal, #uso_cfdi, #situacion_fiscal_pdf').removeAttr('required');
      }
    }
    $('#facturar').on('change', toggleFacturaExtra);
    toggleFacturaExtra();
  });
</script>

<?php if(isset($_SESSION['mensaje'])): ?>
<script>
  try {
    alertify.set('notifier','position', 'top-right');
    <?= $_SESSION['mensaje']; ?>
  } catch (e) {}
</script>
<?php $_SESSION["mensaje"]=null; endif; ?>
