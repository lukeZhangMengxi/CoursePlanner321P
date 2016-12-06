<!DOCTYPE html>
          
<html>
<head>
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
<meta charset="UTF-8">

<title>Please Log In</title>
<!-- Bootstrap for page header-->
<link href = "//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel = "stylesheet">
<link rel="stylesheet" type="text/css" href="css/mainPanel.css">
<script type="text/javascript" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>
<body onload = "FB.Event.subscribe('auth.authResponseChange', auth_response_change_callback);
FB.Event.subscribe('auth.statusChange', auth_status_change_callback);">


<script>
var countCheck = 0;

var auth_response_change_callback = function(response) {
  statusChangeCallback(response);
  console.log("auth_response_change_callback");
  console.log(response);
}

var auth_status_change_callback = function(response) {
    statusChangeCallback(response);
    console.log("auth_status_change_callback: " + response.status);
}

  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
 
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
      if( countCheck == 0 ){
      	$.ajax ({
        	method: "POST",
		url: "logCheck.php",
        	data: { facebookid: response.authResponse.userID },
        	dataType: "JSON",
		error: function(textStatus, errorThrown){
			firstLogin = 'TRUE';
			console.log(textStatus, errorThrown);
		},
		success: function( response ){
			console.log("userID sent!");
			console.log(response);
      			if( response.firstLogin == 'FALSE' ){
				window.location = "mainPanel.php";
      			} else{
				window.location = "firstLoginPage.php";
      			}
		}
    	});
	countCheck++;
      }
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
  FB.getLoginStatus(function(response) {
  alert("hello");
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
      appId     : '1703397289972919',
    cookie	: true,  // enable cookies to allow the server to access 
                        // the session
      xfbml     : true,  // parse social plugins on this page
      status	: true,
    version	: 'v2.8' // use graph api version 2.8
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
  //alert("hello check login status");
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  // (function(d, s, id) {
  //   var js, fjs = d.getElementsByTagName(s)[0];
  //   if (d.getElementById(id)) return;
  //   js = d.createElement(s); js.id = id;
  //   js.src = "https://connect.facebook.net/en_US/sdk.js";
  //   fjs.parentNode.insertBefore(js, fjs);
  // }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->


<div id="status"> </div>


<div id="fb-root"></div>

<div class="fb-login-button" data-max-rows="1" data-size="large"
     data-show-faces="true" data-auto-logout-link="true"></div>

<h1 style="text-align: center;">
	Welcome to Course Planner!
</h1>
<h2 style="text-align: center;">
	CPEN311 Team CP
</h2>
		<div class="container">
   			<div class="column column-one column-offset-2">Diya Ren</div>
   			<div class="column column-two column-inset-1">Andrew Dombowsky</div>
   			<div class="column column-three column-offset-1">Chance Gao</div>
  			<div class="column column-four column-inset-2">Mengxi Zhang</div>
   			<div class="column column-five">Pitr Crandall</div>
		</div>
		<div class="container">
   			<div class="column column-one column-offset-2">CPEN</div>
   			<div class="column column-two column-inset-1">CPEN</div>
   			<div class="column column-three column-offset-1">CPEN</div>
  			<div class="column column-four column-inset-2">CPEN</div>
   			<div class="column column-five">CPEN</div>
		</div>
		<div class="container">
   			<div class="column column-one column-offset-2">
   				<img src="img/DiyaR.jpg" alt="Mountain View" style="max-width:100%;max-height:100%;">
   			</div>
   			<div class="column column-two column-inset-1">
   				<img src="img/AndrewD.jpg" alt="Mountain View" style="max-width:100%;max-height:100%;">
   			</div>
   			<div class="column column-three column-offset-1">
   				<img src="img/ChanceG.jpg" alt="Mountain View" style="max-width:100%;max-height:100%;">
   			</div>
  			<div class="column column-four column-inset-2">
  				<img src="img/MengxiZ.jpg" alt="Mountain View" style="max-width:100%;max-height:100%;">
  			</div>
   			<div class="column column-five">
   				<img src="img/PietrC.jpg" alt="Mountain View" style="max-width:100%;max-height:100%;">
   			</div>
		</div>

	</div>

</body>
</html>
