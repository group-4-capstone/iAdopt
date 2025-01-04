<?php
include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

// Check session and role
if (isset($_SESSION['email']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'head_admin')) {

    if (!isset($_GET['month']) || !isset($_GET['year'])) {
        header("Location: not-found.php");
        exit();
    }
    $month = ucfirst(strtolower($_GET['month']));
    $year = intval($_GET['year']);

    $valid_months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    if (!in_array($month, $valid_months) || $year < 2010 || $year > date('Y')) {
        header("Location: not-found.php");
        exit();
    }

    // Convert month name to number (e.g., January -> 01)
    $month_number = date('m', strtotime($month));

    // Query to calculate total donations for the selected month and year
    $sql_donations = "SELECT *,
       (SELECT SUM(amount) 
        FROM liquidation 
        WHERE type = 'Donation' 
        AND liquidation_status = 'Verified' 
        AND MONTH(date) = '$month_number' 
        AND YEAR(date) = '$year') AS total_donations
        FROM liquidation
        WHERE type = 'Donation'
        AND liquidation_status = 'Verified'
        AND MONTH(date) = '$month_number'
        AND YEAR(date) = '$year';";

    // Query to calculate total expenses for the selected month and year
    $sql_expenses = "SELECT *,
       (SELECT SUM(amount) 
        FROM liquidation 
        WHERE type = 'Expense' 
        AND MONTH(date) = '$month_number' 
        AND YEAR(date) = '$year') AS total_expenses
        FROM liquidation
        WHERE type = 'Expense'
        AND MONTH(date) = '$month_number'
        AND YEAR(date) = '$year';";

    // Execute the queries
    $result_donations = $db->query($sql_donations);
    $result_expenses = $db->query($sql_expenses);

    $result_donations_total = $db->query($sql_donations);
    $result_expenses_total = $db->query($sql_expenses);

    // Initialize balance
    $total_donations = 0;
    $total_expenses = 0;

    // Fetch donation total
    if ($result_donations_total->num_rows > 0) {
        $row = $result_donations_total->fetch_assoc();
        $total_donations = $row['total_donations'] ?? 0;
    }

    // Fetch expense total
    if ($result_expenses_total->num_rows > 0) {
        $row = $result_expenses_total->fetch_assoc();
        $total_expenses = $row['total_expenses'] ?? 0;
    }


    $donation_balance_month = $total_donations - $total_expenses;
    $current_date = $month . " " . $year;

    $all_balance = 0;

    $donation_query = "SELECT SUM(amount) AS all_donations 
                       FROM liquidation
                       WHERE type = 'Donation'
                       AND liquidation_status = 'Verified'";

    $expense_query = "SELECT SUM(amount) AS all_expenses
                      FROM liquidation
                      WHERE type = 'Expense'";

    $donation_records_result = mysqli_query($db, $donation_query);
    $expense_records_result = mysqli_query($db, $expense_query);

    $donation_row = mysqli_fetch_assoc($donation_records_result);
    $expense_row = mysqli_fetch_assoc($expense_records_result);

    $all_donations = $donation_row['all_donations'] ?? 0;  // Default to 0 if no donations found
    $all_expenses = $expense_row['all_expenses'] ?? 0;      // Default to 0 if no expenses found

    $all_balance = $all_donations - $all_expenses;


?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liquidation Report</title>
        <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Bootstrap Icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <!-- JS CDN-->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                font-size: 12px;
            }

            table th,
            table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            table th {
                background-color: #f4f4f4;
            }

            h2 {
                margin-top: 20px;
            }

            .text-center {
                text-align: center;
            }
        </style>
    </head>

    <body>


  <div class="my-4 mx-4 d-flex justify-content-between align-items-center gap-3">
  <button id="backButton" onclick="window.history.back();" class="btn btn-secondary">Back</button>

  <div class="d-flex gap-3 align-items-center">
    <label for="month" class="form-label mb-0">Month:</label>
    <select id="month" class="form-select w-auto">
      <option value="january">January</option>
      <option value="february">February</option>
      <option value="march">March</option>
      <option value="april">April</option>
      <option value="may">May</option>
      <option value="june">June</option>
      <option value="july">July</option>
      <option value="august">August</option>
      <option value="september">September</option>
      <option value="october">October</option>
      <option value="november">November</option>
      <option value="december">December</option>
    </select>

    <label for="year" class="form-label mb-0">Year:</label>
    <select id="year" class="form-select w-auto"></select>

    <button id="goButton" class="btn btn-primary">Generate</button>
  </div>
</div>


  <script>
    // Set default month and populate the year dropdown
    const monthSelect = document.getElementById('month');
    const yearSelect = document.getElementById('year');
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.toLocaleString('default', { month: 'long' }).toLowerCase();

    // Set the current month as default
    monthSelect.value = currentMonth;

    // Populate the year dropdown
    for (let i = 0; i < 5; i++) {
      const year = currentYear - i;
      const option = document.createElement('option');
      option.value = year;
      option.textContent = year;
      yearSelect.appendChild(option);
    }

    // Set the current year as default
    yearSelect.value = currentYear;

    document.getElementById('goButton').addEventListener('click', function () {
      const month = document.getElementById('month').value;
      const year = document.getElementById('year').value;
      const url = `liquidation-report.php?month=${month}&year=${year}`;
      window.location.href = url;
    });
  </script>
        <div id="reportContainer" class="px-5">

            <h3 class="text-center">Cash Report - <?php echo $current_date ?></h3>
            <h4>Summary</h4>
            <table>
                <tr>
                    <th>Total Donations</th>
                    <td><?php echo number_format($total_donations, 2); ?></td>
                </tr>
                <tr>
                    <th>Total Expenses</th>
                    <td><?php echo number_format($total_expenses, 2); ?></td>
                </tr>
                <tr>
                    <th>Net Total (<?php echo $current_date ?>)</th>
                    <td><?php echo number_format($donation_balance_month, 2); ?></td>
                </tr>
                <tr>
                    <th><?php echo $current_date ?> Carry Over COH</th>
                    <td><?php echo number_format($all_balance - $donation_balance_month, 2); ?></td>
                </tr>
                <tr>
                    <th>Remaining COH</th>
                    <td><?php echo number_format($all_balance, 2); ?></td>
                </tr>
            </table>

            <h4 class="mt-4">Donations <?php echo $current_date ?></h4>
            <table>
                <thead>
                    <tr>
                        <th>Initials</th>
                        <th>Amount</th>
                        <th>Via</th>
                        <th>Date</th>
                        <th>Full Allotment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_donations->num_rows > 0) {
                        while ($donation_row = $result_donations->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $donation_row['donor'] . "</td>";
                            echo "<td>" . number_format($donation_row['amount'], 2) . "</td>";
                            echo "<td>" . $donation_row['mode'] . "</td>";
                            echo "<td>" . date('d M, Y', strtotime($donation_row['date'])) . "</td>";
                            echo "<td>" . $donation_row['description'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No donation records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <h4 class="mt-4">Expenses <?php echo $current_date ?></h4>
            <table>
                <thead>
                    <tr>
                        <th>Payee's Name</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Allocation</th>
                        <th>OR Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_expenses->num_rows > 0) {
                        while ($expense_row = $result_expenses->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $expense_row['payee'] . "</td>";
                            echo "<td>" . number_format($expense_row['amount'], 2) . "</td>";
                            echo "<td>" . date('d M, Y', strtotime($expense_row['date'])) . "</td>";
                            echo "<td>" . $expense_row['description'] . "</td>";
                            echo "<td>" . $expense_row['or_number'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No expense records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script>
    document.addEventListener('DOMContentLoaded', async () => {
        const { jsPDF } = window.jspdf;

        // Set dimensions for long bond paper in landscape orientation
        const pdf = new jsPDF({
            orientation: "landscape",
            unit: "in", // Use inches for easier scaling
            format: [13, 8.5] // Width x Height for long bond
        });

        const container = document.getElementById('reportContainer');

        // Capture the container as an image
        await html2canvas(container, {
            scale: 2 // Improve resolution
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');

            // Calculate dimensions for the image to fit the paper
            const pageWidth = 13;  // Long bond paper width in inches
            const pageHeight = 8.5; // Long bond paper height in inches
            const imgWidth = pageWidth - 1; // 1-inch margin
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            // Add image to PDF
            pdf.addImage(imgData, 'PNG', 0.5, 0.5, imgWidth, imgHeight);
        });

        // Save the PDF with dynamic file name
        pdf.save(`Cash_Report_<?php echo $month ?>_<?php echo $year ?>.pdf`);
    });
</script>

    </body>

    </html>

<?php
} else {
    header("Location: login.php");
}
?>