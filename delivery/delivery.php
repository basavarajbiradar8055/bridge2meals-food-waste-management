<?php
// Database Connection
include '../delivery/connect.php';

// Ensure delivery agent is logged in
if (!isset($_SESSION['Did'])) {
    header("Location: login.php");
    exit();
}

$delivery_agent_id = $_SESSION['Did'];

// Fetch Delivery Agent's City
$agentQuery = "SELECT city FROM delivery_persons WHERE Did = ?";
$stmt = $connection->prepare($agentQuery);
$stmt->bind_param("i", $delivery_agent_id);
$stmt->execute();
$result = $stmt->get_result();
$agent = $result->fetch_assoc();
$agent_city = $agent['city'] ?? '';

// Fetch Admin's Address (Drop Location) from Admin Table
$adminQuery = "SELECT address FROM admin WHERE location = ?";
$stmt = $connection->prepare($adminQuery);
$stmt->bind_param("s", $agent_city);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$drop_location = $admin['address'] ?? 'Not Available';

// Fetch Assigned Orders for Delivery Agent (Without `status` filter)
$orderQuery = "SELECT * FROM food_donations WHERE assigned_to = ? AND location = ?";
$stmt = $connection->prepare($orderQuery);
$stmt->bind_param("is", $delivery_agent_id, $agent_city);
$stmt->execute();
$orders = $stmt->get_result();

// Fetch Delivered Orders (Order History) - Filter by City (Without `status` filter)
$historyQuery = "SELECT * FROM food_donations WHERE assigned_to = ? AND location = ? ORDER BY date DESC";
$stmt = $connection->prepare($historyQuery);
$stmt->bind_param("is", $delivery_agent_id, $agent_city);
$stmt->execute();
$history = $stmt->get_result();

// Toggle Online/Offline Status
if (isset($_POST['toggle_status'])) {
    $new_status = ($online_status == 'Online') ? 'Offline' : 'Online';
    $statusQuery = "UPDATE delivery_persons SET online_status = ? WHERE Did = ?";
    $stmt = $connection->prepare($statusQuery);
    $stmt->bind_param("si", $new_status, $delivery_agent_id);
    $stmt->execute();
    $online_status = $new_status;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
    :root {
        --primary-color: #FF9800;
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
        }

        .responsive-table td {
            display: flex;
            padding: 0.5rem;
            border: none;
        }

        .responsive-table td::before {
            content: attr(data-label);
            font-weight: bold;
            width: 120px;
            min-width: 120px;
        }
    }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-wrap items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Delivery Agent Dashboard</h2>
                <div class="flex items-center space-x-4">
                    <!-- <p class="text-gray-600">Status: <span
                            class="font-bold <?php echo $online_status == 'Online' ? 'text-green-500' : 'text-red-500'; ?>"><?php echo htmlspecialchars($online_status); ?></span>
                    </p> -->
                    <p class="text-gray-600">Status: <span>Online</span>
                    </p>
                    <form method="POST">
                        <button type="submit" name="toggle_status" class="btn-primary">
                            Toggle Online/Offline
                        </button>
                    </form>
                </div>
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-4">Assigned Orders</h3>
            <div class="table-container">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Food ID</th>
                            <th>Food Details</th>
                            <th>Quantity</th>
                            <th>Donor Name</th>
                            <th>Phone No</th>
                            <th>Pickup Location</th>
                            <th>Drop Location</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $orders->fetch_assoc()) { ?>
                        <tr>
                            <td data-label="Food ID"><?php echo htmlspecialchars($order['Fid']); ?></td>
                            <td data-label="Food Details"><?php echo htmlspecialchars($order['food']); ?></td>
                            <td data-label="Quantity"><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td data-label="Donor Name"><?php echo htmlspecialchars($order['name']); ?></td>
                            <td data-label="Phone No"><?php echo htmlspecialchars($order['phoneno']); ?></td>
                            <td data-label="Pickup Location"><?php echo htmlspecialchars($order['address']); ?></td>
                            <td data-label="Drop Location"><?php echo htmlspecialchars($drop_location); ?></td>
                            <td data-label="Status"><?php echo htmlspecialchars($order['status']); ?></td>
                            <td data-label="Action">
                                <form method="POST">
                                    <input type="hidden" name="food_id" value="<?php echo $order['Fid']; ?>">
                                    <?php if ($order['status'] == 'Assigned to Delivery Rider') { ?>
                                    <button type="submit" name="accept_order" class="btn-primary mb-2">Accept
                                        Order</button>
                                    <?php } ?>
                                    <?php if ($order['status'] == 'Delivery Agent Accepted') { ?>
                                    <button type="submit" name="mark_delivered" class="btn-primary">Mark as
                                        Delivered</button>
                                    <?php } ?>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-8">Delivery History</h3>
            <div class="table-container">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Food ID</th>
                            <th>Food Details</th>
                            <th>Quantity</th>
                            <th>Donor Name</th>
                            <th>Phone No</th>
                            <th>Pickup Location</th>
                            <th>Drop Location</th>
                            <th>Delivered On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($delivered = $history->fetch_assoc()) { ?>
                        <tr>
                            <td data-label="Food ID"><?php echo htmlspecialchars($delivered['Fid']); ?></td>
                            <td data-label="Food Details"><?php echo htmlspecialchars($delivered['food']); ?></td>
                            <td data-label="Quantity"><?php echo htmlspecialchars($delivered['quantity']); ?></td>
                            <td data-label="Donor Name"><?php echo htmlspecialchars($delivered['name']); ?></td>
                            <td data-label="Phone No"><?php echo htmlspecialchars($delivered['phoneno']); ?></td>
                            <td data-label="Pickup Location"><?php echo htmlspecialchars($delivered['address']); ?></td>
                            <td data-label="Drop Location"><?php echo htmlspecialchars($drop_location); ?></td>
                            <td data-label="Delivered On"><?php echo htmlspecialchars($delivered['date']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>