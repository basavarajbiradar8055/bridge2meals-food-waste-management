<?php
include "../connection.php";
include("connect.php");
if ($_SESSION['name'] == '') {
    header("location:signin.php");
}
?>

<?php
$connection = mysqli_connect("localhost", "root");
$db = mysqli_select_db($connection, 'socitaldb');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <style>
    :root {
        --primary-color: #FF9800;
        --body-color: #E4E9F7;
        --sidebar-color: #FFF;
        --primary-color-light: #F6F5FF;
        --toggle-color: #DDD;
        --text-color: #707070;
    }

    .dark {
        --body-color: #18191A;
        --sidebar-color: #242526;
        --primary-color-light: #3A3B3C;
        --toggle-color: #FFF;
        --text-color: #CCC;
    }

    .bg-primary {
        background-color: var(--primary-color);
    }

    .text-primary {
        color: var(--primary-color);
    }

    .border-primary {
        border-color: var(--primary-color);
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: opacity 0.2s;
    }

    .btn-primary:hover {
        opacity: 0.9;
    }

    .select-primary {
        border: 2px solid var(--primary-color);
        border-radius: 0.375rem;
        padding: 0.5rem;
        margin-right: 0.5rem;
    }

    nav {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        padding: 10px 14px;
        background-color: var(--sidebar-color);
        transition: all 0.4s ease;
        z-index: 100;
    }

    nav.close {
        width: 88px;
    }

    .dashboard {
        position: relative;
        left: 250px;
        background-color: var(--body-color);
        min-height: 100vh;
        width: calc(100% - 250px);
        padding: 10px 14px;
        transition: all 0.4s ease;
    }

    nav.close~.dashboard {
        left: 88px;
        width: calc(100% - 88px);
    }

    .dashboard .top {
        position: fixed;
        top: 0;
        left: 250px;
        width: calc(100% - 250px);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 14px;
        background-color: var(--body-color);
        z-index: 10;
        transition: all 0.4s ease;
    }

    nav.close~.dashboard .top {
        left: 88px;
        width: calc(100% - 88px);
    }

    .boxes {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-top: 80px;
    }

    .box {
        padding: 20px;
        border-radius: 10px;
        background-color: var(--sidebar-color);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .mode-toggle {
        position: relative;
        min-width: 50px;
        height: 25px;
        border-radius: 25px;
        background-color: var(--toggle-color);
        cursor: pointer;
    }

    .switch {
        position: absolute;
        left: 5px;
        top: 50%;
        transform: translateY(-50%);
        height: 15px;
        width: 15px;
        border-radius: 50%;
        background-color: var(--sidebar-color);
        transition: all 0.3s ease;
    }

    nav.close .nav-words {
        display: none;
        /* Hides menu items */
    }

    nav.close {
        width: 80px;
        /* Shrinks the sidebar */
        overflow: hidden;
    }

    nav.close .logo-name {
        display: flex;
        justify-content: center;
    }

    nav.close .logo-name img {
        max-width: 50px;
        /* Keeps the logo visible */
    }


    .dark .switch {
        left: 25px;
    }

    .table-container {
        overflow-x: auto;
        margin: 1rem 0;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .responsive-table {
        min-width: 100%;
        border-collapse: collapse;
    }

    .responsive-table th {
        background-color: var(--primary-color);
        color: white;
        padding: 1rem;
        text-align: left;
        white-space: nowrap;
    }

    .responsive-table td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 5px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .status-online {
        /* background-color: #10B981; */
        color: black;
    }

    .status-offline {
        /* background-color: #EF4444; */
        color: black;
    }

    .status-assigned {
        background-color: #10B981;
        color: white;
    }

    .status-pending {
        background-color: #EF4444;
        color: white;
    }

    @media (max-width: 768px) {
        .responsive-table {
            display: block;
        }

        .responsive-table thead {
            display: none;
        }

        .responsive-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            background: white;
        }

        .responsive-table td {
            display: flex;
            padding: 0.75rem;
            border: none;
            align-items: center;
        }

        .responsive-table td::before {
            content: attr(data-label);
            font-weight: 600;
            width: 140px;
            min-width: 140px;
            color: #4B5563;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .select-primary {
            margin-bottom: 0.5rem;
            width: 100%;
        }
    }
    </style>

</head>

<body>
    <nav>
        <!-- 
        <div class="logo-name flex items-center justify-center mt-4 mb-2 nav-words">
            <span class="logo_name  text-primary font-bold text-xl">ADMIN DASHBOARD</span>
        </div> -->
        <div class="menu-items mt-5">
            <ul class=" nav-links">

                <li><a href="#" class="flex items-center  p-2 hover:bg-primary-light rounded">
                        <i class="uil uil-estate text-4xl"></i>
                        <span class="link-name ml-2 nav-words">Dashboard</span>
                    </a></li>
                <!-- <li><a href="analytics.php" class="flex items-center  p-2 hover:bg-primary-light rounded">
                        <i class="uil uil-chart text-4xl "></i>
                        <span class="link-name ml-2 nav-words">Analytics</span>
                    </a></li> -->
                <li><a href="donate.php" class="flex items-center  p-2 hover:bg-primary-light rounded">
                        <i class="uil uil-heart text-4xl "></i>
                        <span class="link-name ml-2 nav-words">Donates</span>
                    </a></li>
                <li><a href="feedback.php" class="flex items-center p-2  hover:bg-primary-light rounded">
                        <i class="uil uil-comments text-4xl"></i>
                        <span class="link-name ml-2 nav-words">Feedbacks</span>
                    </a></li>
                <li><a href="adminprofile.php" class="flex items-center p-2 hover:bg-primary-light rounded">
                        <i class="uil uil-user text-4xl"></i>
                        <span class="link-name ml-2 nav-words">Profile</span>
                    </a></li>
            </ul>

            <ul class="logout-mode mt-auto">
                <li><a href="../logout.php" class="flex items-center  p-2 hover:bg-primary-light rounded">
                        <i class="uil uil-signout text-4xl"></i>
                        <span class="link-name ml-2 nav-words">Logout</span>
                    </a></li>
                <!-- <li class="mode flex items-center p-2">
                    <a href="#" class="flex items-center">
                        <i class="uil uil-moon text-4xl"></i>
                        <span class="link-name ml-2">Dark Mode</span>
                    </a>
                    <div class="mode-toggle ml-auto">
                        <span class="switch"></span>
                    </div>
                </li> -->
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top flex justify-center items-center">

            <i class="uil uil-bars text-3xl sidebar-toggle cursor-pointer"></i>

            <div class="logo-name flex justify-center items-center">
                <span class="logo_name text-primary font-bold text-xl">
                    <img src="../img/logo.png" alt="HungerBridge Logo" class="h-16 md:h-16 lg:h-16" />
                </span>
            </div>
        </div>

        <div class="dash-content">
            <!-- Dashboard Stats -->

            <div class="container mx-auto px-4 py-8">
                <div class="overview mt-20">
                    <div class="boxes">
                        <div class="box box1">
                            <i class="uil uil-user text-4xl text-primary"></i>
                            <span class="text block mt-2">Total Users</span>
                            <span class="number font-bold text-2xl">
                                <?php
                                $query = "SELECT count(*) as count FROM login";
                                $result = mysqli_query($connection, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo $row['count'];
                                ?>
                            </span>
                        </div>
                        <div class="box box2">
                            <i class="uil uil-comments text-4xl text-primary"></i>
                            <span class="text block mt-2">Feedbacks</span>
                            <span class="number font-bold text-2xl">
                                <?php
                                $query = "SELECT count(*) as count FROM user_feedback";
                                $result = mysqli_query($connection, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo $row['count'];
                                ?>
                            </span>
                        </div>
                        <div class="box box3">
                            <i class="uil uil-heart text-4xl text-primary"></i>
                            <span class="text block mt-2">Total Donations</span>
                            <span class="number font-bold text-2xl">
                                <?php
                                $query = "SELECT count(*) as count FROM food_donations";
                                $result = mysqli_query($connection, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo $row['count'];
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <section class="p-6 min-h-screen">
                <div class=" mx-auto bg-white  rounded-lg p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Filter by Location</h2>
                        <form method="post" class="mt-4 flex items-center gap-4">
                            <label for="location" class="font-medium text-gray-700">Select Location:</label>
                            <select id="location" name="location"
                                class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                                <option value="bangalore">Bangalore</option>
                                <option value="mysore">Mysore</option>
                                <option value="mangalore">Mangalore</option>
                                <option value="hubli">Hubli</option>
                            </select>
                            <input type="submit" value="Get Details"
                                class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 cursor-pointer">
                        </form>
                    </div>

                    <?php
                    if (isset($_POST['location'])) {
                        $location = $_POST['location'];
                        $sql = "SELECT * FROM food_donations WHERE location='$location'";
                        $result = mysqli_query($connection, $sql);

                        if ($result->num_rows > 0) {
                            echo "<div class='overflow-x-auto'>";
                            echo "<table class='w-full border-collapse border border-gray-300 shadow-md rounded-lg'>";
                            echo "<thead class='bg-blue-600 text-white'>";
                            echo "<tr>"
                                . "<th class='px-4 py-2'>Name</th>"
                                . "<th class='px-4 py-2'>Food</th>"
                                . "<th class='px-4 py-2'>Category</th>"
                                . "<th class='px-4 py-2'>Phone No</th>"
                                . "<th class='px-4 py-2'>Date/Time</th>"
                                . "<th class='px-4 py-2'>Address</th>"
                                . "<th class='px-4 py-2'>Quantity</th>"
                                . "</tr>";
                            echo "</thead><tbody class='bg-white text-gray-700'>";

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='border-b border-gray-200'>"
                                    . "<td class='px-4 py-2 text-center'>" . $row['name'] . "</td>"
                                    . "<td class='px-4 py-2 text-center'>" . $row['food'] . "</td>"
                                    . "<td class='px-4 py-2 text-center'>" . $row['category'] . "</td>"
                                    . "<td class='px-4 py-2 text-center'>" . $row['phoneno'] . "</td>"
                                    . "<td class='px-4 py-2 text-center'>" . $row['date'] . "</td>"
                                    . "<td class='px-4 py-2 text-center'>" . $row['address'] . "</td>"
                                    . "<td class='px-4 py-2 text-center'>" . $row['quantity'] . "</td>"
                                    . "</tr>";
                            }

                            echo "</tbody></table></div>";
                        } else {
                            echo "<p class='text-red-500 font-medium mt-4'>No results found.</p>";
                        }
                    }
                    ?>
                </div>
            </section>


            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const body = document.querySelector("body"),
                    sidebar = document.querySelector("nav"),
                    toggle = document.querySelector(".sidebar-toggle");

                toggle.addEventListener("click", () => {
                    sidebar.classList.toggle("close");
                });
            });;
            </script>
</body>

</html>