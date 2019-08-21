<html>
<head>
<link rel="stylesheet" type="text/css" href="/style/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.18.0/css/uikit.gradient.min.css" />
</head>
<body>

<ul>
  <li><a class="active" href="#home">XCODING PASS</a></li>
</ul>
<?php


require_once('includes/init.php');

if (isset($_GET['token'])) {
	
    $Pass = pass::findthetoken($_GET['token']);
    $value = $Pass->token;	
	$cookie_name= "guest";
	setcookie($cookie_name, $value, time() + (86400 * 30), "/"); 
	
	If($Pass != null){		
?>		
<form method="post" class="uk-form uk-form-horizontal">
 <h1> XCoding Share Password</h1>
 <p> Please enter the  KeyPass that was used to encrypt the Password</p>
  <div class="uk-form-row ">
    <div class="uk-form-controls">  
	  <h3>Key Password</h3> 	
	 <input id="keypass" name="keypass" required="required" >
    </div>
  </div>
 
   <div class= "uk-form-row">
   <div class="uk-form-controls">  
	 <button class="uk-button uk-button-primary">Decrypt Password</button>      
	<br></br>
    <h3>Xcoding pass is created to reduce the amount of clear text passwords stored in email and chat conversations by encrypting and generating a short lived link which can only be viewed for the selected time.</h3>
	<h3>End To End Encryption</h3>
	 <p>Both encryption and decryption are being made locally in the browser, the decryption key is not stored with Xcoding Pass</p>
	<h3>Self destruction</h3>
     <p>All messages have a fixed time to live and will be deleted automatically after expiration.</p>
	<h3>No accounts needed</h3>
	<p>No additional information except the encrypted secret is stored in the database.</p>
    </div>

 </form>
</body>
</html>	
<?php	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$hash = Hash::decrypt($_POST['keypass'],$Pass->password);

		If(!empty($hash)){
?>	
	
		<h3>Your encrypted password -> <?php echo $hash;}?></h3>
		
<?php	
	
}

}
	else
		echo "You are Getting this message because the link has expired! <br></br>
	
	Please click here to encrypt and share the password";
	
  }


 ?>
