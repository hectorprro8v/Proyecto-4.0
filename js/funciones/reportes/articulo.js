$(filtro("articulo"));

   function filtro(opcion,s,e,i)
    {
       
        $.ajax({
            url: 'reportes.php',
            type:'POST',
            dataType: 'html',
            data: {opcion:opcion,
                  s:s,
                  e:e,
                  i:i},
        
        })
       .done(function(r)
        {
		$('#datos').html(r);
	    })
	.fail(function()
    {
		console.log("error");
	});
    }

$(document).ready(function()
{    
    $("#status").change(function()
    {
              
             filtro("articulo",$(this).val(),$('#estado').val(),$('#insti').val());
    });
	$("#estado").change(function()
    {
              
             filtro("articulo",$('#status').val(),$(this).val(),$('#insti').val());
	});
	$("#insti").change(function()
    {
             
             filtro("articulo",$('#status').val(),$('#estado').val(),$(this).val());
	});
});