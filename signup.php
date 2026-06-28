<?php
include 'connection.php';
if (isset($_POST['sign'])) {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    $pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        echo "<h1><center>Account already exists</center></h1>";
    } else {
        $query = "INSERT INTO login(name, email, password, gender) VALUES('$username', '$email', '$pass', '$gender')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            header("location:signin.php");
        } else {
            echo '<script type="text/javascript">alert("Data not saved")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-lg p-5">
            <div class="text-center mb-2">
                <img src="img\logo4.png" alt="Logo" class="mx-auto w-80 mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Create Your Account</h2>
                <p class="text-gray-600 mt-2">Join us today!</p>
            </div>

            <form method="POST" action="" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Enter your username">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Enter your email">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Enter your password">
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-700 mb-2">Gender</span>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="male" required class="text-orange-500">
                            <span class="ml-2 text-gray-700">Male</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="female" class="text-orange-500">
                            <span class="ml-2 text-gray-700">Female</span>
                        </label>
                    </div>
                </div>

                <button type="submit" name="sign"
                    class="w-full bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition duration-200">
                    Continue
                </button>
            </form>

            <div class="mt-3 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="signin.php" class="text-orange-500 hover:text-orange-600 font-medium">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>