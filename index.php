<!DOCTYPE html>
<?php

require_once('includes/init.php');

 $Pass = new pass();
 
 pass::deleteExpired();
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($Pass->save($_POST)) {
		
		Auth::getInstance()->sendEncryptedpassword($_POST['email']);
		$message_sent = true;
	}
}
 ?>
 
<html>
<head>
<link rel="stylesheet" type="text/css" href="/style/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.18.0/css/uikit.gradient.min.css" />
</head>
<body>

<ul>
  <li><a class="active" href="#home">XCODING PASS</a></li>
</ul>
<form method="post" class="uk-form uk-form-horizontal">
  <div class="uk-form-row ">
    <div class="uk-form-controls">  
	  <h1><b>Encrypt Password</b></h1> 	
	  <textarea id = "password" name="password" required="required" class="uk-textarea" rows="5" cols="100" placeholder="Please Enter your password here" value="<?php echo htmlspecialchars($pass->password); ?>"></textarea>
    </div>
  </div>
  
  <div class="uk-form-row ">
    <div class="uk-form-controls">  
	  <h3>KeyPass</h3> 	
	 <input id="keypass" name="keypass" required="required" value="<?php echo htmlspecialchars($pass->keypass); ?>" >
    </div>
  </div>
  
  <div class="uk-form-row">
   
    <div class="uk-form-controls">
	 <h3>Email Address</h3> 
      <input id="email" name="email" required="required" type="email" value="<?php echo htmlspecialchars($pass->email); ?>" />
    </div>
  </div>
   
   <div class= "uk-form-row">
   <div class="uk-form-controls">
   <h3> The encrypted message will delete automatically after</h3>
    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
            <label><input class="uk-radio" type="radio" name="radio2" checked value="mint"> Five Minutes</label>
            <label><input class="uk-radio" type="radio" name="radio2" value="OneHour"> One Hour</label>
			<label><input class="uk-radio" type="radio" name="radio2" value="Oneday"> One Day</label>
        </div>
   </div>
   </div>
   
   <div class= "uk-form-row">
   <div class="uk-form-controls">  
	 <button class="uk-button uk-button-primary">Encrypt Password</button>      
	<br></br>
    <h3>Xcoding pass is created to reduce the amount of clear text passwords stored in email and chat conversations by encrypting and generating a short lived link which can only be viewed for the selected time.</h3>
	<h3>End To End Encryption</h3>
	 <p>Both encryption and decryption are being made locally in the browser, the decryption key is not stored with Xcoding Pass</p>
	<h3>Self destruction</h3>
     <p>All messages have a fixed time to live and will be deleted automatically after expiration.</p>
	<h3>No accounts needed</h3>
	<p>No additional information except the encrypted secret is stored in the database.</p>
    </div>
   </div>	
 </form>
</body>
</html>