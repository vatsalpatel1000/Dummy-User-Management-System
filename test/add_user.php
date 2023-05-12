<?php
// Define variables and initialize with empty values
$name = $email = $mobile = "";
$name_err = $email_err = $mobile_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

	// Validate name
	if(empty(trim($_POST["name"]))){
		$name_err = "Please enter a name.";
	} else{
		$name = trim($_POST["name"]);
	}

	// Validate email
	if(empty(trim($_POST["email"]))){
		$email_err = "Please enter an email.";
	} else{
		$email = trim($_POST["email"]);
	}

	// Validate mobile
	if(empty(trim($_POST["mobile"]))){
		$mobile_err = "Please enter a mobile number.";
	} else{
		$mobile = trim($_POST["mobile"]);
	}

	// Check input errors before inserting in database
	if(empty($name_err) && empty($email_err) && empty($mobile_err)){

		// Generate a verification token
		$verification_token = bin2hex(random_bytes(16));

		// Connect to the database
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$dbname = 'dummy_user_management_system';

		$conn = mysqli_connect($host, $username, $password, $dbname);
		if(!$conn) {
			die('Could not connect to the database: ' . mysqli_error($conn));
		}

		// Insert the user data into the database
		$query = "INSERT INTO users (name, email, mobile, verification_token) VALUES ('$name', '$email', '$mobile', '$verification_token')";
		$result = mysqli_query($conn, $query);

		if($result) {
			// Send a verification email to the user
			$to = $email;
			$subject = "Verify your email";
			$message = "Please click the following link to verify your email: http://localhost/verify.php?token=$   ";
			$headers = "From: example@example.com";

			if(mail($to, $subject, $message, $headers)) {
				echo "<p>A verification email has been sent to your email address. Please click the verification link in the email to complete your registration.</p>";
			} else {
				echo "<p>Something went wrong. Please try again later.</p>";
			}
		} else {
			echo "<p>Something went wrong. Please try again later.</p>";
		}

		mysqli_close($conn);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
</head>
<body>
	<h2>Add User</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<label>Name:</label>
		<input type="text" name="name" value="<?php echo $name; ?>">
		<span><?php echo $name_err; ?></span>
		<br>
		<label>Email:</label>
		<input type="email" name="email" value="<?php echo $email; ?>">
		<span><?php echo $email_err; ?></span>
		<br>
		<label>Mobile:</label>
		<input type="text" name="mobile" value="<?php echo $mobile; ?>">
		<span><?php echo $mobile_err; ?></span>
		<br>
		<input type="submit" value="Submit">
	</form>
</body>
</html>
