<?php
    include("../conexion.php");
    session_start();
    if($_SESSION["id"]==null){
        header("Location: facturación.php");
    }

    function recibos()
    {
        $conexion = conectar();
        
        $sql="select rp.idRecibo as recibo, df.idDocumento as documento, group_concat(df.Tipo_Documento) as tipo from recibo_pago as rp left join documentos_financiero as df on rp.idRecibo = df.idRecibo group by rp.idRecibo order by  case when group_concat(df.Tipo_Documento)='R' then 0 else 1 end;";
        $sentencia=conectar()->prepare($sql);
        $sentencia->execute();
        
        $result="";
        foreach($sentencia as $dato){
            $idRecibo = $dato["recibo"];
            $idDocumento = $dato["documento"];
            $tipo = $dato["tipo"];
            
            $result.="<tr><td>";
            $result.=$idRecibo;
            $result.="</td><td></td><td>";
            $result.="<a href='recibo.php?recibo=$idRecibo' class='btn btn-md btn-block btn-primary'>Ver recibo</a>";
            $result.="</td><td></td><td>";
            if($idDocumento != null){
                $result.="<a target='_blank' href='documento_recibo.php?recibo=$idRecibo' class='btn btn-md btn-block btn-success' type='button'>Descargar</a>";
                $disabled="";
            }else{
                $result.="No disponible";
                $disabled="disabled";
            }
            $result.="</td><td></td><td>";
            if($tipo=='R' && $tipo != null){
                $result.="<a $disabled class='btn btn-info btn-md' href='facturar.php?recibo=$idRecibo'>Facturar</a>";
            }else{
                if($tipo==null){
                    $result.="No disponible";
                }else{
                    $result.="Facturado";
                }
            }
            $result.="</td></tr>";
        }
        return $result;
    }
?>