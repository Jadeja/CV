$(document).on('click','#test',function(){
	console.log('button pressed');
	$('button').prop('disabled', true);
	//Show Page Loading Message
	$.mobile.loading('show', {text: 'Logging In To Dashboard - Please Wait',textVisible: true,theme: 'a'});	
	
	if($('#settings').length == '')
	{
		$('#settings').html('');
		$.get('views/settings.html',function(data) {									
			var htmlData = data;						
			$('<div data-role="page" id="settings">').html(htmlData).appendTo('body');																					
			$.mobile.loading('show', {text: 'Loading Your CMS Dashboard',textVisible: true,theme: 'a'});											
			$('button').prop('disabled', false);	
			$.mobile.loading('hide');
			$.mobile.changePage('#settings');																	
			});
	}
	$('button').prop('disabled', false);	
	$.mobile.loading('hide');
	$.mobile.changePage('#settings');
});//end document load

$(document).on('submit','form#settingForm',function(){
	$('button').prop('disabled', true);
	var postData = $('#settingForm').serialize();
		
	//Show Page Loading Message
	$.mobile.loading('show', {text: 'Logging In To Dashboard - Please Wait',textVisible: true,theme: 'a'});	
	
	//*****Ajax JSON call will SEND and RECEIVE data back from the model****
	$.ajax({
		type: 'POST',
		dataType: "json",
		data: postData,
		
		//Always external URL in an App
		//Remember to change this URL to your OWN path!
		url: 'http://localhost/CVCoach/models/class.model.settings.php?action=write',
				
		success: function(data)
		{			
			if (data.success == true)
		   {	//data from JSON Array
			   if(data.action=="write")
			   {		
					//Remove any existing data from the DOM
					$('#msg').empty();
					$('#web').empty();	
					$.mobile.loading('hide');
					$('<div></div>').html(data.html).appendTo('#msg');									   													   				   		   
			   }
			   else
			   {
				   $.mobile.loading('hide');
				   $('button').prop('disabled', false);
		  		   $('#msg').empty();
                   $('<div></div>').html(data.html).appendTo('#msg');			 		   				   					      			   				   
			   }		   			
           }//close data.success				
		},
		error: function(e)
		{		
			alert('There was an error handling your login authentication!'+e);
			console.log(e);
			$('button').prop('disabled', false);
			$.mobile.loading('hide');
		}	
	 });
		
	return false;

});//end form submit