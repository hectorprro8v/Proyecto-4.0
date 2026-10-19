<?php
    function conectar() 
    {
        //LOCALHOST
      $host = "127.0.0.1:3308";
        $dbname = "bdsicsacid";
        $usuario= "root";
        $contrasenia = ""; 
        
  

        try {
                $conectarDB = new PDO("mysql:host=$host;dbname=$dbname; charset=utf8mb4", $usuario, $contrasenia);
                $conectarDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conectarDB->exec("SET NAMES utf8mb4");         
                return $conectarDB;
            }
        catch(PDOException $error)
            {
                $_SESSION["mensaje"]="alertify.error('Error en la conexión, revisa tu conexión a internet.')";
                header("Location: index.php");
            }
    }

    function color_revista()
    {
        try{
            $sql = "select Color_Revista from parametros";
            $sentencia = conectar()->prepare($sql);
            $sentencia->execute();
            foreach($sentencia as $fila)
            {
                $color = $fila["Color_Revista"];
            }
            
            return $color;
        }
        catch(PDOException $error)
        {
            $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error y no se ha podido cargar el color de la revista.')";
        }
    }

    function recepcion_resumen()
    {
        try{
            $sql = "select Recepcion_Resumen from parametros";
            $sentencia = conectar()->prepare($sql);
            $sentencia->execute();
            foreach($sentencia as $fila)
            {
                $recepcion_resumen = $fila["Recepcion_Resumen"];
            }
            
            return $recepcion_resumen;
        }
        catch(PDOException $error)
        {
            $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error.')";
        }
    }
    function limite_resumen()
    {
        try{
            $sql = "select Fecha_Limite_Resumen from parametros";
            $sentencia = conectar()->prepare($sql);
            $sentencia->execute();
            foreach($sentencia as $fila)
            {
                $recepcion_resumen = $fila["Fecha_Limite_Resumen"];
            }
            
            return $recepcion_resumen;
        }
        catch(PDOException $error)
        {
            $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error.')";
        }
    }

    function limite_extenso()
    {
        try{
            $sql = "select Fecha_Limite_Extenso from parametros";
            $sentencia = conectar()->prepare($sql);
            $sentencia->execute();
            foreach($sentencia as $fila)
            {
                $recepcion_extenso = $fila["Fecha_Limite_Extenso"];
            }
            
            return $recepcion_extenso;
        }
        catch(PDOException $error)
        {
            $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error.')";
        }
    }

    function limite_extenso_modificado($clave)
    {
        try{
            $sql = "select Fecha_Limite_Extenso_Modificado from registro where id_registro = (select idRegistro from articulo where Clave_Articulo = :clave)";
            $sentencia = conectar()->prepare($sql);
            $sentencia->bindParam(':clave', $clave);
            $sentencia->execute();
            $valor = null;
            foreach($sentencia as $fila)
            {
                $valor = $fila["Fecha_Limite_Extenso_Modificado"];
            }
            return $valor;
        }
        catch(PDOException $error)
        {
            $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error.')";
        }
    }

    function Fecha_Limite_Revision_Resumen($clave)
    {
        try{
            $sql = "select Fecha_Limite_Revision_Resumen from registro where id_registro = (select idRegistro from articulo where Clave_Articulo = :clave)";
            $sentencia = conectar()->prepare($sql);
            $sentencia->bindParam(':clave', $clave);
            $sentencia->execute();
            $valor = null;
            foreach($sentencia as $fila)
            {
                $valor = $fila["Fecha_Limite_Revision_Resumen"];
            }
            return $valor;
        }
        catch(PDOException $error)
        {
            $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error.')";
        }
    }

    function Fecha_Limite_Revision_Extenso()
    {
        try{
            $sql = "select Fecha_Limite_Revision_Extenso from parametros";
            $sentencia = conectar()->prepare($sql);
            $sentencia->execute();
            foreach($sentencia as $fila)
            {
                $recepcion_extenso = $fila["Fecha_Limite_Revision_Extenso"];
            }
            
            return $recepcion_extenso;
        }
        catch(PDOException $error)
        {
            $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error.')";
        }
    }

    function Fecha_Limite_Subir_Presentacion()
    {
        try{
            $sql = "select Fecha_Limite_Subir_Presentacion from parametros";
            $sentencia = conectar()->prepare($sql);
            $sentencia->execute();
            foreach($sentencia as $fila)
            {
                $recepcion_extenso = $fila["Fecha_Limite_Subir_Presentracion"];
            }
            
            return $recepcion_extenso;
        }
        catch(PDOException $error)
        {
            $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error.')";
        }
    }

    function link_publicacion()
    {
        try{
            $sql = "select Link_Publicacion from parametros";
            $sentencia = conectar()->prepare($sql);
            $sentencia->execute();
            foreach($sentencia as $fila)
            {
                $link = $fila["Link_Publicacion"];
            }
            
            return $link;
        }
        catch(PDOException $error)
        {
            $_SESSION["mensaje"]="alertify.error('Ha ocurrido un error.')";
        }
    }
?>