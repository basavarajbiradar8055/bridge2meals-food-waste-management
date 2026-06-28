<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <style>
    :root {
        --primary-color: #FF9800;
        /* --body-color: #E4E9F7; */
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

    /* Analytics */


    .anadashboard {
        max-width: 800px;
        margin: 0 auto;
    }

    .anadash-content {
        padding: 20px;
    }

    .anaoverview {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: var(--shadow);
    }

    .anatitle {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary-color);
    }

    .anatitle i {
        font-size: 24px;
        color: var(--primary-color);
    }

    .anatitle .text {
        font-size: 24px;
        font-weight: 600;
        color: var(--secondary-color);
    }

    .charts-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }

    .chart-wrapper {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 20px;
        box-shadow: var(--shadow);
    }

    .chart-title {
        font-size: 18px;
        color: var(--secondary-color);
        margin-bottom: 20px;
        text-align: center;
        font-weight: 600;
    }

    canvas {
        width: 100% !important;
        height: 300px !important;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .charts-container {
            grid-template-columns: 1fr;
        }

        .anadash-content {
            padding: 10px;
        }

        canvas {
            height: 250px !important;
        }
    }
    </style>
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
                <li><a href="analytics.php" class="flex items-center  p-2 hover:bg-primary-light rounded">
                        <i class="uil uil-chart text-4xl "></i>
                        <span class="link-name ml-2 nav-words">Analytics</span>
                    </a></li>
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
                    <img src="../img/hungerbridge_LOGO.png" alt="HungerBridge Logo" class="h-16 md:h-16 lg:h-16" />
                </span>
            </div>
        </div>

        <div class="anadash-content">
            <!-- Dashboard Stats -->
            <div class="container mx-auto px-4 py-8">

                <div class="anaoverview">
                    <div class="anatitle">
                        <i class="uil uil-chart"></i>
                        <span class="text">Analytics</span>
                    </div>

                    <div class="charts-container">
                        <div class="chart-wrapper">
                            <div class="chart-title">User Gender Distribution</div>
                            <canvas id="myChart"></canvas>
                        </div>

                        <div class="chart-wrapper">
                            <div class="chart-title">Food Donations by Location</div>
                            <canvas id="donateChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
    </section>



    < <script>
        <?php
        $query = "SELECT count(*) as count FROM  login where gender=\"male\"";
        $q2 = "SELECT count(*) as count FROM  login where gender=\"female\"";
        $result = mysqli_query($connection, $query);
        $res2 = mysqli_query($connection, $q2);
        $row = mysqli_fetch_assoc($result);
        $ro2 = mysqli_fetch_assoc($res2);
        $female = $ro2['count'];
        $male = $row['count'];
        $q3 = "SELECT count(*) as count FROM food_donations where location=\"madurai\"";
        $res3 = mysqli_query($connection, $q3);
        $ro3 = mysqli_fetch_assoc($res3);
        $madurai = $ro3['count'];
        $q4 = "SELECT count(*) as count FROM food_donations where location=\"chennai\"";
        $res4 = mysqli_query($connection, $q4);
        $ro4 = mysqli_fetch_assoc($res4);
        $chennai = $ro4['count'];
        $q5 = "SELECT count(*) as count FROM food_donations where location=\"coimbatore\"";
        $res5 = mysqli_query($connection, $q5);
        $ro5 = mysqli_fetch_assoc($res5);
        $coimbatore = $ro5['count'];
        $q6 = "SELECT count(*) as count FROM food_donations where location=\"perambalur\"";
        $res6 = mysqli_query($connection, $q6);
        $ro6 = mysqli_fetch_assoc($res6);
        $perambalur = $ro6['count'];
        ?>

        var xValues = ["Male", "Female"];
        var xplace = ["Madurai", "Chennai", "Coimbatore", "Perambalur"];
        var yplace = [
        <?php echo json_encode($madurai, JSON_HEX_TAG); ?>,
        <?php echo json_encode($chennai, JSON_HEX_TAG); ?>,
        <?php echo json_encode($coimbatore, JSON_HEX_TAG); ?>,
        <?php echo json_encode($perambalur, JSON_HEX_TAG); ?>
        ];
        var yValues = [
        <?php echo json_encode($male, JSON_HEX_TAG); ?>,
        <?php echo json_encode($female, JSON_HEX_TAG); ?>
        ];

        new Chart("myChart", {
        type: "bar",
        data: {
        labels: xValues,
        datasets: [{
        backgroundColor: ["#06C167", "#4361ee"],
        data: yValues,
        borderRadius: 6,
        barThickness: 40
        }]
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
        display: false
        },
        title: {
        display: true,
        text: "User Gender Distribution",
        fontSize: 16,
        padding: 20
        },
        scales: {
        yAxes: [{
        ticks: {
        beginAtZero: true
        }
        }]
        }
        }
        });

        new Chart("donateChart", {
        type: "bar",
        data: {
        labels: xplace,
        datasets: [{
        backgroundColor: ["#06C167", "#4361ee", "#f72585", "#ff9f1c"],
        data: yplace,
        borderRadius: 6,
        barThickness: 40
        }]
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
        display: false
        },
        title: {
        display: true,
        text: "Food Donations by Location",
        fontSize: 16,
        padding: 20
        },
        scales: {
        yAxes: [{
        ticks: {
        beginAtZero: true
        }
        }]
        }
        }
        });

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