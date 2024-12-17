<?php
include 'includes/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data with correct column names matching the database
    $candidate_Name = $_POST['candidate_Name'];
    $candidate_Age = $_POST['candidate_Age'];
    $candidate_sex = $_POST['candidate_sex'];
    $candidate_Party = $_POST['candidate_Party'];
    $current_Position = $_POST['current_Position'];
    
    // Convert text areas to JSON format
    $education = json_encode([
        'details' => $_POST['education']
    ], JSON_UNESCAPED_UNICODE);
    
    $achievements = json_encode([
        'details' => $_POST['achievements']
    ], JSON_UNESCAPED_UNICODE);
    
    $public_Experience = json_encode([
        'details' => $_POST['public_Experience']
    ], JSON_UNESCAPED_UNICODE);
    
    $other_details = json_encode([
        'details' => $_POST['other_details']
    ], JSON_UNESCAPED_UNICODE);

    // Validate required fields
    if (empty($candidate_Name) || empty($candidate_Age) || empty($candidate_sex) || empty($candidate_Party)) {
        $alert = "<div class='alert alert-warning'>Please fill in all required fields.</div>";
    } else {
        // Determine the table based on the selected option without storing it
        switch ($_POST['position_select']) {
            case 'mayor':
                $table = 'mayor_candidates';
                break;
            case 'vice-mayor':
                $table = 'v_mayor_candidates';
                break;
            case 'councilor':
                $table = 'councilor_candidates';
                break;
            default:
                $table = '';
        }

        if ($table) {
            try {
                // Prepare SQL statement with correct column names
                $sql = "INSERT INTO $table (candidate_Name, candidate_Age, candidate_sex, candidate_Party, current_Position, education, achievements, public_Experience, other_details) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sisssssss", 
                    $candidate_Name,
                    $candidate_Age,
                    $candidate_sex,
                    $candidate_Party,
                    $current_Position,
                    $education,
                    $achievements,
                    $public_Experience,
                    $other_details
                );

                if ($stmt->execute()) {
                    $alert = "<div class='alert alert-success'>Candidate added successfully.</div>";
                } else {
                    $alert = "<div class='alert alert-warning'>Failed to add candidate. Please try again.</div>";
                }
            } catch (mysqli_sql_exception $e) {
                $alert = "<div class='alert alert-danger'>Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        } else {
            $alert = "<div class='alert alert-warning'>Please select a valid position.</div>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Candidates</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          updatePlaceholder(); // Call the function immediately after the page loads
      });

        function updatePlaceholder() {
            const positionSelect = document.getElementById('position_select').value;
            const placeholderElements = document.querySelectorAll('.placeholder-text');
            
            placeholderElements.forEach(element => {
                if (positionSelect) {
                    const formattedText = positionSelect.split('-').map(word => 
                        word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                    element.textContent = formattedText;
                } else {
                    element.textContent = '$Placeholder';
                }
            });
        }
    </script>
</head>
<body>
<nav class="navbar navbar-light justify-content-center fs-3 mb-5 fw-medium" 
     style="background-color: rgb(159, 46, 46); color: white">
    <span class="placeholder-text">$Placeholder</span>&nbsp;Candidate
</nav>
<div class="container">
    <div class="text-center mb-4">
        <h3>Adding New <span class="placeholder-text">$Placeholder</span> Candidate</h3>
        <p class="text-muted">Fill out the necessary details of the candidate</p>
    </div>

    <?php if (isset($alert)) echo $alert; ?>

    <div class="container d-flex justify-content-center">
        <form action="" method="post" style="width: 50vw; min-width: 300px">
            <div class="row mb-3">
                <div class="col-md-7 mb-3">
                    <label for="candidate_Name" class="form-label">Full Name:</label>
                    <input type="text" name="candidate_Name" id="candidate_Name" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="candidate_Age" class="form-label">Age:</label>
                    <input type="number" name="candidate_Age" id="candidate_Age" class="form-control" placeholder="Age" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="candidate_sex" class="form-label">Sex:</label>
                    <input type="text" name="candidate_sex" id="candidate_sex" class="form-control" placeholder="Sex" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 mb-3">
                    <label for="candidate_Party" class="form-label">Political Party:</label>
                    <input type="text" name="candidate_Party" id="candidate_Party" class="form-control" placeholder="Political Party" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="current_Position" class="form-label">Current Position:</label>
                    <input type="text" name="current_Position" id="current_Position" class="form-control" placeholder="Current Position">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="position_select" class="form-label">Running for:</label>
                    <select name="position_select" id="position_select" class="form-control" required onchange="updatePlaceholder()">
                        <option value="mayor" selected>Mayor</option>
                        <option value="vice-mayor">Vice Mayor</option>
                        <option value="councilor">Councilor</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="education" class="form-label">Education:</label>
                <textarea name="education" id="education" class="form-control" rows="3" placeholder="Education details"></textarea>
            </div>
            <div class="mb-3">
                <label for="achievements" class="form-label">Achievements:</label>
                <textarea name="achievements" id="achievements" class="form-control" rows="3" placeholder="Achievements"></textarea>
            </div>
            <div class="mb-3">
                <label for="public_Experience" class="form-label">Public Experience:</label>
                <textarea name="public_Experience" id="public_Experience" class="form-control" rows="3" placeholder="Public Experience"></textarea>
            </div>
            <div class="mb-3">
                <label for="other_details" class="form-label">Other Details:</label>
                <textarea name="other_details" id="other_details" class="form-control" rows="3" placeholder="Other Details"></textarea>
            </div>

            <div class="d-flex justify-content-center mt-4 mb-5 column-gap-3">
            <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-danger" onclick="window.location.href='CandidatesList'">Cancel</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
