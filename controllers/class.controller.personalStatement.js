$(document).ready(function() {


var tData = '';
getData();
function getData(){
	console.log('success');
    $.get("http://localhost/CVCoach/models/class.model.advise.php?title=personalStatement",function(data) {
    if(data.success == true)
	{				
					console.log('success2');
					console.log(data);													
					$('#advisesPersonalStatement').empty();		
					 var htmlAdvsFields   = '<li class="example" data-icon="false">';
						 htmlAdvsFields  += data.desc;
						 htmlAdvsFields  += '</li>';					
					$('#advisesPersonalStatement').append(htmlAdvsFields).trigger('create');					
	}
	else
	{
		$('<div></div>').html(data.msg).appendTo('.msg');
		alert(data.msg);
	}
   
   }, "json");
   
   
    $.get("http://localhost/CVCoach/models/class.model.examples.php?title=personalStatement",function(data) {
    if(data.success == true)
	{				
					console.log('success2');
					console.log(data);
					$('#examplePersonalStatement').empty();				
				
					 var htmlSkillFields  = '<li class="example" data-icon="false">';
						 htmlSkillFields += data.examples;
						 htmlSkillFields += '</li>';					
					$('#examplePersonalStatement').append(htmlSkillFields).trigger('create');		
											
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

					var b = data.requirements;	
					var htmlFields = "";
					$('#requirements3').empty();
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
					$('#requirements3').append(htmlFields).trigger('create');
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
 $('form#personalStatement').submit(function(){
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
url:  'http://localhost/CVCoach/models/class.model.personalStatement.php?action=save',
		  
		  success: function(data){
			  if(data.success == true)
			  {
				  	
				$(".ui-input-text").val('');						
				$.mobile.loading('hide');	  
			 	$('<div></div>').html(data.msg).appendTo('.msg');
				getPage('education');
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
