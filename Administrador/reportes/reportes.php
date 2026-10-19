<?php
include_once "../../conexion.php";
$con=conectar();
session_start();

if(isset($_POST['opcion']))
{
$switch=$_POST['opcion'];
   
switch ($switch)
{
    case 'resumen':
     try
     {
     
     $salida="";
     $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,a.Estado,a.Institucion,
     (case r.Aceptado when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
     from resumen as r inner join articulo as a on a.idArticulo=r.idArticulo";
         
     if(isset($_POST['s'])||isset($_POST['e'])||isset($_POST['i']))
     {
      $status=$_POST['s'];
      $estado=$_POST['e'];
      $insti=$_POST['i'];
//        $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,a.Estado,a.Institucion,
//               (case r.Aceptado when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
//               from resumen as r inner join articulo as a on a.idArticulo=r.idArticulo where r.Aceptado='$status' and a.Estado='$estado' and a.Institucion='$insti'";
      if($status=='v' and $estado=='v' and $insti=='v')
      {
          
          $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
     (case Dictamen_Resumen when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
     from articulo";
      }
        else if($estado=='v' and $insti=='v')
        {
            $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Resumen  when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Dictamen_Resumen='$status'";
        }
         else if($insti=='v' and $status=='v')
        {
            $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Resumen when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Estado='$estado'";
        }
         else if($status=='v' and $estado=='v')
         {
             $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Resumen when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Institucion='$insti'";
         }
         else if($status=='v')
         {
             $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Resumen when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Estado='$estado' and Institucion='$insti'";
            
         }
         else if($estado=='v')
         {
              $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Resumen when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Dictamen_Resumen='$status' and Institucion='$insti'";
             
         }
         else if($insti=='v')
         {
             
              $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                 (case Dictamen_Resumen when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Dictamen_Resumen='$status' and Estado='$estado'";
         }
         else
         {
              $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Resumen when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Dictamen_Resumen='$status' and Estado='$estado' and Institucion='$insti'";
             
         }
       
      }
     
        $sql = $con->prepare($consulta);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql->fetchAll();
     
        $salida.="<table class='table table-hover' style='text-align: center;'>
                                                        <thead style='background-color: white; color: black;'>   
                                                            

                                                            <tr>
                                                                <th style='width: 70px;'>Clave</th>
                                                                <th style='width: 250px;'>Titulo Artículo</th>
                                                                <th style='width: 85px;'>Estado</th>
                                                                <th style='width: 200px;'>Institución</th>
                                                                <th style='width: 100px;'>Status</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                       
                                                            <tbody>"; 
                                                               
                                                          
                                                            foreach ($result as $row) 
                                                            {
                                                                $salida.="<tr>
                                                            
                                                                    
                                                                    <td id='c1'>".$row['Clave'] ."</td>
                                                                    <td id='c2'>".$row['Nombre']." </td>
                                                                    <td id='c3'>".$row['Estado']." </td>
                                                                    <td id='c4'>".$row['Institucion']." </td>
                                                                    <td id='c5'>".$row['Estatus']."</td>

                                                                </tr>";
                                                            }
                                                            $salida.="</tbody></table>";
                                               
                                       echo $salida;
                           $_SESSION['tabla']=$salida;
                }

                 catch(PDOException $e)
                {
                    print "Error: ".$e->getMessage()."<br>";
                    die();
                }
        
         break;
        
    case 'articulo':
     try
     {
     
     $salida="";
     $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
     (case Dictamen_Extenso when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus from articulo";
         
     if(isset($_POST['s'])||isset($_POST['e'])||isset($_POST['i']))
     {
      $status=$_POST['s'];
      $estado=$_POST['e'];
      $insti=$_POST['i'];
//        $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,a.Estado,a.Institucion,
//               (case r.Aceptado when 1 then 'Aceptado' when 0 then 'No Aceptado' end) as Estatus
//               from resumen as r inner join articulo as a on a.idArticulo=r.idArticulo where r.Aceptado='$status' and a.Estado='$estado' and a.Institucion='$insti'";
      if($status=='v' and $estado=='v' and $insti=='v')
      {
          
          $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
     (case Dictamen_Extenso when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
     from articulo";
      }
        else if($estado=='v' and $insti=='v')
        {
            $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Extenso  when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Dictamen_Extenso='$status'";
        }
         else if($insti=='v' and $status=='v')
        {
            $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Extenso when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Estado='$estado'";
        }
         else if($status=='v' and $estado=='v')
         {
             $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Extenso when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Institucion='$insti'";
         }
         else if($status=='v')
         {
             $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Extenso when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Estado='$estado' and Institucion='$insti'";
            
         }
         else if($estado=='v')
         {
              $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Extenso when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Dictamen_Extenso='$status' and Institucion='$insti'";
             
         }
         else if($insti=='v')
         {
             
              $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                 (case Dictamen_Extenso when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Dictamen_Extenso='$status' and Estado='$estado'";
         }
         else
         {
              $consulta="select Clave_articulo as Clave,Nombre_articulo as Nombre,Estado,Institucion,
                (case Dictamen_Extenso when 1 then 'Aceptado' when 0 then 'No Aceptado' else 'En revisión' end) as Estatus
                from articulo where Dictamen_Extenso='$status' and Estado='$estado' and Institucion='$insti'";
             
         }
       
      }
     
        $sql = $con->prepare($consulta);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql->fetchAll();
     
       $salida.="<table class='table table-hover' style='text-align: center;'>
                                                          <thead style='background-color: white; color: black;'>   
                                                            

                                                            <tr>
                                                                <th style='width: 70px;'>Clave</th>
                                                                <th style='width: 250px;'>Titulo Artículo</th>
                                                                <th style='width: 80px;'>Estado</th>
                                                                <th style='width: 200px;'>Institución</th>
                                                                <th style='width: 100px;'>Status</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                       
                                                            <tbody>"; 
                                                               
                                                          
                                                            foreach ($result as $row) 
                                                            {
                                                                $salida.="<tr>
                                                            
                                                                    
                                                                    <td id='c1'>".$row['Clave'] ."</td>
                                                                    <td id='c2'>".$row['Nombre']." </td>
                                                                    <td id='c3'>".$row['Estado']." </td>
                                                                    <td id='c4'>".$row['Institucion']." </td>
                                                                    <td id='c5'>".$row['Estatus']."</td>

                                                                </tr>";
                                                            }
                                                            $salida.="</tbody></table>";
                                                           
                                       echo $salida;
                       $_SESSION['tabla']=$salida;
                }

                 catch(PDOException $e)
                {
                    print "Error: ".$e->getMessage()."<br>";
                    die();
                }
        
         break;
        
         case 'usuario':
          try
          {
     
             $salida="";
             $consulta="select CONCAT(U.Nombres,' ',U.Apellido_paterno,' ',U.Apellido_Materno) As Nombre, U.Correo_Electronico As Correo, U.Telefono, 
(case TP.Caracter_tipo when 'A' then 'Administrador' when 'R' then 'Revisor' 
when 'E' then 'Comité editorial' when 'C' then 'Contacto' when 'F' then 'Financieros' end) as t_u From usuario as U
inner join usuario_tipo as UT on UT.Usuario = U.idUsuario
inner join tipo_usuario as TP on UT.TipoUsuario = TP.Id_Tipo_Usuario";
             if(isset($_POST['t']))
             {
              $t=$_POST['t'];
              if($t=='v')
              {
                    $consulta="select CONCAT(U.Nombres,' ',U.Apellido_paterno,' ',U.Apellido_Materno) As Nombre, U.Correo_Electronico As Correo, U.Telefono, 
(case TP.Caracter_tipo when 'A' then 'Administrador' when 'R' then 'Revisor' 
when 'E' then 'Comité editorial' when 'C' then 'Contacto' when 'F' then 'Financieros' end) as t_u From usuario as U
inner join usuario_tipo as UT on UT.Usuario = U.idUsuario
inner join tipo_usuario as TP on UT.TipoUsuario = TP.Id_Tipo_Usuario";
              }
                else
                {
                     $consulta="select CONCAT(U.Nombres,' ',U.Apellido_paterno,' ',U.Apellido_Materno) As Nombre, U.Correo_Electronico As Correo, U.Telefono, 
(case TP.Caracter_tipo when 'A' then 'Administrador' when 'R' then 'Revisor' 
when 'E' then 'Comité editorial' when 'C' then 'Contacto' when 'F' then 'Financieros' end) as t_u From usuario as U
inner join usuario_tipo as UT on UT.Usuario = U.idUsuario
inner join tipo_usuario as TP on UT.TipoUsuario = TP.Id_Tipo_Usuario
        where TP.Caracter_Tipo='$t'";
                    
                }
             
              }

                $sql = $con->prepare($consulta);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $result = $sql->fetchAll();

                $salida.="<table class='table table-hover' style='text-align: center'>
                                                         <thead style='background-color: white; color: black;'> 
                                                            

                                                            <tr>
                                                                <th style=' width: 60px;'>Nombres</th>
                                                                <th style=' width: 250px;'>Correo</th>
                                                                <th style=' width: 170px;'>Telefono</th>
                                                                <th style=' width: 100px;'>Tipo de usuario</th>
                                                               
                                                                
                                                            </tr>
                                                        </thead>
                                                      
                                                            <tbody>"; 
                                                               
                                                          
                                                            foreach ($result as $row) 
                                                            {
                                                                $salida.="<tr>
                                                            
                                                                    
                                                                    
                                                                    <td>".$row['Nombre']." </td>
                                                                    <td>".$row['Correo']."</td>
                                                                    <td>".$row['Telefono']."</td>
                                                                    <td>".$row['t_u']." </td>
                                                                   

                                                                </tr>";
                                                            }
                                                            $salida.="</tbody></table>";
                                       echo $salida;
                   $_SESSION['tabla']=$salida;
                }

                 catch(PDOException $e)
                {
                    print "Error: ".$e->getMessage()."<br>";
                    die();
                }
        
         break;
        
    case 'financiero':
        
        try
          {
     
             $salida="";
             $consulta="select r.idRecibo as Folio,group_concat(Clave_Articulo,'-',Nombre_Articulo separator '<br>') as Clave,
(case validado when 1 then 'Pagado' when 0 then 'No pagado' end) as Status from recibo_pago as r
inner join recibo_pago_detalle as rpd on r.idRecibo=rpd.idRecibo
inner join articulo as a on a.idArticulo=rpd.idArticulo
group by r.idRecibo";
             if(isset($_POST['f']))
             {
              $f=$_POST['f'];
              if($f=='v')
              {
                    $consulta="select r.idRecibo as Folio,group_concat(Clave_Articulo,'-',Nombre_Articulo separator '<br>') as Clave,
(case validado when 1 then 'Pagado' when 0 then 'No pagado' end) as Status from recibo_pago as r
inner join recibo_pago_detalle as rpd on r.idRecibo=rpd.idRecibo
inner join articulo as a on a.idArticulo=rpd.idArticulo
group by r.idRecibo";
              }
                else
                {
                     $consulta="select r.idRecibo as Folio,group_concat(Clave_Articulo,'-',Nombre_Articulo separator '<br>') as Clave,
(case validado when 1 then 'Pagado' when 0 then 'No pagado' end) as Status from recibo_pago as r
inner join recibo_pago_detalle as rpd on r.idRecibo=rpd.idRecibo
inner join articulo as a on a.idArticulo=rpd.idArticulo
 where Validado='$f' group by r.idRecibo";
                    
                }
             
              }

                $sql = $con->prepare($consulta);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $result = $sql->fetchAll();

                $salida.="<table class='table table-hover' style='text-align: center'>
                                                          <thead style='background-color: white; color: black;'>   
                                                            

                                                            <tr>
                                                                <th style=' width: 60px;'>Folio</th>
                                                                <th style=' width: 250px;'>Articulos</th>
                                                                <th style=' width: 100px;'>Status</th>
                                                               
                                                                
                                                            </tr>
                                                        </thead>
                                                      
                                                            <tbody>"; 
                                                               
                                                          
                                                            foreach ($result as $row) 
                                                            {
                                                                $salida.="<tr>
                                                            
                                                                    
                                                                    <td id='c1'>".$row['Folio'] ."</td>
                                                                    <td id='c2'>".$row['Clave']." </td>
                                                                    <td id='c3'>".$row['Status']." </td>
                                                                   

                                                                </tr>";
                                                            }
                                                            $salida.="</tbody></table>";
                                       echo $salida;
                   $_SESSION['tabla']=$salida;
                }

                 catch(PDOException $e)
                {
                    print "Error: ".$e->getMessage()."<br>";
                    die();
                }
        
}
}


?>