document.addEventListener("DOMContentLoaded", async function () {
  const canvas = document.getElementById("barChart");
  const ctx = canvas.getContext("2d");
  const dropdownItems = document.querySelectorAll(".dropdown-item");
  const toggleButton = document.querySelector(".months-btn");

  let chart; // Reference to the Chart.js instance

  // Labels for each time period
  const labelsWeekly = ["Week 1", "Week 2", "Week 3", "Week 4", "Week 5"];
  const labelsQuarterly = ["Q1", "Q2", "Q3", "Q4"];
  const labelsMonthly = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];

  // Fetch data based on the selected period
  async function fetchData(period) {
    const response = await fetch(`includes/fetch-adoption-data.php?period=${period}`);
    const data = await response.json();
    return data;
  }

  // Function to get the current month name
  function getCurrentMonthName() {
    const monthNames = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];
    return monthNames[new Date().getMonth()];
  }

  // Function to get the current year
  function getCurrentYear() {
    return new Date().getFullYear();
  }

  async function updateChart(period) {
    let data = await fetchData(period);
    let labels = [];
    let chartTitle = "";
  
    if (period === "monthly") {
      labels = labelsWeekly;
      chartTitle = `Adoption Count for ${getCurrentMonthName()}`;
    } else if (period === "quarterly") {
      labels = labelsQuarterly;
      chartTitle = `Adoption Count for ${getCurrentYear()}`;
    } else if (period === "yearly") {
      labels = labelsMonthly;
      chartTitle = `Adoption Count for ${getCurrentYear()}`;
    }
  
    // Destroy existing chart if it exists
    if (chart) {
      chart.destroy();
    }
  
    // Create new chart instance without the dataset label
    chart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [
          {
            data: data,
            backgroundColor: "#FFC107",
            borderColor: "#FFC107",
            borderWidth: 1,
          },
        ],
      },
      options: {
        plugins: {
          title: {
            display: true,
            text: chartTitle,
            font: {
              size: 18,
              weight: 'bold'
            },
            padding: {
              top: 0,
              bottom: 10
            }
          },
          legend: {
            display: false // Hide the legend since there's no dataset label
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 5,
            },
          },
        },
      },
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
  const toggleButton = document.querySelector(".donation-btn");

  let chart; 

  // Labels for each time period
  const labelsMonthly = ["Week 1", "Week 2", "Week 3", "Week 4", "Week 5"];
  const labelsQuarterly = ["Q1", "Q2", "Q3", "Q4"];
  const labelsYearly = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];

  // Function to get the current month name
  function getCurrentMonthName() {
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    return monthNames[new Date().getMonth()];
  }

  // Function to get the current year
  function getCurrentYear() {
    return new Date().getFullYear();
  }

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
    let chartTitle = "";

    if (period === "monthly") {
      labels = labelsMonthly;
      chartTitle = `Donations and Expenses for ${getCurrentMonthName()}`;
      donationData = data.donations;
      expenseData = data.expenses;
    } else if (period === "quarterly") {
      labels = labelsQuarterly;
      chartTitle = `Donations and Expenses for ${getCurrentYear()}`;
      donationData = data.donations;
      expenseData = data.expenses;
    } else if (period === "yearly") {
      labels = labelsYearly;
      chartTitle = `Donations and Expenses for ${getCurrentYear()}`;
      donationData = data.donations;
      expenseData = data.expenses;
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
            backgroundColor: 'rgba(76, 175, 80, 0.2)', // Light green for donations
            borderColor: '#092E5A', // Dark blue for donations
            borderWidth: 2,
            fill: false,
            tension: 0.4,
          },
          {
            label: 'Expenses (₱)',
            data: expenseData,
            backgroundColor: 'rgba(255, 87, 34, 0.2)', // Light red for expenses
            borderColor: '#f8c613', // Yellow-orange for expenses
            borderWidth: 2,
            fill: false,
            tension: 0.4,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            grid: {
              display: false,
            },
          },
          y: {
            grid: {
              display: true,
              borderDash: [5, 5], // Dashed grid lines
              lineWidth: 1,
            },
            ticks: {
              callback: function (value, index, values) {
                return index % 2 === 0 ? value : ''; // Show every other tick label
              },
              stepSize: 5000,
            },
            beginAtZero: true,
          },
        },
        plugins: {
          title: {
            display: true,
            text: chartTitle,
            font: {
              size: 18,
              weight: 'bold',
            },
            padding: {
              top: 0,
              bottom: 5,
            },
          },
          legend: {
            display: true,
            position: 'top',
            align: 'end',
            labels: {
              color: '#333',
              usePointStyle: true,
              pointStyle: 'circle',
              padding: 10,
            },
          },
          tooltip: {
            callbacks: {
              label: function (tooltipItem) {
                return tooltipItem.dataset.label + ': ₱' + tooltipItem.raw;
              },
            },
          },
        },
      },
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
