<?php
include 'includes/connect.php'; // Include the database connection

// Retrieve the candidate ID and table name from the URL parameters
$candidateID = $_GET['id'];
$tableName = $_GET['table'];

// Fetch the candidate's information from the database based on the provided ID and table name
$sql = "SELECT * FROM $tableName WHERE candidate_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $candidateID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $candidateName = $row['candidate_Name'];
  $candidateAge = $row['candidate_Age'];
  $candidateSex = $row['candidate_sex'];
  $candidateParty = $row['candidate_Party'];
  $currentPosition = $row['current_Position'];

  // Decode the JSON data
  $education = json_decode($row['education'], true);
  $publicExperience = json_decode($row['public_Experience'], true);
  $achievements = json_decode($row['achievements'], true);
  $otherDetails = json_decode($row['other_details'], true);

  // Determine the placeholder text based on the table name
  $placeholderText = '';
  switch ($tableName) {
    case 'mayor_candidates':
      $placeholderText = 'Mayor';
      break;
    case 'vice_mayor_candidates':
      $placeholderText = 'Vice Mayor';
      break;
    case 'councilor_candidates':
      $placeholderText = 'Councilor';
      break;
    default:
      $placeholderText = 'Candidate';
      break;
  }
} else {
  echo "Candidate not found.";
  exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=4, initial-scale=1.0" />
  <title>Candidate Info</title>
  <link rel="stylesheet" href="src/css/candidate_info.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
    rel="stylesheet" />
</head>

<body>
  <a href="CandidatesList" class="back-button">Back</a>
  <div style="display: grid; grid-template-columns: 1fr 1fr">
    <div class="candidate-image">
      <img class="map" src="src/images/Candidate_Info/grey.png" />
      <img
        class="candidate-portrait"
        src="src/images/CandidateInfo/male-shadow.png" />
    </div>

    <div class="candidate-data">
      <p class="for-mayor">For <?php echo htmlspecialchars($placeholderText); ?></p>
      <div class="candidate-name-div">
        <h1 class="candidate-name"><?php echo htmlspecialchars($candidateName); ?></h1>
        <p class="party-name"><?php echo htmlspecialchars($candidateParty); ?></p>
        <p class="remarks-title">Age: <?php echo htmlspecialchars($candidateAge); ?></p>
        <p class="remarks-title">Current Position: <?php echo htmlspecialchars($currentPosition); ?></p>

        <p class="biography-title">Education</p>
        <p class="biography-info">
          <?php echo isset($education['details']) ? nl2br(htmlspecialchars($education['details'])) : 'N/A'; ?>
        </p>
        <p class="biography-title">Public Experience</p>
        <p class="biography-info">
          <?php echo isset($publicExperience['details']) ? nl2br(htmlspecialchars($publicExperience['details'])) : 'N/A'; ?>
        </p>

        <p class="biography-title">Achievements</p>
        <p class="biography-info">
          <?php echo isset($achievements['details']) ? nl2br(htmlspecialchars($achievements['details'])) : 'N/A'; ?>
        </p>

        <p class="biography-title">Other Details</p>
        <p class="biography-info">
          <?php echo isset($otherDetails['details']) ? nl2br(htmlspecialchars($otherDetails['details'])) : 'N/A'; ?>
        </p>
      </div>
    </div>
  </div>
</body>

</html>