<?php
include("login.php");
if ($_SESSION['name'] == '') {
    header("location: signin.php");
}
// include("login.php"); 
$emailid = $_SESSION['email'];
$connection = mysqli_connect("localhost", "root", "Hemu@321");
$db = mysqli_select_db($connection, 'socitaldb');
if (isset($_POST['submit'])) {
    $foodname = mysqli_real_escape_string($connection, $_POST['foodname']);
    $meal = mysqli_real_escape_string($connection, $_POST['meal']);
    $category = $_POST['image-choice'];
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    // $email=$_POST['email'];
    $phoneno = mysqli_real_escape_string($connection, $_POST['phoneno']);
    $district = mysqli_real_escape_string($connection, $_POST['district']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);


    $query = "insert into food_donations(email,food,type,category,phoneno,location,address,name,quantity) values('$emailid','$foodname','$meal','$category','$phoneno','$district','$address','$name','$quantity')";
    $query_run = mysqli_query($connection, $query);
    if ($query_run) {

        echo '<script type="text/javascript">alert("data saved")</script>';
        header("location:delivery.html");
    } else {
        echo '<script type="text/javascript">alert("data not saved")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-orange-500 flex justify-center items-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <div class="flex justify-center mb-4">
            <img src="img/hungerbridge_LOGO.png" alt="HungerBridge Logo" class="h-12">
        </div>
        <h2 class="text-center text-2xl font-bold text-gray-700 mb-4">Donate Food</h2>
        <form method="POST" action="">
            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Food Name</label>
                <input type="text" name="foodname" required class="w-full p-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Meal Type</label>
                <div class="flex space-x-4 mt-2">
                    <label><input type="radio" name="meal" value="veg" required> Veg</label>
                    <label><input type="radio" name="meal" value="Non-veg"> Non-Veg</label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Category</label>
                <div class="flex space-x-4 mt-2">
                    <label><input type="radio" name="image-choice" value="raw-food"> Raw Food</label>
                    <label><input type="radio" name="image-choice" value="cooked-food" checked> Cooked Food</label>
                    <label><input type="radio" name="image-choice" value="packed-food"> Packed Food</label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Quantity (Number of persons/kg)</label>
                <input type="text" name="quantity" required class="w-full p-2 border rounded-lg">
            </div>

            <h3 class="text-center text-lg font-bold text-gray-700">Contact Details</h3>
            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Name</label>
                <input type="text" name="name" value="<?php echo $_SESSION['name']; ?>" required
                    class="w-full p-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Phone No</label>
                <input type="text" name="phoneno" maxlength="10" pattern="[0-9]{10}" required
                    class="w-full p-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">District</label>
                <select name="district" class="w-full p-2 border rounded-lg">
                    <option value="bangalore">Bangalore</option>
                    <option value="mysore">Mysore</option>
                    <option value="mangalore">Mangalore</option>
                    <option value="hubli">Hubli</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Address</label>
                <input type="text" name="address" required class="w-full p-2 border rounded-lg">
            </div>

            <div class="flex justify-center">
                <button type="submit" name="submit"
                    class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>