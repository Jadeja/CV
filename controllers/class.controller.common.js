function checkLogin() {	
	$.ajax({
		type: 'POST',
		dataType: "json",
		data: '',
		
		//Always external URL in an App
		//Remember to change this URL to your OWN path!
		url: 'http://localhost/CVCoach/models/class.model.security_fun.php?action=check',
				
		success: function(data)
		{			
		   if(data.logged==false)
		   {		
			   $('#msg').empty();
			   $('<div></div>').html(data.message).appendTo('#msg');																			
			   $.mobile.changePage('#home');		   
		   }		   	   			
		},
		error: function(e)
		{		
			$.mobile.loading('hide');
			$.mobile.changePage('#home')
		}	
	 });	 
}