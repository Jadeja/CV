
/*
* navigation of web appliation 
* and goto function
*
*
*
*/
	

	var numSkills = 0;	
	//Goto Buttons	
	
	$('#streamSelect').change(function(){
	
		var stream = $('#streamSelect').val();	
		
		console.log('submited'+stream);
		$('#subAnalyseArea').empty();
		var postData = $('#analyseForm').serialize();
			
		//Show Page Loading Message
		$.mobile.loading('show', {text: 'Fetching Information for analyse form - Please Wait',textVisible: true,theme: 'a'});	
		
		//*****Ajax JSON call will SEND and RECEIVE data back from the model****
		$.ajax({
			type: 'POST',
			dataType: "json",
			data: postData,						
			url: 'http://localhost/CVCoach/models/class.model.analyse.php?stream='+stream,

			success: function(data)
			{			
				if (data.success == true)
			   {	//data from JSON Array				  				
					$('#subAnalyseArea').empty();
					$('#analysisStep1').empty();
					
					var htmlSkillFields = '<h2 id="message"></h2><ul data-role="listview" data-inset="true" id="skill1"><li data-icon="delete"><a href="javascript:removeFields(\'skill1\');" style="width:50px">Skill 1</a></li><li data-icon="false"><a><input type="text" data-theme="a" name="skill1" class="required" placeholder="Write your one skill eg.PHP"/><input type="text" name="skillExample1" class="required" placeholder="A name of example to support that skill eg. Final Year PHP web project " value=""/></a></li></ul><span id="additionalSkills"></span><a class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-plus ui-btn-b" title="Add Another Skills" href="javascript:addFields(\'skills\')">Add Another Skill</a></div><input type="hidden" value="1" id ="countSkills"/><button>Save and Continue</button>';					
	
					$('#subAnalyseArea').append(htmlSkillFields).trigger('create');
					$('#analysisStep1').append(data.description);
					$.mobile.loading('hide');
					$('#popupDialog').popup().popup("open");			
				   //change page					   	
					//$.mobile.changePage('#analyse');													   							   
				   
				  		
			   }//close data.success			
			  else
			   {
				   $.mobile.loading('hide');
				   $('button').prop('disabled', false);
				   $('#msg').empty();
				   $('<div></div>').html(data.message).appendTo('#msg');			 		   				   					      			   				   
			   }		   		
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
	}); 


$.mobile.ajaxEnabled = false;
function getPage(name)
{	
	var files = ["index","newdashboard","analyse","personalInfo","personalStatement","education","workExp","accessibility"]; // name of pages
	
	var a = files.indexOf(name);
	if(a >= 0)
	{
		if(name != 'index')
		var url  = 'views/'+name+'.html';
		else
		var url  = name+'.html';
	}
	else
	{
		var url   = 'views/newdashboard.html';
	}
	
	$.mobile.loading('show', {text: 'Loading Page - Please Wait',textVisible: true,theme: 'a'});
	
	if($('#'+name).length)
	{
		$.mobile.loading('hide');		
		$.mobile.changePage('#'+name);	
	}
	else
	{
	$.get(url , function(data) {
			var myPage = data;
			$('<div data-role="page" id="'+name+'" data-dom-cache="false">').html(myPage).appendTo('body');	//inject HTML view into the app			
			$.mobile.loading('hide');
			$.mobile.changePage('#'+name);		////call jquery mobile to see the full view
		});	
	}
}


function logout()
{
	$.get("http://localhost/CVCoach/models/class.model.logout.php",function(data) {	
	if (data.success == true)
	 {	
		console.log('success2');		
		$('<div></div>').html("LogOut Successfully").appendTo('.msg');
		$.mobile.changePage('#home');
		window.location.reload();			
	 }
	 console.log('something went wrong');	
   },"json");
}



function addFields(name)
{ 	
	switch(name)
	{
	case 'skills':
				var count = $("#countSkills").val();
				++count;
				var html  = '<ul data-role="listview" data-inset="true" id="skill'+count+'"><li data-icon="delete">';
				    html += '<a href="javascript:removeFields(\'skill'+count+'\');" style="width:50px">Skill '+count+'</a></li><li data-icon="false"><a>';
					html += '<input type="text" data-theme="a" class="required" name="skill'+count+'"placeholder="Write your one skill eg.PHP"/>';			
					html += '<input type="text" class="required" name="skillExample'+count+'" placeholder="A name of example to support that skill eg. Final Year PHP web project " value=""/>';
					html += '</a></li></ul>';
					
				$('#additionalSkills').append(html).trigger('create');
				$("#countSkills").val(count);
	break;
	case 'edu':
				var count = $("#countEdu").val();
				++count;
				var html  = '<ul data-role="listview" data-inset="true" id="edu'+count+'"><li data-icon="delete">';
				    html += '<a href="javascript:removeFields(\'edu'+count+'\');" style="width:80px">Section '+count+'</a></li><li data-icon="false">'; 
					html += '<input type="text" data-theme="a" name="institute'+count+'" class="required" placeholder="Name of Intitute eg. Teesside University"/>';
					html += '<input type="text" name="degree'+count+'" class="required" placeholder="Degree eg. Msc,Bsc" value=""/>';
					html += '<input type="text" name="subject'+count+'" class="required" placeholder="Subject eg. Computing, Criminology" value=""/>';
					html += 'start:<input type="month" name="start'+count+'" id="month-1" value="">End:<input type="month" name="end'+count+'" id="month-2" value="">';
					html += '<div class="field"><input type="text" name="town'+count+'" placeholder="Town" value=""/>';
					html += '<input type="text" name="county'+count+'" placeholder="County" value=""/><input type="text" name="country'+count+'" placeholder="Country" value=""/>';
					html += 'Modlues/Decription:<textarea name="desc'+count+'" id="content" class="smallTxt"> </textarea></div></li></ul>';					
					
				$('#additionalEdu').append(html).trigger('create');
				$("#countEdu").val(count);	
				 grammar();
	break;
	case 'workExp':
				var count = $("#countWorkExp").val();
				++count;
				var html  = '<ul data-role="listview" data-inset="true" id="workExp'+count+'"><li data-icon="delete">';
				    html += '<a href="javascript:removeFields(\'workExp'+count+'\');" style="width:80px">Section '+count+'</a></li><li data-icon="false">'; 
					html += '<input type="text" data-theme="a" name="organization" class="required" placeholder="Name of Company/Organisation eg. Microsoft,Dell"/>';
					html += '<input type="text" name="position" class="required" placeholder="Position eg. Junior Developer, Senior Developer" value=""/>';
					html += 'start:<input type="month" name="start" id="month-1" value="">End:<input type="month" name="end" id="month-2" value="">';
					html += '<div class="field"><input type="text" name="town" placeholder="Town" value=""/>';
					html += '<input type="text" name="county" placeholder="County" value=""/>';
					html += 'Job Description:<textarea name="desc" id="content" class="smallTxt"> </textarea>';
					html += '</div></li></ul>';					
					
				$("#additionalWorkExp").append(html).trigger('create');
				$("#countWorkExp").val(count);
				grammar();	
	break;
	
  }
} 	

function removeFields(id)
{
	$('#'+id).remove();
}

function grammar()
{
	
    tinyMCE.init({
        mode : "textareas",
        plugins                     : "AtD",

        /* the URL to the button image to display */
        atd_button_url              : "http://localhost/CVCoach/atdbuttontr.gif",

        /* the URL of your proxy file */
        atd_rpc_url                 : "http://localhost/CVCoach/server/proxy.php?url=",

        /* set your API key */
        atd_rpc_id                  : "dashnine",

        /* edit this file to customize how AtD shows errors */
        atd_css_url                 : "http://localhost/CVCoach/css/content.css",

        /* this list contains the categories of errors we want to show */
        atd_show_types              : "Bias Language,Cliches,Complex Expression,Diacritical Marks,Double Negatives,Hidden Verbs,Jargon Language,Passive voice,Phrases to Avoid,Redundant Expression",

        /* strings this plugin should ignore */
        atd_ignore_strings          : "AtD,rsmudge",

        /* enable "Ignore Always" menu item, uses cookies by default. Set atd_ignore_rpc_url to a URL AtD should send ignore requests to. */
        atd_ignore_enable           : "false",

        /* add the AtD button to the first row of the advanced theme */
        theme_advanced_buttons1_add : "AtD",

        /*
         * this stuff is a matter of preference 
         */
        theme                              : "advanced",

        theme_advanced_buttons1            : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,separator", 
        theme_advanced_buttons2            : "",
        theme_advanced_buttons3            : "",

        theme_advanced_toolbar_location    : "top",
        theme_advanced_toolbar_align       : "left",

        theme_advanced_statusbar_location  : "none",
        theme_advanced_resizing            : true,
        theme_advanced_resizing_use_cookie : false,

            /* disable the gecko spellcheck since AtD provides one */
        gecko_spellcheck                   : false
    });
   
}