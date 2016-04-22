$(document).ready(function() {


var tData = '';
getData();
function getData(){
	console.log('success');
    $.get("http://localhost/CVCoach/models/class.model.advise.php?title=education",function(data) {
    if(data.success == true)
	{				
					console.log('success2');
					console.log(data);											
					$('#advisesEducation').empty();		
					 var htmlAdvsFields   = '<li class="example" data-icon="false">';
						 htmlAdvsFields  += data.desc;
						 htmlAdvsFields  += '</li>';					
					$('#advisesEducation').append(htmlAdvsFields).trigger('create');					
	}
	else
	{
		$('<div></div>').html(data.msg).appendTo('.msg');
		alert(data.msg);
	}
   
   }, "json");
   
   
    $.get("http://localhost/CVCoach/models/class.model.examples.php?title=education",function(data) {
    if(data.success == true)
	{				
					console.log('examples');
					console.log(data);							
										
					$('#exampleEducation').empty();				
				
					 var htmlSkillFields  = '<li class="example" data-icon="false">';
						 htmlSkillFields += data.examples;
						 htmlSkillFields += '</li>';					
					$('#exampleEducation').append(htmlSkillFields).trigger('create');						
	}
	else
	{
		$('<div></div>').html(data.msg).appendTo('.msg');
		alert(data.msg);
	}
   
   }, "json");
   
   
   $.get("http://localhost/CVCoach/models/class.model.analyse.php?get=get",function(data) {
    if(data.success == true)
	{				
					console.log('success2');
					console.log(data.requirements);
					var b = data.requirements;	
					var htmlFields = "";
					$('#requirements').empty();
					for(var i = 1;  ;i++)
					{				
						if(b['skill'+i])
						{
						 console.log(b['skill'+i]+':'+b['skillExample'+i]);	
						 htmlFields   += '<li class="example" data-icon="false"><a><h3>'+b['skill'+i]+'</h3></a>'+b['skillExample'+i]+'</li>';						
						}
						else			
						break;																								
					}
					$('#requirements').append(htmlFields).trigger('create');
					console.log('finish');
	}
	else
	{
		$('<div></div>').html(data.msg).appendTo('.msg');
		alert(data.msg);
	}
   
   }, "json");
   grammar();
    return false;
};

	  

// On Submit Click
 $('form#educationForm').submit(function(){
 var bValid=true;
 var postData = $(this).serialize();
 postData = 'countEdu='+$("#countEdu").val()+'&'+ postData;
 console.log(postData);
 $.mobile.loading('show', {text: 'Saving Your Information - Please Wait',textVisible: true,theme: 'a'});  
  //*****Ajax JSON call will SEND and RECEIVE data back from the model****
	  $.ajax({
		  type: 'POST',
		  dataType: "json",
		  data: postData,
		  
//Always external URL in an App
url:  'http://localhost/CVCoach/models/class.model.education.php?action=save',		  
		  success: function(data){
			  if(data.success == true)
			  {				  			
			  	$(':input', '#educationForm').each(function()
				{
					if($(this).hasClass('required'))
					{        	
						$(this).val('');						
					}
				});
				
				$('#content').val('');
				$('#month-1').val('');		
				$('#month-2').val('');	
				$('#county1').val('');	
				$('#country1').val('');	
				$('#town1').val('');			
				$('#additionalEdu').empty();	
				$('#countEdu').val('1');				
				$.mobile.loading('hide');	  
			 	$('<div></div>').html(data.msg).appendTo('.msg');
				getPage('workExp');
			  }
			  else
			  {
				$.mobile.loading('hide');	  
			 	$('<div></div>').html(data.msg).appendTo('.msg');
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
