<?php
include 'db-connect.php';

$timePeriod = $_GET['period'] ?? 'monthly';  // Default is monthly
$data = [];

if ($timePeriod === 'monthly') {
    // SQL query for monthly data for donations and expenses
    $sql = "SELECT 
                MONTH(date) AS period, 
                type, 
                SUM(amount) AS total_amount
            FROM 
                liquidation
            WHERE 
                date IS NOT NULL
            GROUP BY 
                MONTH(date), type
            ORDER BY 
                MONTH(date), type";
    $result = $db->query($sql);
    $data = [
        'donations' => array_fill(0, 12, 0), // Initialize for 12 months
        'expenses' => array_fill(0, 12, 0)    // Initialize for 12 months
    ];

    while ($row = $result->fetch_assoc()) {
        $month = (int)$row['period'] - 1;  // Subtract 1 to match the zero-indexed array
        $type = $row['type'];
        $amount = (float)$row['total_amount'];

        if ($type === 'Donation') {
            $data['donations'][$month] = $amount;
        } elseif ($type === 'Expense') {
            $data['expenses'][$month] = $amount;
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
        'expenses' => array_fill(0, 4, 0)    // Initialize for 4 quarters
    ];

    while ($row = $result->fetch_assoc()) {
        $quarter = (int)$row['period'] - 1;  // Subtract 1 to match the zero-indexed array
        $type = $row['type'];
        $amount = (float)$row['total_amount'];

        if ($type === 'Donation') {
            $data['donations'][$quarter] = $amount;
        } elseif ($type === 'Expense') {
            $data['expenses'][$quarter] = $amount;
        }
    }
} elseif ($timePeriod === 'yearly') {
    // SQL query for yearly data for donations and expenses
    $sql = "SELECT 
                YEAR(date) AS period, 
                type, 
                SUM(amount) AS total_amount
            FROM 
                liquidation
            WHERE 
                date IS NOT NULL
            GROUP BY 
                YEAR(date), type
            ORDER BY 
                YEAR(date), type";
    $result = $db->query($sql);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $year = $row['period'];
        $type = $row['type'];
        $amount = (float)$row['total_amount'];

        if ($type === 'Donation') {
            $data[$year]['donations'] = $amount;
        } elseif ($type === 'Expense') {
            $data[$year]['expenses'] = $amount;
        }
    }
}

// Return the data as JSON
echo json_encode($data);

// Close the database connection
$db->close();
?>