<?php
include 'db-connect.php';

$timePeriod = $_GET['period'] ?? 'monthly';

$data = [];

if ($timePeriod === 'monthly') {
    $sql = "SELECT 
                MONTH(adoption_date) AS period, 
                COUNT(*) AS adoption_count
            FROM 
                applications
            WHERE 
                adoption_date IS NOT NULL
            GROUP BY 
                MONTH(adoption_date)
            ORDER BY 
                MONTH(adoption_date)";
    $result = $db->query($sql);
    $data = array_fill(0, 12, 0); // 12 months

    while ($row = $result->fetch_assoc()) {
        $month = (int)$row['period'] - 1;
        $data[$month] = (int)$row['adoption_count'];
    }
} elseif ($timePeriod === 'quarterly') {
    $sql = "SELECT 
                QUARTER(adoption_date) AS period, 
                COUNT(*) AS adoption_count
            FROM 
                applications
            WHERE 
                adoption_date IS NOT NULL
            GROUP BY 
                QUARTER(adoption_date)
            ORDER BY 
                QUARTER(adoption_date)";
    $result = $db->query($sql);
    $data = array_fill(0, 4, 0); // 4 quarters

    while ($row = $result->fetch_assoc()) {
        $quarter = (int)$row['period'] - 1;
        $data[$quarter] = (int)$row['adoption_count'];
    }
} elseif ($timePeriod === 'yearly') {
    $sql = "SELECT 
                YEAR(adoption_date) AS period, 
                COUNT(*) AS adoption_count
            FROM 
                applications
            WHERE 
                adoption_date IS NOT NULL
            GROUP BY 
                YEAR(adoption_date)
            ORDER BY 
                YEAR(adoption_date)";
    $result = $db->query($sql);
    while ($row = $result->fetch_assoc()) {
        $year = $row['period'];
        $data[] = [
            'year' => $year,
            'count' => (int)$row['adoption_count']
        ];
    }
}

echo json_encode($data);
$db->close();
?>
