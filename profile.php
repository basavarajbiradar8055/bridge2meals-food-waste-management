<?php
include("login.php");

if ($_SESSION['name'] == '') {
    header("location: signup.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Bridge2Meals</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary-color: #06C167;
        --secondary-color: #333;
        --accent-color: #FF9800;
        --light-gray: #f5f5f5;
        --border-radius: 15px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Arial', sans-serif;
    }

    /* Header Styles */
    header {
        position: fixed;
        width: 100%;
        background: white;
        padding: 1rem 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo-img {
        height: 50px;
        width: auto;
    }

    .nav-links {
        display: flex;
        gap: 2rem;
        list-style: none;
        align-items: center;
    }

    .nav-links a {
        text-decoration: none;
        color: var(--secondary-color);
        font-weight: 500;
        transition: color 0.3s;
    }

    .nav-links a:hover {
        color: var(--primary-color);
    }

    .nav-links .active {
        color: var(--primary-color);
        font-weight: 600;
    }

    .logout-btn {
        background: var(--accent-color);
        color: white !important;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        transition: background 0.3s;
    }

    .logout-btn:hover {
        background: #e68a00;
    }

    /* Profile Section */
    .profile {
        padding-top: 100px;
        min-height: 100vh;
        background: var(--light-gray);
    }

    .profile-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem;
    }

    .profile-header {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }

    .profile-info h1 {
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }

    .profile-details {
        color: #666;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .donations-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        color: var(--secondary-color);
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .table th,
    .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background: var(--primary-color);
        color: white;
        font-weight: 500;
    }

    .table tr:hover {
        background: #f9f9f9;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .profile-avatar {
            margin: 0 auto;
        }

        .table th,
        .table td {
            padding: 0.75rem;
        }
    }

    /* Hamburger Menu */
    .hamburger {
        display: none;
        cursor: pointer;
    }

    .hamburger .line {
        width: 25px;
        height: 3px;
        background: var(--secondary-color);
        margin: 5px 0;
    }

    @media (max-width: 768px) {
        .hamburger {
            display: block;
        }

        .nav-bar {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            display: none;
            padding: 1rem;
        }

        .nav-bar.active {
            display: block;
        }

        .nav-links {
            flex-direction: column;
            gap: 1rem;
        }
    }
    </style>
</head>

<body>
    <header>
        <div class="nav-container">
            <div class="logo">
                <img class="logo-img" src="img/logo.png" alt="HungerBridge Logo">
            </div>
            <div class="hamburger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <nav class="nav-bar">
                <ul class="nav-links">
                    <li><a href="home.html">Home</a></li>
                    <!-- <li><a href="about.html">About</a></li>
                    <li><a href="contact.html">Contact</a></li> -->
                    <li><a href="profile.php" class="active">Profile</a></li>
                    <li><a href="logout.php" class="logout-btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="profile">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    <?php
                    $name = isset($_SESSION['name']) ? $_SESSION['name'] : 'User';
                    echo strtoupper(substr($name, 0, 1));
                    ?>
                </div>
                <div class="profile-info">
                    <h1>Welcome, <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'User'; ?></h1>
                    <div class="profile-details">
                        <p><i class="fas fa-envelope"></i>
                            <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A'; ?></p>
                        <p><i class="fas fa-user"></i>
                            <?php echo isset($_SESSION['gender']) ? $_SESSION['gender'] : 'Not Set'; ?></p>
                    </div>
                </div>
            </div>

            <div class="donations-section">
                <h2 class="section-title">Your Donations</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Food Item</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Date/Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $email = $_SESSION['email'];
                            $query = "select * from food_donations where email='$email'";
                            $result = mysqli_query($connection, $query);
                            if ($result == true) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['food'] . "</td>";
                                    echo "<td>" . $row['type'] . "</td>";
                                    echo "<td>" . $row['category'] . "</td>";
                                    echo "<td>" . $row['date'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    const hamburger = document.querySelector(".hamburger");
    const navBar = document.querySelector(".nav-bar");

    hamburger.addEventListener("click", () => {
        navBar.classList.toggle("active");
    });
    </script>
</body>

</html>