$(document).ready(function() {

 $('form#analyseForm').submit(function(){
 var postData = $(this).serialize();
 console.log(postData);
 $.mobile.loading('show', {text: 'Saving Information - Please Wait',textVisible: true,theme: 'a'});  
  //*****Ajax JSON call will SEND and RECEIVE data back from the model****
	  $.ajax({
		  type: 'POST',
		  dataType: "json",
		  data: postData,
		  
//Always external URL in an App
url:  'http://localhost/CVCoach/models/class.model.saveAnalyse.php?action=save',
		  
		  success: function(data){
			  if(data.success == true)
			  {
				$('#subAnalyseArea').empty();
				$.mobile.loading('hide');	  
			 	$('<div></div>').html(data.html).appendTo('.msg');
				getPage('personalInfo');
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
