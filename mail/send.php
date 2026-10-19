<?php
include "class.phpmailer.php";
include "class.smtp.php";

$email_user = "revistacid@itslerdo.edu.mx";
$email_password = "sbjh xlan pnvf ttoa";
$the_subject = "CONTRASEÑA DE USUARIO";
$address_to = "revistacid@itslerdo.edu.mx"; //$_POST['email_reg']
$from_name = "REVISTA CID TECLERDO";
$contrasenaa =
$phpmailer = new PHPMailer();

// ---------- datos de la cuenta de Gmail -------------------------------
$phpmailer->Username = $email_user;
$phpmailer->Password = $email_password; 
//-----------------------------------------------------------------------
// $phpmailer->SMTPDebug = 1;
$phpmailer->SMTPSecure = 'ssl';
$phpmailer->Host = "smtp.gmail.com"; // GMail
$phpmailer->Port = 465;
$phpmailer->IsSMTP(); // use SMTP
$phpmailer->SMTPAuth = true;

$phpmailer->setFrom($phpmailer->Username,$from_name);
$phpmailer->AddAddress($address_to); // para quien sera enviado // recipients email

$phpmailer->Subject = $the_subject;	
$phpmailer->Body .="<h1 style='color:#3498db;'>Contaseña para ingresar al sistema SICSA-CID</h1>";
$phpmailer->Body .= "<p>para entrar al sistema necesitaras tu correo electronico y la contraeña que te enviamos</p>";
$phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
$phpmailer->IsHTML(true);

if (!$phpmailer->send()) {
    echo "Error: " . $phpmailer->ErrorInfo;
} else {
    echo "Correo enviado!";
} ?>