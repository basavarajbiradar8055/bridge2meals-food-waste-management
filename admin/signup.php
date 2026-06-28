<?php
// session_start();  
include '../connection.php';
$msg = 0;
if (isset($_POST['sign'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $location = $_POST['district'];
    $address = $_POST['address'];

    $pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "select * from admin where email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        // echo "<h1> already account is created </h1>";
        // echo '<script type="text/javascript">alert("already Account is created")</script>';
        echo "<h1><center>Account already exists</center></h1>";
    } else {

        $query = "insert into admin(name,email,password,location,address) values('$username','$email','$pass','$location','$address')";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            // $_SESSION['email']=$email;
            // $_SESSION['name']=$row['name'];
            // $_SESSION['gender']=$row['gender'];

            header("location:signin.php");
            // echo "<h1><center>Account does not exists </center></h1>";
            //  echo '<script type="text/javascript">alert("Account created successfully")</script>'; -->
        } else {
            echo '<script type="text/javascript">alert("data not saved")</script>';
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <img src="logo.png" alt="Logo" class="mx-auto w-20 mb-4">
                <h2 class="text-3xl font-bold text-gray-800">Admin Signup</h2>
                <p class="text-gray-600 mt-2">Create an account to manage the system</p>
            </div>

            <form method="POST" action="" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Enter your name">
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
                    <label for="district" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <select id="district" name="district" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <option value="bangalore" selected>Bangalore</option>
                        <option value="mysore">Mysore</option>
                        <option value="mangalore">Mangalore</option>
                        <option value="hubli">Hubli</option>
                    </select>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea id="address" name="address" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Enter your address"></textarea>
                </div>



                <button type="submit" name="sign"
                    class="w-full bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition duration-200">
                    Register
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="signin.php" class="text-orange-500 hover:text-orange-600 font-medium">
                        Login Now
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>