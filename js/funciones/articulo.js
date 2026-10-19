$('#tabla tr').on('click', function()
 {
                                                     
var m = $(this).find('#mods').html();
var o = $(this).find('#obs').html();
var dato=$(this).find('#ida').html();
                                                       
$('#dictamen').val(dato);
$('#c').val(dato);
$('#m').val(m);
$('#o').val(o);
                                                       
});
                                                   
                                                           
                                                   