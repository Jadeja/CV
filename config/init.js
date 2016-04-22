//Kick Things off in your app when it first initialises

/*
//Control the size of current location google map - fills entire screen 
$(function(){
$(window).resize(function(){
var elem=$(this);
$('#map').css('min-height',$(window).height()+'px');});
$(window).resize();
});
*/

//********Swipe Control**********//
//define var that prevents swipe until the user successfully authenticates

var loginActive = false;
var swipeDisable = false ;

//Initialise Screen
$(document).on('pageinit', function(event){
console.log('init file linked')



//Only Allow Swipe Controls If User Is Logged In
if(window.loginActive==true && window.swipeDisable!=true){
	
	
	

	
	
	
	
	//http://thediscoblog.com/blog/2013/07/30/adding-swipe-gestures-to-jquery-mobile-apps/
  $('div.ui-page').on("swipeleft", function () {
	  
	  
	  
	  
    var nextpage = $(this).next('div[data-role="page"]');
      
	  //Add var to control login authentication control
	  if (nextpage.length > 0 ) {
		  
		  //prevent double swipe event bubbling
	  event.stopImmediatePropagation();
	  event.stopPropagation();
 event.preventDefault();
		  
        $.mobile.changePage(nextpage, {
transition: "pop",
reverse: false,
changeHash: true
});



      }
  });

  $('div.ui-page').on("swiperight", function () {
	  
	  
    var prevpage = $(this).prev('div[data-role="page"]');
	
	var checkpage = $(this).prev('div[data-role="page"]').attr('id');
	
    if (prevpage.length > 0 && checkpage!='home' ) {
		alert(prevpage);
		//prevent double swipe event bubbling
	  event.stopImmediatePropagation();
	  event.stopPropagation();
 event.preventDefault();
		
      $.mobile.changePage(prevpage, {
transition: "pop",
reverse: false,
changeHash: true
});


	  

    }
  });
  
}//close login active condition




//GeoLocation function
/*
$('.geoLocation_btn').click(getLocation);

		
           
		   console.log("google map clicked");
		   
		   
		   //Show Page Loading Message
			$.mobile.loading('show', {text: 'Map Loading - Please Wait',textVisible: true,theme: 'a'});
		   
		   function getLocation(){
			//var that disables swipe in swipe functions when map is in use
			window.swipeDisable = true;
        navigator.geolocation.getCurrentPosition(handleSuccess,handleError);
      }

      function initiate_watchlocation() {  
        if(watchProcess == null){
          watchProcess = navigator.geolocation.watchPosition(handleSuccess,handleError);
        }
      } 

      function stop_watchlocation() {  
        if(watchProcess != null){
          navigator.geolocation.clearWatch(watchProcess);
        }
      } 

      function handleSuccess(position){
        drawMap(position);
      }

      function handleError(error){
        switch(error.code)
        {
          case error.PERMISSION_DENIED: alert("User did not share geolocation data");break;  
          case error.POSITION_UNAVAILABLE: alert("Could not detect current position");break;  
          case error.TIMEOUT: alert("Retrieving position timed out");break;  
          default: alert("Unknown Error");break;  
        }
      }


      function drawMap(position) {
	   
        var container = $('#map');
        var myLatLong = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
        var mapOptions = {
          center: myLatLong,
          zoom: 12,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(container[0],mapOptions);
        container.css('display','block');
        var marker = new google.maps.Marker({ 
          position: myLatLong,
          map:map,
          title:"My Position (Accuracy of Position: " + position.coords.accuracy + " Meters), Altitude: " 
            + position.coords.altitude + ' Altitude Accuracy: ' + position.coords.altitudeAccuracy
        });
      }

      function drawStaticMap(position){
		  $.mobile.loading('hide');
        var container = $('#map');
        var imageUrl = "https://maps.google.com/maps/api/staticmap?sensor=false&center=" + position.coords.latitude + "," +  
                    position.coords.longitude + "&zoom=18&size=640x500&markers=color:blue|label:S|" +  
                    position.coords.latitude + ',' + position.coords.longitude;  

        container.css({
          'display':'block',
          'width' : 640
        });
        $('<img/>',{
          src : imageUrl
        }).appendTo(container);
		
		
      } 

		//reset swipe navigation when navigating away from the map
		$(".red").on("click", function (e) {
		   window.swipeDisable = false;
		});

*/
  
});




	








