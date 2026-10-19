<?php
session_start();
include_once('../conexion.php');
$conexion=conectar();    
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$id=$_SESSION['id'];

if (isset($_POST['gevaluar'])) 
    {
        try
        {
                $acept =$_POST['radiob']; 
                      if($acept == null) {$acept=0;}
                $just=$_POST['comen'];
                $clave=$_POST['clave'];
                $Con=$_POST['cbox'];
                              
                if($Con != null){
                    $peticion= "call spEvaluars('$id','$acept','$just','$clave',1)"; }
                else{
                    $peticion= "call spEvaluars('$id','$acept','$just','$clave',0)"; }
            
                $stmt = $conexion->prepare($peticion);
                $stmt->execute();
            
            
            
                if($stmt>0)
                {
                    $_SESSION['mensaje'] = "alertify.success('Evaluación exitosa!..')";
                    header("location: articulos.php");
                }
                        else 
                            {
                                $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error,  no se guardaron los datos..')";
                                    header("location: articulos.php");
                            }
        }
    catch(PDOExeption $e)
    {
        $_SESSION['mensaje'] = "alertify.error('Ha ocurrido un error, intenta mas tarde. <br>Error: ".$e->getMessage()."')";
        header("location: articulos.php");
    }
 }

?>