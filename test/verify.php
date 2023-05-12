<?php
// Check if the verification token is set
if(isset($_GET['token'])) {
	// Connect to the database
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'dummy_user_management_system';

	$conn = mysqli_connect($host, $username, $password, $dbname);
	if(!$conn) {
		die('Could not connect to the database: ' . mysqli_error($conn));
	}

	// Check if the verification token exists in the database
	$token = $_GET['token'];
	$query = "SELECT * FROM users WHERE verification_token='$token'";
	$result = mysqli_query($conn, $query);

	if(mysqli_num_rows($result) == 1) {
		// Set the user's verified status to 1
		$user = mysqli_fetch_assoc($result);
		$query = "UPDATE users SET verified=1 WHERE id=" . $user['id'];
		$result = mysqli_query($conn, $query);

		if($result) {
			echo "<p>Thank you for verifying your email. You can now log in to your account.</p>";
		} else {
			echo "<p>Something went wrong. Please try again later.</p>";
		}
	} else {
		echo "<p>Invalid verification token. Please check your email for the correct link.</p>";
	}

	mysqli_close($conn);
} else {
	echo "<p>Invalid verification token. Please check your email for the correct link.</p>";
}
?>
