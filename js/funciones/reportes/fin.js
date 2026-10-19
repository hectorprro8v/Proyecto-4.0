$(filtro("financiero"));
   function filtro(opcion,f)
    {
       
        $.ajax({
            url: 'reportes.php',
            type:'POST',
            dataType: 'html',
            data: {opcion:opcion,
                  f:f},
        
        })
       .done(function(r)
        {
		$('#t_financiero').html(r);
	    })
	.fail(function()
    {
		console.log("error");
	});
    }
   
  $(document).on('change','#validado', function()
    {
	
    filtro("financiero",$(this).val());
	
   });