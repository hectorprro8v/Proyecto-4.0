function validar_registro(){
    var correo, contrasena, repite_contrasena, expresion;
    
    correo = document.getElementById("correo").value;
    contrasena = document.getElementById("contrasena").value;
    repite_contrasena = document.getElementById("repite_contrasena").value;
    
    expresion = /\w+@\w+\.+[a-z]/;
    
    if(correo=="" || contrasena=="" || repite_contrasena==""){
        alertify.error("Debes ingresar todos los campos.");
        return false;
    }
    else if(contrasena != repite_contrasena){
        alertify.error("Las contraseñas no coinsiden, verifica e intenta nuevamente.");
        return false;
    }
    else if(correo.length > 100){
        alertify.error("El correo es demaciado largo.");
        return false;
    }
    else if(correo.length > 65){
        alertify.error("El correo es demaciado largo.");
        return false;
    }
    else if(correo.length < 5){
        alertify.error("El correo es demaciado corto.");
        return false;
    }
    else if(!expresion.test(correo)){
        alertify.error("El formato del correo no es válido.");
        return false;
    }
}