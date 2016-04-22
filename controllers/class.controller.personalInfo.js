$(document).ready(function() {

getData();
$( "#email2" ).change(function() {
	$('#popupInfo').popup("open");
	setTimeout(
  function() 
  {
    $('#popupInfo').popup("close");
  }, 5000);
	console.log("done popup");	
	
});
function getData()
{
	 $.get("http://localhost/CVCoach/models/class.model.personalInfo.php?action=onload",function(data) {
    if(data.success == true)
	{															
					$("#email2").val(data.email);
					$("#lname").val(data.lname);
					$("#fname").val(data.fname);				
					$("#addln1").val(data.row.addln1);
					$("#addln2").val(data.row.addln2);
					$("#tel").val(data.row.tel);
					$("#mobile").val(data.row.mobile);
					$("#postcode").val(data.row.postcode);
					$("#town").val(data.row.town);
					$("#county").val(data.row.county);
					$("#country").val(data.row.country);
					$("#postcode").val(data.row.postcode);
	}
	else if(data.success == false)
	{
					$("#email2").val(data.email);
					$("#lname").val(data.lname);
					$("#fname").val(data.fname);
	}
   
   }, "json");
}


 $('form#personalInfoForm').submit(function(){
 var bValid=true;
 var postData = $(this).serialize();
 
 console.log(postData);
 $.mobile.loading('show', {text: 'Saving Information - Please Wait',textVisible: true,theme: 'a'});  
  //*****Ajax JSON call will SEND and RECEIVE data back from the model****
	  $.ajax({
		  type: 'POST',
		  dataType: "json",
		  data: postData,
		  
//Always external URL in an App
url:  'http://localhost/CVCoach/models/class.model.personalInfo.php?action=save',
		  
		  success: function(data){
			  if(data.success == true)
			  {
				 $(':input', '#personalInfoForm').each(function()
				{
					if($(this).hasClass('required'))
					{        	
						$(this).val('');						
					}
				});
				
				$.mobile.loading('hide');	  
			 	$('<div></div>').html(data.msg).appendTo('.msg');
				getPage('personalStatement');
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
