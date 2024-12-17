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

// Get the selected position from the AJAX request
$selectedPosition = $_GET['position'] ?? 'mayor';

// Determine which table to fetch candidates from based on the selected position
switch ($selectedPosition) {
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
