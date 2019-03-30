
<?php 
	session_start();
	require "../PhpProject1/database.php";
	if (!empty($_POST)) {
	
		// keep track validation errors
		
		$emailError = null;
		$passwordError = null;
		
		// keep track post values
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		
		// validate input
		$valid = true;
		
		if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter password ';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			
			$confirm_code=md5(uniqid(rand()));
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO customers(email,password_hash,confirm_code) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($email,MD5($password), $confirm_code));

			
			
		
		
		
		
			// ---------------- SEND MAIL FORM ----------------

			// send e-mail to ...
			$to=$email;

			// Your subject
			$subject="Your confirmation link here";

			// From
			$header="from: David Lubonski <dplubons@svsu.edu>";

			// Your message
			$message="Your Comfirmation link \r\n";
			$message.="Click on this link to activate your account \r\n";
			$message.="http://www.csis.svsu.edu/~dplubons/cis355/PhpProject3/confirmation.php?passkey=$confirm_code";

			// send email
			mail($to,$subject,$message,$header);
			
			
		
			
			header("Location: login.php? ");
			
			Database::disconnect();
		}

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		}
	
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='UTF-8'>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Sign Up</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="signup.php" method="post">
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					   <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="password"  placeholder="password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Sign Up</button>
						  <a class="btn btn-danger" href="login.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
