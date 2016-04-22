$(document).ready(function() {


var tData = '';
getData();
function getData(){
	console.log('success');
    $.get("http://localhost/CVCoach/models/class.model.advise.php?title=workExperience",function(data) {
    if(data.success == true)
	{				
					console.log('success2');
					console.log(data);											
					$('#advisesWorkExp').empty();		
					 var htmlAdvsFields   = '<li class="example" data-icon="false">';
						 htmlAdvsFields  += data.desc;
						 htmlAdvsFields  += '</li>';					
					$('#advisesWorkExp').append(htmlAdvsFields).trigger('create');					
	}
	else
	{
		$('<div></div>').html(data.msg).appendTo('.msg');
		alert(data.msg);
	}
   
   }, "json");
   
   
    $.get("http://localhost/CVCoach/models/class.model.examples.php?title=workExperience",function(data) {
    if(data.success == true)
	{				
					console.log('examples');
					console.log(data);							
										
					$('#exampleWorkExp').empty();				
				
					 var htmlSkillFields  = '<li class="example" data-icon="false">';
						 htmlSkillFields += data.examples;
						 htmlSkillFields += '</li>';					
					$('#exampleWorkExp').append(htmlSkillFields).trigger('create');						
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
					$('#requirements2').empty();
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
					$('#requirements2').append(htmlFields).trigger('create');
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
 $('form#workExpForm').submit(function(){
 var bValid=true;
 var postData = $(this).serialize();
 
 console.log(postData);
 $.mobile.loading('show', {text: 'Saving Your Information - Please Wait',textVisible: true,theme: 'a'});  
  //*****Ajax JSON call will SEND and RECEIVE data back from the model****
	  $.ajax({
		  type: 'POST',
		  dataType: "json",
		  data: postData,
		  
//Always external URL in an App
url:  'http://localhost/CVCoach/models/class.model.workExp.php?action=save',		  
		  success: function(data){
			  if(data.success == true)
			  {
				 $(':input', '#workExpForm').each(function()
				{
					if($(this).hasClass('required'))
					{        	
						$(this).val('');											
					}
				});
				
				$('#content').val('');
				$('#month-1').val('');		
				$('#month-2').val('');	
				$('#county').val('');								
				$('#town').val('');					 				  											
				$.mobile.loading('hide');	  			 	
				getPage('newdashboard');
			  }
			  else
			  {
				$.mobile.loading('hide');	  
			 	$('<div></div>').html(data.msg).appendTo('#msg');
			  }
		 },
		  error: function(e){
			  console.log(e);
			  alert('There was an error handling your in submission!');
			  $.mobile.loading('hide');		  }
	  
	  });
  return false;
 
 }); //close event handler

});
