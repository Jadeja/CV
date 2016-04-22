$(document).ready(function() {

  $('#registerUser').submit(function(){
  var postData = $(this).serialize();
console.log(postData);
 $.mobile.loading('show', {text: 'Registering New Account - Please Wait',textVisible: true,theme: 'a'});  
  //*****Ajax JSON call will SEND and RECEIVE data back from the model****
	  $.ajax({
		  type: 'POST',
		  dataType: "json",
		  data: postData,
		  
//Always external URL in an App
url:  'http://localhost/CVCoach/models/class.model.registerUser.php?action=register',
		  
		  success: function(data){
			  if(data.success == true)
			  {
				$('#msg').val('');
				$('#firstN').val('');
				$('#lastN').val('');
				$('#email').val('');
				$('#PassWord').val('');  			  
			 	$.mobile.loading('hide');	  
				$('.msg').val('');
			 	$('<div></div>').html(data.html).appendTo('.msg');
			  }
			  else
			  {
				$.mobile.loading('hide');	  
			 	$('<div></div>').html(data.html).appendTo('.msg');
			  }
		 },
		  error: function(e){
			  console.log(e);
			  alert('There was an error handling your registration!');
			  $.mobile.loading('hide');		  }
	  
	  });
  return false;
 
 }); //close event handler

});
