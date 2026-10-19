
<?php
// Esto código establece el encabezado para indicar que el contenido es un archivo Excel y establece el nombre del archivo.
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Detalles_articulo.xls");

echo "\xEF\xBB\xBF"; 

?>

<?php 
    $idArticulo = 132;
    include('consulta_det_art.php');
    //$clave_articulo = $_GET['clave'];
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
   error_reporting(E_ALL ^ E_NOTICE);
include_once "mostrar_art.php";
date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish'); 
//$fecha=strftime("%Y-%m-%d");
?>
    <?php 
            try{
                $detalle_articulo = "SELECT 
                A.idArticulo, A.Clave_Articulo, A.Nombre_Articulo, A.Institucion, A.Pais, A.Estado, A.Ciudad, A.Dictamen_Resumen, A.Dictamen_Extenso, A.Aceptado AS Aceptado_Articulo, A.Publicado, A.Anio, A.Volumen, A.Numero,
                E.Status_Ext, E.Aceptado AS Aceptado_Extenso, E.Modificaciones, E.Observaciones, E.ObsCriterio, E.Fecha_Recepcion, E.Fecha_Dictamen, E.idDocumentoExtenso, E.Concluido, E.idDocumentoExtensoSA,
                LI.Nombre AS Linea_Investigacion,
                RPD.idRecibo, group_concat(concat(AU.Nombres,' ',AU.Apellido_Paterno,' ',AU.Apellido_Materno) separator '<br><br>') as Autor,
                RE.Aceptado
            FROM 
                articulo AS A LEFT JOIN 
                extenso AS E ON A.idArticulo=E.idArticulo LEFT JOIN 
                linea_investigacion AS LI ON A.idLinea = LI.idLinea LEFT JOIN
                recibo_pago_detalle AS RPD ON RPD.idArticulo = A.idArticulo RIGHT JOIN
                autores AS AU ON AU.idArticulo = A.idArticulo INNER JOIN
                resumen AS RE ON RE.idArticulo = A.idArticulo
                group by A.idArticulo;";
                $gsent = $conexion->prepare($detalle_articulo);
                $gsent->execute();
                $detalle_result = $gsent->fetchAll();

        ?>
                        <table id="tabla" class="table table-hover" style="text-align: center">
                            <thead style="background-color: black; color: white;">
                            <!-- Este Excel solo coniene las siguientes columnas-->
                                <tr>
                                    <!--th>ID</th-->
                                    <th>CLAVE</th>
                                    <th>TITULO</th>
                                    <th>AUTOR/S</th>
                                    <th>INSTITUCIÓN</th>
                                    <th>LINEA DE INVESTIGACIÓN</th>
                                    <th>CIUDAD</th>
                                    <th>ESTADO</th>
                                    <th>PAÍS</th>
                                    <th>STATUS RESUMEN</th>
                                    <!--<th>DICTAMEN DEL RESUMEN</th>-->
                                    <!--<th>EXTENSO</th>-->
                                    <!--<th>EXTENSO SIN AUTORES</th>-->
                                    <th>FECHA RECEPCIÓN</th>
                                    <!--<th>MODIFICACIONES</th>-->
                                    <!--<th>OBSERVACIONES</th>-->
                                    <!--<th>OBSERVACIONES DE CRITERIOS</th>-->
                                    <th>ESTATUS</th>
                                    <th>FECHA DICTAMEN</th>
                                    <!--<th>DICTAMEN EXTENSO</th>-->
                                    <!--<th>FICHA DE PAGO</th>-->
                                    <th>ESTATUS DE PAGO</th>
                                    <th>PUBLICADO</th>
                                    <!--<th>AÑO</th>-->
                                    <!--<th>VOLUMEN</th>-->
                                    <!--<th>NUMERO</th>-->
                                </tr>
                            </thead>
                            <center>
                                <tbody>
                                    <?php 
                                        foreach($detalle_result as $dato){
                                            $idArt = $dato['idArticulo'];
                                            $claveArt = $dato['Clave_Articulo'];
                                            $nombreArt = $dato['Nombre_Articulo'];
                                            $institucion = $dato['Institucion'];
                                            $pais = $dato['Pais'];
                                            $estado = $dato['Estado'];
                                            $ciudad = $dato['Ciudad'];
                                            $dictRes = $dato['Dictamen_Resumen'];
                                            $publicado = $dato['Publicado'];
                                            $año = $dato['Anio'];
                                            $volumen = $dato['Volumen'];
                                            $numero = $dato['Numero'];
                                            $status = $dato['Status_Ext'];
                                            $mod = $dato['Modificaciones'];
                                            $obs = $dato['Observaciones'];
                                            $obsCrit = $dato['ObsCriterio'];
                                            $fechaRec = $dato['Fecha_Recepcion'];
                                            $fechaDic = $dato['Fecha_Dictamen'];
                                            $idRecibo = $dato['idRecibo'];
                                            $idDocExt = $dato['idDocumentoExtenso'];
                                            $idDocExtSA = $dato['idDocumentoExtensoSA'];
                                            $lineaInvest = $dato['Linea_Investigacion'];
                                            $clave_Art = $dato['Clave_Articulo'];
                                            $autores = $dato['Autor'];
                                            $statusRes = $dato['Aceptado'];
                                            $fichaPago = $dato[''];
                                            $dictExt = $dato['Status_Ext'];
                                    ?>
                                    <tr>
                                    <!--td><?php //echo $idArt?></td-->
                                    <td><br><?php echo $clave_Art?></td>
                                    <td><br><?php echo $nombreArt?></td>
                                    <td style = "width:500px"><br><?php echo $autores?></td>
                                    <td><br><?php echo $institucion?></td>
                                    <td><br><?php echo $lineaInvest?></td>
                                    <td><br><?php echo $ciudad?></td>
                                    <td><br><?php echo $estado?></td>
                                    <td><br><?php echo $pais?></td>                                   
                                    <td>
                                        <?php
                                        if($statusRes == '1'){
                                            echo("<br>Aceptado");
                                            ?>
                                            <?php
                                        }else{
                                            echo("<br>No Aceptado");
                                        }
                                        ?>
                                    </td>
                                    <td>
                                    <?php 
                                        if(isset($fechaRec)){
                                            echo $fechaRec;
                                        }else{
                                            echo 'N/D';
                                        }
                                    ?>
                                    </td>
                                    <td>
                                    <?php 
                                        if(isset($status)){
                                            echo $status;
                                        }else{
                                            echo 'N/D';
                                        }
                                    ?>
                                    </td>
                                    <td>
                                    <?php 
                                        if(isset($fechaDic)){
                                            echo $fechaDic;
                                        }else{
                                            echo 'N/D';
                                        }
                                    ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (file_exists('../Documentos/Recibos/' . $idRecibo . '-' . $clave_Art . '.pdf')) {
                                            ?>
                                            <?php
                                                echo('Pagado')
                                                 ?>
                                            <?php
                                        }else{
                                            echo 'N/D'
                                            ?>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($publicado == '1'){
                                            echo("<br>Aceptado");
                                            ?>
                                            <?php
                                        }else{
                                            echo("<br>No Aceptado");
                                        }
                                        ?>
                                    </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>

                                </tbody>
                            
                        </table>
                    <?php 
                        }
                        catch(PDOException $e){
                            $_SESSION['mensaje'] = "alertify.error('Ah ocurrido un error al tratar de guardar los datos. Error: ".$e->getMessage()."')";
                        }
                    ?>
                