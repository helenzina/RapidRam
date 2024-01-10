$(document).ready(function () {
  $('#myTable1').DataTable();
});

$(document).ready(function () {
  $('#myTable2').DataTable();
});

// Get the canvas element
var ctx = document.getElementById('salesChart').getContext('2d');

// Sample data for the sales chart
var data = {
  labels: ['September', 'October', 'November', 'December'],
  datasets: [{
    label: 'Sales',
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    borderColor: 'rgba(75, 192, 192, 1)',
    borderWidth: 1,
    data: [65000, 55000, 70000, 85000]
  }]
};

// Configure the chart options
var options = {
  scales: {
    y: {
      beginAtZero: true,
      scaleLabel: {
        display: true,
        labelString: '%'
      }
    }
  }
};

// Create the sales chart
var salesChart = new Chart(ctx, {
  type: 'bar',
  data: data,
  options: options
});

function validateForm(event) {
  event.preventDefault(); // Prevent the default form submission

  var passwordInput = document.getElementById('password');
  var password = passwordInput.value;

  if (password === "1234") {
    alert("Password is correct. Redirecting...");
    window.location.href = "admin.php";
  } else {
    alert("Incorrect password. Please try again.");
    passwordInput.value = "";
  }
}

