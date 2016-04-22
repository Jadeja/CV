//$(document).ready(function() {
console.log('dashboard linked');
getData();
function getData(){
	
    $.get("http://localhost/CVCoach/models/class.model.response.php?action=me",function(data) {
    if(data.success == true)
	alert('success');
	else
	alert('fail');
    var tr;
	for (var i = 0; i < data.tripData.length; i++)
	{
		 
	}
 
    $( "div#home[data-role=page]" ).trigger("create");}, "json");
    getTripSectors();
    return false;
};//Close Function

