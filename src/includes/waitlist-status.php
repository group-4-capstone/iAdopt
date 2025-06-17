<?php
$query = "SELECT COUNT(*) AS total_waitlist FROM animals WHERE animal_status = 'waitlist'";
$result_limit = mysqli_query($db, $query);
$row_limit = mysqli_fetch_assoc($result_limit);
$waitlistCount = $row_limit['total_waitlist'];

// Determine if the "Report" button should be disabled
$reportDisabled = $waitlistCount >= 10 ? 'disabled' : '';
?>
