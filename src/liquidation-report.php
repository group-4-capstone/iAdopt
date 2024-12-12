<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

// Check session and role
if (isset($_SESSION['email']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'head_admin')) { ?>

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
            #reportContainer {
                font-family: Arial, sans-serif;
                width: 100%;
                max-width: 700px;
                margin: auto;
                padding: 20px;
                box-sizing: border-box;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                font-size: 14px;
            }

            table th, table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
            }

            table th {
                background-color: #f4f4f4;
                font-weight: bold;
            }
        </style>
    </head>

    <body>
    <button id="backButton" onclick=" window.history.back();" class="btn btn-secondary" style="margin: 20px;">Back</button>
        <div id="reportContainer" style="display: none;">
            <h1 id="reportTitle"></h1>
            <table>
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Donations</th>
                        <th>Expenses</th>
                    </tr>
                </thead>
                <tbody id="reportContent"></tbody>
            </table>
        </div>

        <script>
            window.addEventListener('load', async () => {
                const urlParams = new URLSearchParams(window.location.search);
                const period = urlParams.get('period');

                const response = await fetch(`includes/fetch-liquidation-data.php?period=${period}`);
                const data = await response.json();

                const reportTitle = document.getElementById('reportTitle');
                const reportContent = document.getElementById('reportContent');
                reportTitle.textContent = `${capitalize(period)} Liquidation Report`;

                if (period === 'yearly' || period === 'quarterly') {
                    const periodNames = period === 'yearly' ? ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] : ['Q1', 'Q2', 'Q3', 'Q4'];

                    data.donations.forEach((donation, index) => {
                        const expense = data.expenses[index];
                        const periodName = periodNames[index] ?? 'N/A';

                        reportContent.innerHTML += `
                            <tr>
                                <td>${periodName}</td>
                                <td>${donation.toFixed(2)}</td>
                                <td>${expense.toFixed(2)}</td>
                            </tr>
                        `;
                    });
                } else if (period === 'monthly') {
                    const periodNames = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];
                    data.donations.forEach((donation, index) => {
                        const expense = data.expenses[index];
                        const periodName = periodNames[index] ?? 'N/A';

                        reportContent.innerHTML += `
                            <tr>
                                <td>${periodName}</td>
                                <td>${donation.toFixed(2)}</td>
                                <td>${expense.toFixed(2)}</td>
                            </tr>
                        `;
                    });
                }

                const reportContainer = document.getElementById('reportContainer');
                reportContainer.style.display = 'block';

                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: "portrait",
                    unit: "pt",
                    format: "letter"
                });

                await html2canvas(reportContainer, {
                    scale: 2
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgWidth = 540; // Fit within letter-size width (8.5 inches = 612 pts, with some margin)
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;

                    pdf.addImage(imgData, 'PNG', 36, 36, imgWidth, imgHeight); // Add 0.5-inch margins
                });

                pdf.save(`${capitalize(period)}-Liquidation-Report.pdf`);
            });

            function capitalize(text) {
                return text.charAt(0).toUpperCase() + text.slice(1);
            }
        </script>
    </body>

    </html>

<?php
} else {
    header("Location: login.php");
}
?>
