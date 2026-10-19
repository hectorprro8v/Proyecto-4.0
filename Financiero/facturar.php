<?php
    include("../conexion.php");
    $conexion=conectar();
    session_start();
    $recibo=$_GET["recibo"];
    if($recibo==null){
        header("Location: facturacion.php");
    }else{
        $sql="SELECT Fecha,Razon_Social, RFC, Domicilio, rp.Ciudad, rp.Estado, rp.Pais, CP, Sub_Total, Iva, Total, group_concat(ar.Clave_Articulo, '-', ar.Nombre_Articulo separator '<br>') as articulos FROM recibo_pago as rp left join recibo_pago_detalle as rpd on rp.idRecibo = rpd.idRecibo right join articulo as ar on rpd.idArticulo = ar.idArticulo where rp.idRecibo=$recibo";
        $sentencia=$conexion->prepare($sql);
        $sentencia->execute();
        $resultado=$sentencia->fetchAll();
        
        foreach($resultado as $dato){
            $fecha=$dato["Fecha"];
            $Razon_Social=$dato["Razon_Social"];
            $rfc=$dato["RFC"];
            $domicilio=$dato["Domicilio"];
            $ciudad=$dato["Ciudad"];
            $estado=$dato["Estado"];
            $pais=$dato["Pais"];
            $cp=$dato["CP"];
            $subtotal=$dato["Sub_Total"];
            $iva=$dato["Iva"];
            $total=$dato["Total"];
            $articulos=$dato["articulos"];
        }
        include("cr_factura.php");
    }