<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
  // Redirect to the index page if not logged in
  header("Location: index.html");
  exit();
}
?>

<?php
include 'includes/connect.php'; // Include the database connection

// Function to fetch and display candidates from the selected table
function displayCandidates($conn, $tableName)
{
  // Query to fetch candidates from the specified table
  $sql = "SELECT * FROM $tableName";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Loop through each candidate and create a table row
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<th scope='row'>" . $row['candidate_ID'] . "</th>";
      echo "<td>" . $row['candidate_Name'] . "</td>";
      echo "<td>" . $row['candidate_Party'] . "</td>";
      echo "<td>" . $row['candidate_Age'] . "</td>";
      echo "<td>" . $row['candidate_sex'] . "</td>";
      echo "<td>
                    <a href='EditCandidates.php?id=" . $row['candidate_ID'] . "&table=" . $tableName . "' class='link-dark'><i class='fa-solid fa-pen-to-square fs-5 me-3'></i></a>
                    <a href='DeleteCandidate.php?id=" . $row['candidate_ID'] . "&table=" . $tableName . "' class='link-dark'><i class='fa-solid fa-trash fs-5'></i></a>
                  </td>";
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='6'>No candidates found</td></tr>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial.0">
  <title>Candidates List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <nav class="navbar navbar-light justify-content-center fs-3 mb-5 fw-medium" style="background-color: rgb(159, 46, 46); color: white;">
    <a href="CandidatesList" class="btn position-absolute start-0 ms-3"
      style="background-color: #f4bd0b; color: white;">
      <i class="fas fa-arrow-left"></i>
    </a>
    Candidate List
  </nav>

  <?php

  if (isset($_SESSION['alert'])) {
    echo $_SESSION['alert'];
    unset($_SESSION['alert']); // Remove the alert message from the session
  }
  ?>

  <div class="container">
    <div class="col d-flex mb-3">
      <a name="add_candidates" id="add_candidates" class="col-md-2 btn btn-dark me-3" href="AddCandidates" role="button">Add New</a>
      <select name="position_filter" id="position_filter" class="col form-select" onchange="filterCandidates()">
        <option value="mayor" selected>Mayor</option>
        <option value="vice-mayor">Vice Mayor</option>
        <option value="councilor">Councilor</option>
      </select>
    </div>
    <table class="table table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Full Name</th>
          <th scope="col">Party</th>
          <th scope="col">Age</th>
          <th scope="col">Sex</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody id="candidateTableBody">
        <?php
        // Determine which table to display based on the selected option
        $selectedTable = $_GET['position_filter'] ?? 'mayor_candidates';

        switch ($selectedTable) {
          case 'vice-mayor':
            displayCandidates($conn, 'v_mayor_candidates');
            break;
          case 'councilor':
            displayCandidates($conn, 'councilor_candidates');
            break;
          default:
            displayCandidates($conn, 'mayor_candidates');
            break;
        }
        ?>
      </tbody>
    </table>
  </div>

  <script>
    function filterCandidates() {
      const selectedPosition = document.getElementById('position_filter').value;

      // Make an AJAX request to fetch the candidates based on the selected position
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Update the table body with the fetched candidates
            document.getElementById('candidateTableBody').innerHTML = xhr.responseText;
          } else {
            console.error('Error fetching candidates:', xhr.status);
          }
        }
      };
      xhr.open('GET', 'fetch_candidates.php?position=' + selectedPosition, true);
      xhr.send();
    }
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>