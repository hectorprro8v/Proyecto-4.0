$(filtro("resumen"));

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
              
             filtro("resumen",$(this).val(),$('#estado').val(),$('#insti').val());
    });
	$("#estado").change(function()
    {
              
             filtro("resumen",$('#status').val(),$(this).val(),$('#insti').val());
	});
	$("#insti").change(function()
    {
             
             filtro("resumen",$('#status').val(),$('#estado').val(),$(this).val());
	});
});
$(document).ready(function()
{
   $('#reporte_res').on('click', function()
    {
    
//       var datos=document.getElementById("datos").innerHtml;
//       var opcion="resumen";
//       var datos = document.getElementById("datos").innerHTML;
////       var datos = el.textContent || el.innerText;
//       var opcion="resumen";
//     
//       $.ajax({
//            url: '../imprimir.php',
//            type:'POST',
//           beforeSend:function()
//           {
//               
//           },
//          
//            success:function(r)
//           {
//                
//                alert(r);
//               window.open('../imprimir.php', '_blank');
//               
//           },
//            
//             data: {opcion:opcion,
//                   datos:datos
//                  },
//           
//        
//        })
         
  });
   
     
     
});

