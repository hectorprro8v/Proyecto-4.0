function agregar_autor(id, nombres, apaterno, amaterno, institucion, email, orcid, cvu, principal){
    var autores="id="+id+"&nombres="+nombres+"&apaterno="+apaterno+"&amaterno="+amaterno+"&institucion="+institucion+"&email="+email+"&orcid="+orcid+"&cvu="+cvu+"&principal="+principal;
    $.ajax({
        type: "POST",
        url: "inserta_autor.php",
        data: autores,
        success:function(r){
            if(r==1){
                alertify.success("Autor añadido...")
            }
            else
            {
                alertify.danger("Autor no añadido...")
            }
        }
    });
}

function insertar_resumen(titulo, linea, institucion, pais, estado, ciudad, resumen, palabras, abstract, keywords){
    var resumen="titulo="+titulo+
        "&linea="+linea+
        "&institucion="+institucion+
        "&pais="+pais+
        "&estado="+estado+
        "&ciudad="+ciudad+
        "&resumen="+resumen+
        "&palabras="+palabras+
        "&abstract="+abstract+
        "&keywords="+keywords;
    
    $.ajax({
        type:"POST",
        url:"inserta_resumen.php",
        data: resumen,
        success:function(r){
            if(r==1){
                alertify.success("Resumen agregado, a continuación debes ingresar los autores del mismo...")
            }
            else
            {
                alertify.danger("Ocurrió un error inesperado, el resumen no se ha agregado...")
            }
        }
    });
}