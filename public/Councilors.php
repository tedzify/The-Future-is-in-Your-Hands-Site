<?php
include '../includes/connect.php'; // Include the database connection
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Councilor Candidates</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap"
    />
    <link rel="stylesheet" href="src/css/CandidateListModule.css" />
  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a href="Mayors">Mayoral Candidates</a></li>
          <li><a href="ViceMayors">Vice Mayoral Candidates</a></li>
          <li>
            <a href="Councilors" class="active">Councilor Candidates</a>
          </li>
        </ul>
      </nav>
    </header>
    <div class="main-container">
                <!-- Vice Mayor Candidates -->
      <div class="flex-row-c">
        <span class="candidates">CANDIDATES</span>
        
        <?php
        include 'module/CandidateBlock.php'; // Include the candidate block function

        // Display candidates from different sections
       displayCandidates($conn, 'councilor_candidates', 'COUNCILOR');

        // Close the database connection
        $conn->close();
        ?>
    </div>
    </div>
    <script src="src/js/CandidateListModule.js"></script>
  </body>
</html>