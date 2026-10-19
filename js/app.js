var ajaxProveedores = function(accion,url,formulario){
    //# alucion a un id de un formulario 
    var datos = $('#'+formulario).serializeArray(); //todos los datos en un arreglo
    
    datos.push({name:'accion',value:accion});//agrega mas datos
    //diccionario de datos
    $.ajax({
        url:url,
        data:datos,
        type:"POST",//se envia por el metodo que tiene el formulario.
        datatype:"JSON",
        success:function(response){
            if(response.proveedores !== null){
                    $.each(response.proveedores,function(index,registro){
                        $('#tablaProveedores tbody').append(
                            "<tr>"+
                            "<td>"+registro.id+"</td>"+
                            "<td>"+registro.nombre+"</td>"+
                            "<td>"+registro.apaterno+"</td>"+
                            "<td>"+registro.amaterno+"</td>"+
                            "<td>"+registro.direccion+"</td>"+
                            "<td>"+registro.email+"</td>"+
                            "<td>"+registro.pedido+"</td>"+
                            "</tr>"
                        );
                    });
                }
        } //funcion destino de regreso para saber que hacer con el que fue mandado por el formulario //funcion anónima
    });
    
}