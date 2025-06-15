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
include 'includes/connect.php';

if (isset($_GET['id']) && isset($_GET['table'])) {
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

    // Check if the fields are not null before accessing array offsets
    $education = json_decode($row['education'], true);
    $education = $education !== null ? $education['details'] : '';

    $achievements = json_decode($row['achievements'], true);
    $achievements = $achievements !== null ? $achievements['details'] : '';

    $publicExperience = json_decode($row['public_Experience'], true);
    $publicExperience = $publicExperience !== null ? $publicExperience['details'] : '';

    $otherDetails = json_decode($row['other_details'], true);
    $otherDetails = $otherDetails !== null ? $otherDetails['details'] : '';

    // Determine the placeholder text based on the table name
    $placeholderText = '';
    switch ($tableName) {
      case 'mayor_candidates':
        $placeholderText = 'Mayor';
        break;
      case 'v_mayor_candidates':
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
    // Handle the case when the candidate is not found
    echo "<script>alert('Candidate not found.');</script>";
    echo "<script>window.location.href = 'AdminCandidatesList';</script>";
    exit();
  }
} else {
  // Handle the case when the required parameters are missing
  echo "<script>alert('Missing required parameters.');</script>";
  echo "<script>window.location.href = 'AdminCandidatesList';</script>";
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve the updated form data
  $updatedCandidateName = $_POST['candidate_Name'];
  $updatedCandidateAge = $_POST['candidate_Age'];
  $updatedCandidateSex = $_POST['candidate_sex'];
  $updatedCandidateParty = $_POST['candidate_Party'];
  $updatedCurrentPosition = $_POST['current_Position'];
  $updatedEducation = json_encode(['details' => $_POST['education']], JSON_UNESCAPED_UNICODE);
  $updatedAchievements = json_encode(['details' => $_POST['achievements']], JSON_UNESCAPED_UNICODE);
  $updatedPublicExperience = json_encode(['details' => $_POST['public_Experience']], JSON_UNESCAPED_UNICODE);
  $updatedOtherDetails = json_encode(['details' => $_POST['other_details']], JSON_UNESCAPED_UNICODE);

  // Update the candidate's information in the database
  $updateSql = "UPDATE $tableName SET 
                candidate_Name = ?, 
                candidate_Age = ?, 
                candidate_sex = ?, 
                candidate_Party = ?, 
                current_Position = ?, 
                education = ?, 
                achievements = ?, 
                public_Experience = ?, 
                other_details = ?
              WHERE candidate_ID = ?";
  $updateStmt = $conn->prepare($updateSql);
  $updateStmt->bind_param("sisssssssi", $updatedCandidateName, $updatedCandidateAge, $updatedCandidateSex, $updatedCandidateParty, $updatedCurrentPosition, $updatedEducation, $updatedAchievements, $updatedPublicExperience, $updatedOtherDetails, $candidateID);

  if ($updateStmt->execute()) {
    $_SESSION['alert'] = "<div class='alert alert-success'>Candidate updated successfully.</div>";
  } else {
    $_SESSION['alert'] = "<div class='alert alert-warning'>Failed to update candidate. Please try again.</div>";
  }

  header("Location: AdminCandidatesList");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Edit <?php echo $placeholderText; ?> Candidate</title>
</head>

<body>
  <nav class="navbar navbar-light justify-content-center position-relative mb-5"
    style="background-color: rgb(159, 46, 46); color: white">
    <a href="AdminCandidatesList" class="btn position-absolute start-0 ms-3"
      style="background-color: #f4bd0b; color: white;">
      <i class="fas fa-arrow-left"></i>
    </a>
    <span class="placeholder-text fs-3 fw-medium" style="color: white;"><?php echo $placeholderText; ?></span><span
      class="fs-3 fw-medium" style="color: white;">&nbsp;Candidate</span>
  </nav>
  <div class="container">
    <div class="text-center mb-4">
      <h3>Editing <span class="placeholder-text"><?php echo $placeholderText; ?></span> Candidate</h3>
      <p class="text-muted">Edit the details of the candidate</p>
    </div>
    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width: 50vw; min-width: 300px">
        <div class="row mb-3">
          <div class="col-md-7 mb-3">
            <label for="candidate_Name" class="form-label">Name:</label>
            <input type="text" name="candidate_Name" id="candidate_Name" class="form-control"
              value="<?php echo htmlspecialchars($candidateName); ?>" required>
          </div>
          <div class="col-md-2 mb-3">
            <label for="candidate_Age" class="form-label">Age:</label>
            <input type="text" name="candidate_Age" id="candidate_Age" class="form-control"
              value="<?php echo htmlspecialchars($candidateAge); ?>" required>
          </div>
          <div class="col-md-3 mb-3">
            <label for="candidate_sex" class="form-label">Sex:</label>
            <input type="text" name="candidate_sex" id="candidate_sex" class="form-control"
              value="<?php echo htmlspecialchars($candidateSex); ?>" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6 mb-3">
            <label for="candidate_Party" class="form-label">Political Party:</label>
            <input type="text" name="candidate_Party" id="candidate_Party" class="form-control"
              value="<?php echo htmlspecialchars($candidateParty); ?>" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="current_Position" class="form-label">Current Position:</label>
            <input type="text" name="current_Position" id="current_Position" class="form-control"
              value="<?php echo htmlspecialchars($currentPosition); ?>">
          </div>
        </div>
        <div class="mb-3">
          <label for="education" class="form-label">Education:</label>
          <textarea name="education" id="education" class="form-control"
            rows="3"><?php echo htmlspecialchars($education); ?></textarea>
        </div>
        <div class="mb-3">
          <label for="achievements" class="form-label">Achievements:</label>
          <textarea name="achievements" id="achievements" class="form-control"
            rows="3"><?php echo htmlspecialchars($achievements); ?></textarea>
        </div>
        <div class="mb-3">
          <label for="public_Experience" class="form-label">Public Experience:</label>
          <textarea name="public_Experience" id="public_Experience" class="form-control"
            rows="3"><?php echo htmlspecialchars($publicExperience); ?></textarea>
        </div>
        <div class="mb-3">
          <label for="other_details" class="form-label">Other Details:</label>
          <textarea name="other_details" id="other_details" class="form-control"
            rows="3"><?php echo htmlspecialchars($otherDetails); ?></textarea>
        </div>
        <div class="d-flex justify-content-center mt-4 mb-5 column-gap-3">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-danger"
            onclick="window.location.href='AdminCandidatesList'">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>