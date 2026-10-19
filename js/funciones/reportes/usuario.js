$(filtro("usuario"));
   function filtro(opcion,t)
    {
       
        $.ajax({
            url: 'reportes.php',
            type:'POST',
            dataType: 'html',
            data: {opcion:opcion,
                  t:t},
        
        })
       .done(function(r)
        {
		$('#t_usuarios').html(r);
	    })
	.fail(function()
    {
		console.log("error");
	});
    }
   
  $(document).on('change','#tipo_u', function()
    {
	
    filtro("usuario",$(this).val());
	
   });
    