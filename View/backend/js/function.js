document.addEventListener('DOMContentLoaded', function() {
    // Fetch data for the line chart
    fetchDataForChart();
  
    // Function to fetch data
    function fetchDataForChart() {
      // Example API call
      fetch('https://api.example.com/data')
        .then(response => response.json())
        .then(data => {
          // Process and render the chart with the data
          renderChart(data);
        });
    }
  
    function renderChart(data) {
      // Use a charting library to create the line chart
      const ctx = document.querySelector('.chart-container').getContext('2d');
      const chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Sample Data',
            data: data.values,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
  });