document.addEventListener("DOMContentLoaded", function() {
    const canvas = document.getElementById('barChart');
    const ctx = canvas.getContext('2d');
  
    // Data for the chart
    const data = [100000, 400000, 350000, 500000, 600000, 450000]; // Rescued numbers in 1000s
    const labels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'];
  
    // Chart settings
    const canvasWidth = canvas.width;
    const canvasHeight = canvas.height;
    const chartPadding = 50;
    const barWidth = 60;
    const maxDataValue = 1000000; // Maximum value (1M)
    const yAxisValues = 5; // Number of vertical axis lines
  
    // Colors
    const barColor = '#FFC107';
    const gridColor = '#eaeaea';
    const textColor = '#666';
    
    // Draw grid lines
    function drawGrid() {
      const stepSize = (canvasHeight - chartPadding * 2) / yAxisValues;
      ctx.strokeStyle = gridColor;
      ctx.lineWidth = 1;
      ctx.font = "12px Arial";
      ctx.fillStyle = textColor;
  
      for (let i = 0; i <= yAxisValues; i++) {
        const y = chartPadding + i * stepSize;
        ctx.beginPath();
        ctx.moveTo(chartPadding, y);
        ctx.lineTo(canvasWidth - chartPadding, y);
        ctx.stroke();
  
        // Add Y-axis labels
        const value = maxDataValue - (i * (maxDataValue / yAxisValues));
        ctx.fillText(`${value / 1000}`, chartPadding - 30, y + 5);
      }
    }
  
   
    // Function to draw rounded bars with left and bottom axis lines (borders)
function drawBars() {
    const stepX = (canvasWidth - chartPadding * 2) / labels.length;
    ctx.font = "14px Arial";
    ctx.fillStyle = textColor;
    const radius = 10;  // Set the radius for rounded corners
    const borderColor = '#666'; // Color of the axis lines
    const borderWidth = 0.5;  // Thickness of the axis lines
  
    // Draw the left Y-axis border
    ctx.strokeStyle = borderColor;
    ctx.lineWidth = borderWidth;
    ctx.beginPath();
    ctx.moveTo(chartPadding, chartPadding);   // Top of Y-axis
    ctx.lineTo(chartPadding, canvasHeight - chartPadding);  // Bottom of Y-axis
    ctx.stroke();
  
    // Draw the bottom X-axis border
    ctx.beginPath();
    ctx.moveTo(chartPadding, canvasHeight - chartPadding);   // Start of X-axis
    ctx.lineTo(canvasWidth - chartPadding, canvasHeight - chartPadding);  // End of X-axis
    ctx.stroke();
  
    // Now draw the bars
    data.forEach((value, index) => {
      const barHeight = (value / maxDataValue) * (canvasHeight - chartPadding * 2);
      const x = chartPadding + index * stepX + (stepX - barWidth) / 2;
      const y = canvasHeight - chartPadding - barHeight;
  
      // Draw the bar with rounded corners at the top
      ctx.fillStyle = barColor;
      
      // Begin the path for rounded corners
      ctx.beginPath();
      ctx.moveTo(x, y + radius);                  // Move to the starting point
      ctx.arcTo(x, y, x + radius, y, radius);     // Top-left corner
      ctx.arcTo(x + barWidth, y, x + barWidth, y + radius, radius);  // Top-right corner
      ctx.lineTo(x + barWidth, canvasHeight - chartPadding);    // Down the right side
      ctx.lineTo(x, canvasHeight - chartPadding);               // Close the rectangle on the bottom
      ctx.closePath();
  
      // Fill the bar
      ctx.fill();
  
      // Add X-axis labels
      ctx.fillStyle = textColor;
      ctx.fillText(labels[index], x + barWidth / 2 - 10, canvasHeight - chartPadding + 20);
    });
  }
  
  
  
    // Function to render the chart
    function renderChart() {
      drawGrid();  // Draw grid lines and Y-axis
      drawBars();  // Draw the bars
    }
  
    renderChart();  // Call the function to draw the chart
  });
  