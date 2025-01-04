<?php
include 'db-connect.php';

$timePeriod = $_GET['period'] ?? 'monthly';
$data = [];

if ($timePeriod === 'monthly') {
    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    $sql = "SELECT 
                WEEK(adoption_date, 1) AS period, 
                COUNT(*) AS adoption_count
            FROM 
                animals
            WHERE 
                adoption_date IS NOT NULL
                AND MONTH(adoption_date) = $currentMonth
                AND YEAR(adoption_date) = $currentYear
            GROUP BY 
                WEEK(adoption_date, 1)
            ORDER BY 
                WEEK(adoption_date, 1)";

    $result = $db->query($sql);
    
    $data = array_fill(0, 5, 0);

    while ($row = $result->fetch_assoc()) {
        $week = (int)$row['period'] - (int)date('W', strtotime("$currentYear-$currentMonth-01")) + 1;
        if ($week >= 1 && $week <= 5) {
            $data[$week - 1] = (int)$row['adoption_count'];
        }
    }
} elseif ($timePeriod === 'quarterly') {
    $sql = "SELECT 
                QUARTER(adoption_date) AS period,
                COUNT(*) AS adoption_count
            FROM 
                animals
            WHERE 
                adoption_date IS NOT NULL
            GROUP BY 
                QUARTER(adoption_date)
            ORDER BY 
                QUARTER(adoption_date)";

    $result = $db->query($sql);

    // Initialize data for 4 quarters
    $data = array_fill(0, 4, 0);

    while ($row = $result->fetch_assoc()) {
        $quarter = (int)$row['period'] - 1;
        $data[$quarter] = (int)$row['adoption_count'];
    }
} elseif ($timePeriod === 'yearly') {
    // Get the current year
    $currentYear = date('Y');

    $sql = "SELECT 
                MONTH(adoption_date) AS period,
                COUNT(*) AS adoption_count
            FROM 
                animals
            WHERE 
                adoption_date IS NOT NULL
                AND YEAR(adoption_date) = $currentYear
            GROUP BY 
                MONTH(adoption_date)
            ORDER BY 
                MONTH(adoption_date)";

    $result = $db->query($sql);
    
    // Initialize data for 12 months
    $data = array_fill(0, 12, 0);

    while ($row = $result->fetch_assoc()) {
        $month = (int)$row['period'] - 1;
        $data[$month] = (int)$row['adoption_count'];
    }
}

echo json_encode($data);
$db->close();
?>
