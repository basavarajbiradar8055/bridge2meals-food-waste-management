<?php
session_start();
include 'connection.php';
$msg = 0;
if (isset($_POST['sign'])) {
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $password = mysqli_real_escape_string($connection, $_POST['password']);

  $sql = "SELECT * FROM login WHERE email='$email'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
      $_SESSION['email'] = $email;
      $_SESSION['name'] = $row['name'];
      $_SESSION['gender'] = $row['gender'];
      header("location:home.html");
      exit();
    } else {
      $msg = 1;
    }
  } else {
    $msg = 2;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bridge2Meals</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
        <div class="text-center mb-6">
            <div class="logo-name flex justify-center items-center">
                <span class="logo_name text-primary font-bold text-xl">
                    <img src="img\logo.png" alt="HungerBridge Logo" class="h-18 md:h-18 lg:h-18" />
                </span>
            </div>
            <p class="text-gray-600 mt-4">Welcome back! Please login to continue.</p>
        </div>
        <form action="" method="POST" class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:outline-none"
                    placeholder="Enter your email">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:outline-none"
                    placeholder="Enter your password">
            </div>
            <?php if ($msg == 1): ?>
            <p class="text-red-600 text-sm text-center">Incorrect password.</p>
            <?php elseif ($msg == 2): ?>
            <p class="text-red-600 text-sm text-center">Account does not exist.</p>
            <?php endif; ?>
            <button type="submit" name="sign"
                class="w-full bg-orange-500 text-white py-2 rounded-md hover:bg-orange-600 focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200">
                Sign In
            </button>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Don't have an account? <a href="signup.php"
                    class="text-orange-500 hover:underline">Register</a></p>
        </div>
    </div>
</body>

</html>