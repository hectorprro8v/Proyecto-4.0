<?php
require '../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set("America/Mexico_City");
setlocale(LC_TIME, 'spanish'); 
$fecha=strftime("%d de %B del %Y");
$fechapdf=strftime("%y %m %d");
session_start();


     if(isset($_POST['opcion']))
      {
            $switch=$_POST['opcion'];
           
        
        switch ($switch)
            {
           case 'resumen':
             try
              { 
                $tabla=$_SESSION['tabla'];
                 $insti=$_POST['insti'];
                 $estado=$_POST['estado'];
                 $status=$_POST['status'];
                 switch($status)
                 {
                     case 'v': $s="";break; case '1':$s="aceptados"; break;
                     case '0': $s="no Aceptados"; break;
                 }
                  switch($estado)
                 {
                     case 'v': $e="";break; 
                     case ($estado!='v'): $e=" del estado de ".$estado.""; break;
                 }
                  switch($insti)
                 {
                     case 'v': $i="";break; 
                     case ($insti!='v'): $i=" e institución: ".$insti.""; break;
                 }
                ob_start(); 
                ?>
                 <style type='text/css'>
                    #fot{background-color:#008CB0; text-align: center;}
                    p{font-family: Arial; font-size: 11px;}
                    h2,h3{
                        float:left;
                        
                    }
                   table,th,td,tr{border: black ;  border-collapse: collapse;}
                    
                    #c1{text-align: center;height: -10%; width: 5%; } 
                    #c2{text-align: center;height: -20%; width: 35%; }
                    #c3{text-align: center;height: -10%; width: 10%; }
                    #c4{text-align: center;height: -10%; width: 10%; } 
                    #c5{text-align: center;height: -10%; width: 10%; }
                    </style>
                    <page backtop='25mm' backbottom='17mm' backleft='10mm' backright='10mm'>
                    <page_header>
                        <div align='center'>
                            <img class='imagen' src='../img/Logo3.png' width='500' height='110'/>
                        </div>
                    </page_header>
                    <page_footer>
                               <div id='fot'>
                                 <b align='center'>
                                   Insituto Tecnológico Superior de Lerdo<br>
                                Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                                <br>C.P. 35150 Cd. Lerdo, Dgo
                                <br>Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
                                 </b><br><br>
                                
                               </div>
                    </page_footer>
                        <?php
                 echo "
                     <div style='text-align: right;'>
                                <p>Ciudad Lerdo, Durango a ".utf8_encode($fecha)."</p>
                      </div>
                      <div style='position: relative;'><h4>Reporte de resúmenes ".$s."".$e."".$i."".$todos."</h4></div>
                
                     <div>
                      ".$tabla."
                      </div>"; 
                    
                    ?>
                        
                
 
         </page>
   <?php
                 
    $html=ob_get_contents(); 
    ob_clean();
    $pdf = new  Html2Pdf('P','LETTER','es','true','UTF-8',array(0, 0, 0, 0));
    $pdf->pdf->SetDisplayMode('fullpage');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true)");
    $pdf->output("ReporteResumenes".$fechapdf.".pdf");
//   
    }
     catch(PDOException $e)
    {
        print "Error: ".$e->getMessage()."<br>";
        die();
    }
                break;
                case 'articulos':
             try
              { 
                $tabla=$_SESSION['tabla'];
//                 $tabla=$_POST['datos'];
                 $insti=$_POST['insti'];
                 $estado=$_POST['estado'];
                 $status=$_POST['status'];
                 switch($status)
                 {
                     case 'v': $s="";break; case '1':$s="aceptados"; break;
                     case '0': $s="no aceptados"; break;
                 }
                  switch($estado)
                 {
                     case 'v': $e="";break; 
                     case ($estado!='v'): $e=" del estado de ".$estado.""; break;
                 }
                  switch($insti)
                 {
                     case 'v': $i="";break; 
                     case ($insti!='v'): $i=" e institución: ".$insti.""; break;
                 }
                 
    
                ob_start(); 
                 ?>
                <style type='text/css'>
                    #fot{background-color:#008CB0; text-align: center;}
                    p{font-family: Arial; font-size: 11px;}
                    h2,h3{
                        float:left;
                    }
                     table,th,td,tr{border: black ;  border-collapse: collapse;}
                    
                    #c1{text-align: center; height: -10%; width: 5%; } 
                    #c2{text-align: center; height: -10%; width: 35%; }
                    #c3{text-align: center; height: -10%; width: 10%; }
                    #c4{text-align: center; height: -10%; width: 10%; } 
                    #c5{text-align: center;height: -10%; width: 10%; }
                    </style>
                    <page backtop='25mm' backbottom='17mm' backleft='10mm' backright='10mm'>
                    <page_header>
                     <div align='center'>
                            <img class='imagen' src='../img/Logo3.png' width='500' height='110'/>
                        </div>
                    </page_header>
                         <page_footer>
                               <div id='fot'>
                                 <b align='center'>
                                   Insituto Tecnológico Superior de Lerdo<br>
                                Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                                <br>C.P. 35150 Cd. Lerdo, Dgo
                                <br>Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
                                 </b><br><br>
                                
                               </div>
                    </page_footer>
                        
                        <?php
                     echo "<div style='position: relative; text-align: right;'>
                                <p>Ciudad Lerdo, Durango a ".utf8_encode($fecha)."</p>
                      </div>
                      <div style='position: relative; top: 30px;'><h4>Reporte de artículos ".$s."".$e."".$i."".$todos."</h4></div>
                    <div style='top: 30px;'>                                                                
                                                                                                  
                      ".$tabla."
                      </div>";
               
                      ?>
                 
         </page>
                 <?php
    $html=ob_get_contents(); 
    ob_clean();
    $pdf = new Html2Pdf('P','LETTER','es','true','UTF-8',array(0, 0, 0, 0));
    $pdf->pdf->SetDisplayMode('fullpage');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true)"); 
    $pdf->output("ReporteArticulos".$fechapdf.".pdf");
//   
    }
     catch(PDOException $e)
    {
        print "Error: ".$e->getMessage()."<br>";
        die();
    }
                break;
           case 'usuarios':
             try
              { 
                $tabla=$_SESSION['tabla'];
                 $t=$_POST['t'];
                 
                 switch($t)
                 {   
                    
                     case 'A':  
                         $titulo="Administrador";
                         break;
                     case 'R':
                          $titulo="Revisor";
                         break;
                     case 'E':
                          $titulo="Comité Editorial";
                         break;
                     case 'C':  
                          $titulo="Contacto";
                         break;
                     case 'F':
                          $titulo="Financieros";
                         break;
                     case 'v':
                          $titulo="Todos los usuarios";
                         break;
                     
                 }
                ob_start(); 
                 ?>
                <style type='text/css'>
                    #fot{background-color:#008CB0; text-align: center;}
                    p{font-family: Arial; font-size: 11px;}
                    h2,h3{
                        float:left;
                    }
                        table,th,td,tr{border: black ;  border-collapse: collapse;}
                    
                    #c1{text-align: center;height: -10%; width: 5%; } 
                    #c2{text-align: center;height: -10%; width: 35%; }
                    #c3{text-align: center;height: -10%; width: 10%; }
                    </style>
                    <page backtop='25mm' backbottom='17mm' backleft='15mm' backright='15mm'>
                    <page_header>
                    <div align='center'>
                            <img class='imagen' src='../img/Logo3.png' width='500' height='110'/>
                        </div>   
                    </page_header>
             
                      <page_footer>
                               <div id='fot'>
                                 <b align='center'>
                                   Insituto Tecnológico Superior de Lerdo<br>
                                Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                                <br>C.P. 35150 Cd. Lerdo, Dgo
                                <br>Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
                                 </b><br><br>
                                
                               </div>
                    </page_footer>
                        <?php
                    echo "<div style='position: relative; text-align: right;'>
                                <p>Ciudad Lerdo, Durango a ".utf8_encode($fecha)."</p>
                      </div><div style='position: relative; top: 30px;'><h4>Reporte de usuarios: (".$titulo.").</h4></div>
                      <div style='padding-right: 30px; top: 30px;'>
                      ".$tabla."
                      </div>";
                  ?>
         </page>
       <?php          
                 
    $html=ob_get_contents(); 
    ob_clean();
    $pdf = new Html2Pdf('P','LETTER','es','true','UTF-8',array(0, 0, 0, 0));
    $pdf->pdf->SetDisplayMode('fullpage');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true)"); 
    $pdf->output("ReporteUsuarios".$fechapdf.".pdf");
//   
    }
     catch(PDOException $e)
    {
        print "Error: ".$e->getMessage()."<br>";
        die();
    }
                break;
          case 'fin':
             try
              { 
                $tabla=$_SESSION['tabla'];
                 $v=$_POST['validado'];
                 switch($v)
                 {   
                    
                     case 'v':  
                         $validado="Todos";
                         break;
                     case '1':
                          $validado="Pagados";
                         break;
                     case '0':
                          $validado="No pagados";
                         break;
                     
                     
                 }
                 
              
                ob_start(); 
           ?>
                   <style type='text/css'>
                    #fot{background-color:#008CB0; text-align: center;}
                    p{font-family: Arial; font-size: 11px;}
                    h2,h3{
                        float:left;
                    }
                        table,th,td,tr{border: black ;  border-collapse: collapse;}
                    
                    #c1{text-align: center;height: -10%; width: 5%; } 
                    #c2{text-align: center;height: -10%; width: 60%; }
                    #c3{text-align: center;height: -10%; width: 10%; }
                    </style>
                    <page backtop='25mm' backbottom='17mm' backleft='15mm' backright='15mm'>
                    <page_header>
                    <div align='center'>
                            <img class='imagen' src='../img/Logo3.png' width='500' height='110'/>
                        </div>     
                    </page_header>
             
                      <page_footer>
                               <div id='fot'>
                                 <b align='center'>
                                   Insituto Tecnológico Superior de Lerdo<br>
                                Av. Tecnológico N 1555 Sur Periferico Gomez Lerdo Km. 14.5
                                <br>C.P. 35150 Cd. Lerdo, Dgo
                                <br>Tels. 01 (871) 725 23 71, 725 57 79, 725 58 02
                                 </b><br><br>
                                
                               </div>
                    </page_footer>
                        <?php
                    echo "<div style='position: relative;  text-align: right;'>
                                <p>Ciudad Lerdo, Durango a ".utf8_encode($fecha)."</p>
                      </div>
                      <div style='position: relative; top: 30px;'><h4>Reporte de financieros: recibos (".$validado.").</h4></div>
                      <div style='padding-left: 10px; top: 30px;'>
                      ".$tabla."
                      </div>";
                  ?>
         </page>
       <?php          
    $html=ob_get_contents(); 
    ob_clean();
    $pdf = new Html2Pdf('P','LETTER','es','true','UTF-8',array(0, 0, 0, 0));
    $pdf->pdf->SetDisplayMode('fullpage');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true)"); 
    $pdf->output("ReporteFinancieros".$fechapdf.".pdf");
//   
    }
     catch(PDOException $e)
    {
        print "Error: ".$e->getMessage()."<br>";
        die();
    }
                break;
                
                
                
        }
//        }
        
     }
?>