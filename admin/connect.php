<?php
session_start();
include '../connection.php';

$msg = 0;

if (isset($_POST['sign'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Sanitize input
  $sanitized_email = mysqli_real_escape_string($connection, $email);
  $sanitized_password = mysqli_real_escape_string($connection, $password);

  // Correcting table name & fetching admin details
  $sql = "SELECT * FROM admins WHERE email='$sanitized_email'";
  $result = mysqli_query($connection, $sql);

  if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    // Verify password
    if (password_verify($sanitized_password, $row['password'])) {
      // Set session variables
      $_SESSION['email'] = $row['email'];
      $_SESSION['name'] = $row['name'];
      $_SESSION['city'] = $row['city'];  // Ensure this column exists
      $_SESSION['admin_id'] = $row['Aid']; // Use 'id' instead of 'Aid' based on your schema

      header("location: admin.php");
      exit;
    } else {
      $msg = 1; // Incorrect password
    }
  } else {
    echo "<h1><center>Account does not exist</center></h1>";
  }
}