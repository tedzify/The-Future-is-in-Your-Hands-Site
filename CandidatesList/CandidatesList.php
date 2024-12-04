<?php
include '../connect.php'; // Include the database connection
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Candidates List</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inria+Serif:wght@700&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap"
    />
    <link rel="stylesheet" href="../src/css/CandidatesList.css" />
  </head>
  <body>
    <div class="main-container">
      <!-- Presidential Candidates -->
      <div class="flex-row-c">
        <span class="candidates">CANDIDATES</span>
        
        <?php
        include 'CandidateBlock.php'; // Include the candidate block function

        // Display candidates from different sections
        displayCandidates($conn, 'presidential_candidates', 'PRESIDENTIAL');
        displayCandidates($conn, 'vp_candidates', 'VICE-PRESIDENTIAL');
        displayCandidates($conn, 'other_candidates', 'SENATORIAL');

        // Close the database connection
        $conn->close();
        ?>
    </div>

    <script src="../src/js/candidate.js"></script>
  </body>
</html>
