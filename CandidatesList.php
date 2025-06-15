<?php
include 'includes/connect.php'; // Include the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Candidates</title>
  <link rel="stylesheet" href="src/css/CandidateListModule.css" />
  <script src="src/js/CandidateListModule.js"></script>
</head>
<body>
  <?php include 'module/HeaderSticky.php'; ?>

  <div class="main-container">
    <div class="flex-row-c">
      <span class="candidates">CANDIDATES</span>
      
      <?php
      include 'module/CandidateBlock.php'; // Include the candidate block function

      // Determine which category to display based on a query parameter
      $category = $_GET['category'] ?? 'mayor'; // Default to 'mayor' if no category is set

      switch ($category) {
        case 'vice-mayor':
          displayCandidates($conn, 'v_mayor_candidates', 'VICE-MAYOR');
          break;
        case 'councilor':
          displayCandidates($conn, 'councilor_candidates', 'COUNCILOR');
          break;
        case 'mayor':
        default:
          displayCandidates($conn, 'mayor_candidates', 'MAYOR');
          break;
      }

      // Close the database connection
      $conn->close();
      ?>
    </div>
  </div>
</body>
</html>
