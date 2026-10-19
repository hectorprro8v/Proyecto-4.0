<?php
include_once "../conexion.php";
session_start();
    include("../verificacion.php");
    Nolink();
    if($_SESSION["id"]=="")
    {
        header("Location: ../index.php");
    }
$conexion=conectar();
$idrevisor=$_GET['revisor'];
if($irevisor==null)
{

    header('location: detalle_revisores.php');
}