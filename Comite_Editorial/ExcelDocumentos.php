<?php
require '../Classes/PHPExcel.php';
 $contrasena = "pbdS1c$*23_ITSL";
 $usuario =  "ubdsicsacid";
 $nombrebd = "bdsicsacid";



 try {
 	$conexion = new PDO('mysql:host=sicsacid.itslerdo.edu.mx;dbname='. $nombrebd, $usuario, $contrasena);
 	
 } catch (Exception $e) {
 	echo "Ocurri� algo con la basde de datos:" . $e->getMessage();
 }
 error_reporting(E_ALL);
 session_start();

 
 $objPHPExcel=new PHPExcel();

//Pagina 1
    $sql="SELECT Nombres, Apellido_Paterno, Apellido_Materno from usuario inner join usuario_tipo On usuario.idUsuario=usuario_tipo.Usuario where TipoUsuario=2";
    $resultado = $conexion->prepare($sql);
    $resultado->execute();

    $fila=3; 

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Comite Editorial");

    
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);

    $sheet = $objPHPExcel->getActiveSheet();
    $sheet->setCellValueByColumnAndRow(0, 1, "Comité Editorial");
    $sheet->mergeCells('A1:C1');
    $sheet->getRowDimension(1)->setRowHeight(20);
    $sheet->getStyle('A1:C1')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
    $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );

    $objPHPExcel->getActiveSheet()->setCellValue("A2",'Nombre(s)');
    $objPHPExcel->getActiveSheet()->setCellValue("B2",'Apellido Paterno');
    $objPHPExcel->getActiveSheet()->setCellValue("C2",'Apellido Materno');

    $sheet->getStyle('A2')->getAlignment()->applyFromArray(
        array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
    $sheet->getStyle('b2')->getAlignment()->applyFromArray(
        array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
    $sheet->getStyle('c2')->getAlignment()->applyFromArray(
        array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));

    $sheet->getRowDimension(2)->setRowHeight(30);

    $sheet->getStyle('A1:C1')->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '2E86C1')
                )
            )
        );

        $sheet->getStyle('A2:C2')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '3498DB')
                    )
                )
            );

    $sheet->getStyle('A2:C999')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle("A2:C2")->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('A2:C999')
        ->getAlignment()->setWrapText(true); 

        $styleArray = array(
        'borders' => array(
            'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);

        while($row=$resultado->fetch(PDO::FETCH_ASSOC))//llenado
        {
            $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);
            $objPHPExcel->getActiveSheet()->setCellValue("A".$fila,utf8_encode($row['Nombres']));
            $objPHPExcel->getActiveSheet()->setCellValue("B".$fila,utf8_encode($row['Apellido_Paterno']));
            $objPHPExcel->getActiveSheet()->setCellValue("C".$fila,utf8_encode($row['Apellido_Materno']));
            
            $fila++;
        }

//Pagina 2

    $sql="SELECT Art.Clave_Articulo, Art.Nombre_Articulo, Aut.idArticulo, Aut.GradoEstudio, Aut.Nombres, Aut.Apellido_Paterno, Aut.Apellido_Materno, Aut.Principal FROM articulo as Art inner join autores as Aut On Art.idArticulo=Aut.idArticulo";
    $resultado = $conexion->prepare($sql);
    $resultado->execute();

    $fila=4;

    $objPHPExcel->createSheet(); 
    $objPHPExcel->setActiveSheetIndex(1);
    $objPHPExcel->getActiveSheet()->setTitle("Articulos 1");

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(80);

    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

    $sheet = $objPHPExcel->getActiveSheet();
    $sheet->setTitle("Articulo_1"); 
    $sheet->setCellValueByColumnAndRow(0, 1, "Articulo");
    $sheet->mergeCells('A1:H1');
    $sheet->getRowDimension(1)->setRowHeight(30);
    $sheet->getStyle('A1')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );

    $sheet->setCellValueByColumnAndRow(0, 2, "Clave");
    $sheet->mergeCells('A2:A3');
    $sheet->getStyle('A2')->getAlignment()->applyFromArray(
        array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
    $objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setBold( true );

    $sheet->setCellValueByColumnAndRow(1, 2, "Nombre Del Articulo");
    $sheet->mergeCells('B2:B3');
    $sheet->getStyle('B2')->getAlignment()->applyFromArray(
        array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
    $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold( true );

    $sheet->setCellValueByColumnAndRow(2, 2, "Autor(es) Principales");
    $sheet->mergeCells('C2:F2');
    $sheet->getRowDimension(2)->setRowHeight(20);
    $sheet->getStyle('C2')->getAlignment()->applyFromArray(
        array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
    $objPHPExcel->getActiveSheet()->getStyle("C2")->getFont()->setBold( true );

    $objPHPExcel->getActiveSheet()->setCellValue('C3','Titulo');
    $objPHPExcel->getActiveSheet()->setCellValue('D3','Apellido Paterno');
    $objPHPExcel->getActiveSheet()->setCellValue('E3','Apellido Materno');
    $objPHPExcel->getActiveSheet()->setCellValue('F3','Nombre(s)');

    $sheet->setCellValueByColumnAndRow(6, 2, "Colaboradores");
    $sheet->mergeCells('G2:I2');
    $sheet->getStyle('G2')->getAlignment()->applyFromArray(
        array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
    $objPHPExcel->getActiveSheet()->getStyle("G2")->getFont()->setBold( true );

    $objPHPExcel->getActiveSheet()->setCellValue('G3','Apellido Paterno');
    $objPHPExcel->getActiveSheet()->setCellValue('H3','Apellido Materno');
    $objPHPExcel->getActiveSheet()->setCellValue('I3','Nombre(s)');

    $sheet->getStyle('A2:I2')->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C0392B')
                )
            )
        );
    $sheet->getStyle('A3:I3')->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C0392B')
                )
            )
        );
        
    $sheet->getStyle('A1:I1')->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '922B21')
                )
            )
        );

    $sheet->getStyle('A2:I999')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle("A2:I2","A3:I3")->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('A2:I999')
        ->getAlignment()->setWrapText(true); 

        $styleArray = array(
        'borders' => array(
            'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);

        while($row=$resultado->fetch(PDO::FETCH_ASSOC))//llenado
        {
            $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(40);

            if($row['Principal']==1){

                $objPHPExcel->getActiveSheet()->setCellValue("A".$fila,$row['Clave_Articulo']);
                $objPHPExcel->getActiveSheet()->setCellValue("B".$fila,utf8_encode($row['Nombre_Articulo']));
                $objPHPExcel->getActiveSheet()->setCellValue("C".$fila,utf8_encode($row['GradoEstudio']));
                $objPHPExcel->getActiveSheet()->setCellValue("D".$fila,utf8_encode($row['Apellido_Paterno']));
                $objPHPExcel->getActiveSheet()->setCellValue("E".$fila,utf8_encode($row['Apellido_Materno']));
                $objPHPExcel->getActiveSheet()->setCellValue("F".$fila,utf8_encode($row['Nombres']));
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue("G".$fila,utf8_encode($row['Apellido_Paterno']));
                $objPHPExcel->getActiveSheet()->setCellValue("H".$fila,utf8_encode($row['Apellido_Materno']));
                $objPHPExcel->getActiveSheet()->setCellValue("I".$fila,utf8_encode($row['Nombres']));
            }
        
            $fila++;
        }

//Pagina 3
        $sql="SELECT Art.Clave_Articulo, Art.Nombre_Articulo, Aut.idArticulo, Aut.GradoEstudio, Aut.Nombres, Aut.Apellido_Paterno, Aut.Apellido_Materno, Aut.Principal FROM articulo as Art inner join autores as Aut On Art.idArticulo=Aut.idArticulo";
        $resultado = $conexion->prepare($sql);
        $resultado->execute();
       
        $fila=4;
       
        $objPHPExcel->createSheet(); 
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet()->setTitle("Articulos 2");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
       
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
       
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
       
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setTitle("Articulo_2"); 
        $sheet->setCellValueByColumnAndRow(0, 1, "Articulo");
        $sheet->mergeCells('A1:H1');
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
       
        $sheet->setCellValueByColumnAndRow(0, 2, "Clave");
        $sheet->mergeCells('A2:A3');
        $sheet->getStyle('A2')->getAlignment()->applyFromArray(
            array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setBold( true );
       
        $sheet->setCellValueByColumnAndRow(1, 2, "Nombre Del Articulo");
        $sheet->mergeCells('B2:B3');
        $sheet->getStyle('B2')->getAlignment()->applyFromArray(
            array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold( true );
       
        $sheet->setCellValueByColumnAndRow(2, 2, "Autor(es) Principales");
        $sheet->mergeCells('C2:F2');
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getStyle('C2')->getAlignment()->applyFromArray(
            array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle("C2")->getFont()->setBold( true );
       
        $objPHPExcel->getActiveSheet()->setCellValue('C3','Titulo');
        $objPHPExcel->getActiveSheet()->setCellValue('D3','Nombre(s)');
        $objPHPExcel->getActiveSheet()->setCellValue('E3','Apellido Paterno');
        $objPHPExcel->getActiveSheet()->setCellValue('F3','Apellido Materno');
       
        $sheet->setCellValueByColumnAndRow(6, 2, "Colaboradores");
        $sheet->mergeCells('G2:I2');
        $sheet->getStyle('G2')->getAlignment()->applyFromArray(
            array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle("G2")->getFont()->setBold( true );
       
        $objPHPExcel->getActiveSheet()->setCellValue('G3','Nombre(s)');
        $objPHPExcel->getActiveSheet()->setCellValue('H3','Apellido Paterno');
        $objPHPExcel->getActiveSheet()->setCellValue('I3','Apellido Materno');
       
        $sheet->getStyle('A2:I2')->applyFromArray(
           array(
               'fill' => array(
                   'type' => PHPExcel_Style_Fill::FILL_SOLID,
                   'color' => array('rgb' => 'C0392B')
                   )
               )
           );
        $sheet->getStyle('A3:I3')->applyFromArray(
           array(
               'fill' => array(
                   'type' => PHPExcel_Style_Fill::FILL_SOLID,
                   'color' => array('rgb' => 'C0392B')
                   )
               )
           );
           
        $sheet->getStyle('A1:I1')->applyFromArray(
           array(
               'fill' => array(
                   'type' => PHPExcel_Style_Fill::FILL_SOLID,
                   'color' => array('rgb' => '922B21')
                   )
               )
           );
       
        $sheet->getStyle('A2:I999')->getAlignment()->applyFromArray(
           array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
       
           $objPHPExcel->getActiveSheet()->getStyle("A2:I2","A3:I3")->getFont()->setBold( true );
       
           $objPHPExcel->getActiveSheet()->getStyle('A2:I999')
           ->getAlignment()->setWrapText(true); 
       
            $styleArray = array(
             'borders' => array(
                 'allborders' => array(
                         'style' => PHPExcel_Style_Border::BORDER_THIN
                     )
                 )
             );
       
           $objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);
       
           while($row=$resultado->fetch(PDO::FETCH_ASSOC))//llenado
           {
               $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(40);
       
               if($row['Principal']==1){
       
                   $objPHPExcel->getActiveSheet()->setCellValue("A".$fila,$row['Clave_Articulo']);
                   $objPHPExcel->getActiveSheet()->setCellValue("B".$fila,utf8_encode($row['Nombre_Articulo']));
                   $objPHPExcel->getActiveSheet()->setCellValue("C".$fila,utf8_encode($row['GradoEstudio']));
                   $objPHPExcel->getActiveSheet()->setCellValue("D".$fila,utf8_encode($row['Apellido_Paterno']));
                   $objPHPExcel->getActiveSheet()->setCellValue("E".$fila,utf8_encode($row['Apellido_Materno']));
                   $objPHPExcel->getActiveSheet()->setCellValue("F".$fila,utf8_encode($row['Nombres']));
               }else{
                   $objPHPExcel->getActiveSheet()->setCellValue("G".$fila,utf8_encode($row['Apellido_Paterno']));
                   $objPHPExcel->getActiveSheet()->setCellValue("H".$fila,utf8_encode($row['Apellido_Materno']));
                   $objPHPExcel->getActiveSheet()->setCellValue("I".$fila,utf8_encode($row['Nombres']));
               }
           
               $fila++;
           }

    header("Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetnl.sheet");
    header('Content-Disposition: attaxhment;filename="Documentos.xlsx"');//cambiar el nombre del archivo 
    header('Cache-Control: max-age=0');

    
    $objWriter=new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save('php://output');
?>
