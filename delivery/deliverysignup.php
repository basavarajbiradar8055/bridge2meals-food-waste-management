<?php
include '../connection.php';
$msg = 0;
if (isset($_POST['sign'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $location = $_POST['district'];

  $pass = password_hash($password, PASSWORD_DEFAULT);
  $sql = "SELECT * FROM delivery_persons WHERE email='$email'";
  $result = mysqli_query($connection, $sql);
  if (mysqli_num_rows($result) == 1) {
    echo "<h1><center>Account already exists</center></h1>";
  } else {
    $query = "INSERT INTO delivery_persons(name,email,password,city) VALUES('$username','$email','$pass','$location')";
    if (mysqli_query($connection, $query)) {
      header("location:delivery.php");
    } else {
      echo '<script>alert("Data not saved")</script>';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delivery Signup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
        body {
            background-image: url('../img/fooddel.jpg'); /* Add background image */
            background-size: cover; /* Cover the entire background */
            background-repeat: no-repeat; /* Prevent image repetition */
            background-position: center; /* Center the image */
        }

       
    </style>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">

  <div class="bg-white p-8 rounded-lg shadow-lg w-96">

    <img src="../img/del.png" class="mx-auto mb-4 w-24" alt="Logo">
    <h1 class="text-2xl font-bold text-center text-orange-500">Delivery Signup</h1>
    <form method="post">
      <div class="mt-4">
        <label class="block text-gray-700">Username</label>
        <input type="text" name="username" required class="w-full p-2 border border-gray-300 rounded mt-1">
      </div>
      <div class="mt-4">
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" required class="w-full p-2 border border-gray-300 rounded mt-1">
      </div>
      <div class="mt-4">
        <label class="block text-gray-700">Password</label>
        <input type="password" name="password" required class="w-full p-2 border border-gray-300 rounded mt-1">
      </div>
      <div class="mt-4">
        <label class="block text-gray-700">District</label>
        <select name="district" class="w-full p-2 border border-gray-300 rounded mt-1">
          <option value="bangalore" selected>Bangalore</option>
          <option value="mysore">Mysore</option>
          <option value="mangalore">Mangalore</option>
          <option value="hubli">Hubli</option>
        </select>
      </div>
      <button type="submit" name="sign"
        class="w-full bg-orange-500 text-white py-2 rounded mt-4 hover:bg-orange-600">Register</button>
      <p class="mt-4 text-center">Already a member? <a href="deliverylogin.php" class="text-orange-500">Sign
          in</a></p>
    </form>
  </div>
</body>

</html>