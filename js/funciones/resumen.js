
    $('#tabla tr').on('click', function()
    {
     var dato = $(this).find('#ida').html();
     var dato1 = $(this).find('#btnj').val();                                         
     $('#clave').val(dato);
     $('#just1').val(dato1);
     });