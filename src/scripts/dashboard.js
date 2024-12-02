document.addEventListener("DOMContentLoaded", async function () {
  const canvas = document.getElementById("barChart");
  const ctx = canvas.getContext("2d");
  const dropdownItems = document.querySelectorAll(".dropdown-item");
  const toggleButton = document.querySelector(".months-btn");

  let chart; // Reference to the Chart.js instance

  // Labels for each time period
  const labelsMonthly = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
  const labelsQuarterly = ['Q1', 'Q2', 'Q3', 'Q4'];
  let labelsYearly = [];

  // Fetch data based on the selected period
  async function fetchData(period) {
    const response = await fetch(`includes/fetch-adoption-data.php?period=${period}`);
    const data = await response.json();
    return data;
  }

  // Function to update the chart
  async function updateChart(period) {
    let data = await fetchData(period);
    let labels = [];

    if (period === "monthly") {
      labels = labelsMonthly;
    } else if (period === "quarterly") {
      labels = labelsQuarterly;
    } else if (period === "yearly") {
      labels = data.map(item => item.year); // Extract year labels
      data = data.map(item => item.count); // Extract counts
    }

    // Destroy existing chart if it exists
    if (chart) {
      chart.destroy();
    }

    // Create new chart instance
    chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: `${period.charAt(0).toUpperCase() + period.slice(1)} Adoption Count`,
          data: data,
          backgroundColor: '#FFC107',
          borderColor: '#FFC107',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 5,
            }
          }
        }
      }
    });
  }

  // Event listener for dropdown items
  dropdownItems.forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      const selectedPeriod = item.getAttribute("data-period");
      toggleButton.textContent = item.textContent;
      updateChart(selectedPeriod);
    });
  });

  // Initial load with monthly data
  updateChart("monthly");
});


document.addEventListener("DOMContentLoaded", async function () {
  const canvas = document.getElementById("lineChart");
  const ctx = canvas.getContext("2d");
  const dropdownItems = document.querySelectorAll(".dropdown-item");
  const toggleButton = document.querySelector(".months-btn");

  let chart; // Reference to the Chart.js instance

  // Labels for each time period
const labelsMonthly = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
const labelsQuarterly = ['Q1', 'Q2', 'Q3', 'Q4'];
let labelsYearly = [];

// Fetch data based on the selected period
async function fetchData(period) {
  const response = await fetch(`includes/fetch-liquidation-data.php?period=${period}`);
  const data = await response.json();
  return data;
}

// Function to update the chart
async function updateChart(period) {
  let data = await fetchData(period);
  let labels = [];
  let donationData = [];
  let expenseData = [];

  if (period === "monthly") {
    labels = labelsMonthly;
    donationData = data.donations;
    expenseData = data.expenses;
  } else if (period === "quarterly") {
    labels = labelsQuarterly;
    donationData = data.donations;
    expenseData = data.expenses;
  } else if (period === "yearly") {
    // Get the current year
    const currentYear = new Date().getFullYear();

    // Generate an array with the current year and the last 4 years
    labels = Array.from({ length: 5 }, (_, index) => currentYear - (4 - index));

    // Assuming that data.donations and data.expenses contain data for each of these years
    donationData = labels.map(year => data.donations[year] || 0); // Provide 0 if no data for that year
    expenseData = labels.map(year => data.expenses[year] || 0); // Provide 0 if no data for that year
  }

    // Destroy existing chart if it exists
    if (chart) {
      chart.destroy();
    }

    // Create new chart instance with the updated style
    chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Donations (₱)',
            data: donationData,
            backgroundColor: 'rgba(76, 175, 80, 0.2)',  // Light green for donations
            borderColor: '#092E5A',  // Dark blue for donations, matching the first chart
            borderWidth: 2,
            fill: false,
            tension: 0.4
          },
          {
            label: 'Expenses (₱)',
            data: expenseData,
            backgroundColor: 'rgba(255, 87, 34, 0.2)',  // Light red for expenses
            borderColor: '#f8c613',  // Yellow-orange for expenses, matching the first chart
            borderWidth: 2,
            fill: false,
            tension: 0.4
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            grid: {
              display: false
            },
            title: {
              display: false
            }
          },
          y: {
            grid: {
              display: true,
              borderDash: [5, 5], // Make horizontal grid lines dashed, matching the first chart
              lineWidth: 1,
            },
            ticks: {
              callback: function(value, index, values) {
                return index % 2 === 0 ? value : ''; // Show every other tick label
              },
              stepSize: 5000,
            },
            beginAtZero: true,
            title: {
              display: false
            }
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'top', // Positions the legend above the chart, same as the first chart
            align: 'end',
            labels: {
              fontColor: '#333',
              usePointStyle: true,
              pointStyle: 'circle',
              pointStyleWidth: 15,
              padding: 10
            }
          },
          tooltip: {
            callbacks: {
              label: function(tooltipItem) {
                return tooltipItem.dataset.label + ': ₱' + tooltipItem.raw; // Custom label with currency symbol
              }
            }
          }
        }
      }
    });
  }

  // Event listener for dropdown items
  dropdownItems.forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      const selectedPeriod = item.getAttribute("data-period");
      toggleButton.textContent = item.textContent;
      updateChart(selectedPeriod);
    });
  });

  // Initial load with monthly data
  updateChart("monthly");
});

document.querySelectorAll('.report-item').forEach(item => {
  item.addEventListener('click', async function (e) {
    e.preventDefault();

    const period = this.id.replace('Report', '').toLowerCase(); // Get 'monthly', 'quarterly', or 'yearly'
    
    // Redirect to the new page with the period as a query parameter
    window.location.href = `liquidation-report.php?period=${encodeURIComponent(period)}`;
  });
});
