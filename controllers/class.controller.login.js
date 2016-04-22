$(document).ready(function() {
console.log('controller linked');

$('form#loginForm').submit(function(){
	
	console.log('button pressed');
	$('button').prop('disabled', true);
	var postData = $('#loginForm').serialize();
		
	//Show Page Loading Message
	$.mobile.loading('show', {text: 'Logging In To Dashboard - Please Wait',textVisible: true,theme: 'a'});	
	
	//*****Ajax JSON call will SEND and RECEIVE data back from the model****
	$.ajax({
		type: 'POST',
		dataType: "json",
		data: postData,
		
		//Always external URL in an App
		//Remember to change this URL to your OWN path! http://localhost/CVCoach/models
		url: 'http://localhost/CVCoach/models/class.model.login.php?action=login',
				
		success: function(data)
		{			
			if (data.success == true)
		   {	//data from JSON Array
			   if(data.action=="login")
			   {	
					//Remove any existing data from the DOM
					$('#msg').empty();
					$('#loginEmail').val('');
					$('#loginPassWord').val('');	
					$('button').prop('disabled', false);															
				   //Programmatically change page					   	
					if(data.newUser == true)
					getPage('analyse');
					else							   
					dashboard(data.name);				   		   
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

});//end document load

function dashboard(name)
{
	
	$.get('views/newdashboard.html',function(data) {									
		var htmlData = data;						
		$('<div data-role="page" id="newdashboard">').html(htmlData).appendTo('body').trigger( "create" );;			
		$('<span class="ui-btn-right" id="displayName">Howdy '+ name +'</span>').appendTo("#dName");																						
		$.mobile.loading('show', {text: 'Loading Your CMS Dashboard',textVisible: true,theme: 'a'});					
		$.mobile.loading('hide');
		$('button').prop('disabled', false);
		$.mobile.changePage('#newdashboard');															
		});				  
}