<?php
include 'db-connect.php';

$timePeriod = $_GET['period'] ?? 'monthly';  // Default is monthly
$data = [];

if ($timePeriod === 'monthly') {
    // SQL query for weekly data for the current month for donations and expenses
    $currentMonth = date('m');
    $currentYear = date('Y');

    $sql = "SELECT 
                WEEK(date, 1) - WEEK(DATE_FORMAT(date, '%Y-%m-01'), 1) + 1 AS period, 
                type, 
                SUM(amount) AS total_amount
            FROM 
                liquidation
            WHERE 
                MONTH(date) = $currentMonth AND YEAR(date) = $currentYear
            GROUP BY 
                period, type
            ORDER BY 
                period, type";

    $result = $db->query($sql);

    // Initialize arrays for up to 5 weeks
    $data = [
        'donations' => array_fill(0, 5, 0),
        'expenses' => array_fill(0, 5, 0)
    ];

    while ($row = $result->fetch_assoc()) {
        $week = (int)$row['period'] - 1;  // Subtract 1 to match zero-indexed array
        $type = $row['type'];
        $amount = (float)$row['total_amount'];

        if ($week >= 0 && $week < 5) {
            if ($type === 'Donation') {
                $data['donations'][$week] = $amount;
            } elseif ($type === 'Expense') {
                $data['expenses'][$week] = $amount;
            }
        }
    }

} elseif ($timePeriod === 'quarterly') {
    // SQL query for quarterly data for donations and expenses
    $sql = "SELECT 
                QUARTER(date) AS period, 
                type, 
                SUM(amount) AS total_amount
            FROM 
                liquidation
            WHERE 
                date IS NOT NULL
            GROUP BY 
                QUARTER(date), type
            ORDER BY 
                QUARTER(date), type";

    $result = $db->query($sql);

    $data = [
        'donations' => array_fill(0, 4, 0), // Initialize for 4 quarters
        'expenses' => array_fill(0, 4, 0)   // Initialize for 4 quarters
    ];

    while ($row = $result->fetch_assoc()) {
        $quarter = (int)$row['period'] - 1;  // Subtract 1 to match zero-indexed array
        $type = $row['type'];
        $amount = (float)$row['total_amount'];

        if ($type === 'Donation') {
            $data['donations'][$quarter] = $amount;
        } elseif ($type === 'Expense') {
            $data['expenses'][$quarter] = $amount;
        }
    }

} elseif ($timePeriod === 'yearly') {
    // SQL query for monthly data for the current year for donations and expenses
    $currentYear = date('Y');

    $sql = "SELECT 
                MONTH(date) AS period, 
                type, 
                SUM(amount) AS total_amount
            FROM 
                liquidation
            WHERE 
                YEAR(date) = $currentYear
            GROUP BY 
                MONTH(date), type
            ORDER BY 
                MONTH(date), type";

    $result = $db->query($sql);

    // Initialize arrays for 12 months
    $data = [
        'donations' => array_fill(0, 12, 0),
        'expenses' => array_fill(0, 12, 0)
    ];

    while ($row = $result->fetch_assoc()) {
        $month = (int)$row['period'] - 1;  // Subtract 1 to match zero-indexed array
        $type = $row['type'];
        $amount = (float)$row['total_amount'];

        if ($type === 'Donation') {
            $data['donations'][$month] = $amount;
        } elseif ($type === 'Expense') {
            $data['expenses'][$month] = $amount;
        }
    }
}

// Return the data as JSON
echo json_encode($data);

// Close the database connection
$db->close();
?>
