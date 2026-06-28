<?php
// Database Connection
include '../user/connect.php';
session_start();

// Ensure User is Logged In
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch User City (Assuming user city is stored in `users` table)
$userQuery = "SELECT city FROM users WHERE id = ?";
$stmt = $connection->prepare($userQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_city = $user['city'];

// Fetch Dropoff Location from Admin Table
$dropoffQuery = "SELECT dropoff_location FROM admin WHERE city = ?";
$stmt = $connection->prepare($dropoffQuery);
$stmt->bind_param("s", $user_city);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$dropoff_location = $admin ? $admin['dropoff_location'] : 'Not Available';

// Handle Food Donation Form Submission
if (isset($_POST['donate_food'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $food = $_POST['food'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $address = $_POST['address'];
    $phoneno = $_POST['phoneno'];

    $query = "INSERT INTO food_donations (name, email, food, type, category, quantity, address, location, dropoff_location, phoneno, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssssssss", $name, $email, $food, $type, $category, $quantity, $address, $user_city, $dropoff_location, $phoneno);
    
    if ($stmt->execute()) {
        echo "<script>alert('Food donation submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error in donating food!');</script>";
    }
}

// Fetch User Donations
$query = "SELECT * FROM food_donations WHERE email = ? ORDER BY date DESC";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $_SESSION['user_email']);
$stmt->execute();
$donations = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard - Donate Food</title>
</head>

<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>

    <!-- Food Donation Form -->
    <h3>Donate Food</h3>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required
            readonly><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" required
            readonly><br>

        <label>Food Item:</label>
        <input type="text" name="food" required><br>

        <label>Type (Veg/Non-Veg):</label>
        <input type="text" name="type" required><br>

        <label>Category:</label>
        <input type="text" name="category" required><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" required><br>

        <label>Pickup Address:</label>
        <textarea name="address" required></textarea><br>

        <label>Phone No:</label>
        <input type="text" name="phoneno" required><br>

        <label>Dropoff Location:</label>
        <input type="text" value="<?php echo htmlspecialchars($dropoff_location); ?>" readonly><br>

        <button type="submit" name="donate_food">Donate Food</button>
    </form>

    <!-- Display Past Donations -->
    <h3>My Donations</h3>
    <table border="1">
        <tr>
            <th>Food ID</th>
            <th>Food Item</th>
            <th>Quantity</th>
            <th>Pickup Address</th>
            <th>Dropoff Location</th>
            <th>Status</th>
            <th>Delivery Agent</th>
            <th>Donated On</th>
        </tr>
        <?php while ($donation = $donations->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($donation['Fid']); ?></td>
            <td><?php echo htmlspecialchars($donation['food']); ?></td>
            <td><?php echo htmlspecialchars($donation['quantity']); ?></td>
            <td><?php echo htmlspecialchars($donation['address']); ?></td>
            <td><?php echo htmlspecialchars($donation['dropoff_location']); ?></td>
            <td>
                <?php 
                if ($donation['status'] == 'Pending') {
                    echo "<span style='color: orange;'>⏳ Pending</span>";
                } elseif ($donation['status'] == 'Assigned to Delivery Rider') {
                    echo "<span style='color: blue;'>🚴 Assigned</span>";
                } else {
                    echo "<span style='color: green;'>✅ Delivered</span>";
                }
                ?>
            </td>
            <td>
                <?php 
                if ($donation['assigned_to']) {
                    // Fetch delivery agent name
                    $agentQuery = "SELECT name FROM delivery_persons WHERE Did = ?";
                    $stmt2 = $connection->prepare($agentQuery);
                    $stmt2->bind_param("i", $donation['assigned_to']);
                    $stmt2->execute();
                    $agentResult = $stmt2->get_result();
                    $agent = $agentResult->fetch_assoc();
                    echo htmlspecialchars($agent['name']);
                } else {
                    echo "Not Assigned";
                }
                ?>
            </td>
            <td><?php echo htmlspecialchars($donation['date']); ?></td>
        </tr>
        <?php } ?>
    </table>
</body>

</html>