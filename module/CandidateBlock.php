<?php
function displayCandidates($conn, $tableName, $sectionTitle)
{
    // Query to fetch candidates from the specified table
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);

    echo "<div class='flex-row-c'>";
    echo "<span class='section-title'>$sectionTitle</span>";
    echo "<div class='candidates-grid'>";

    if ($result->num_rows > 0) {
        // Loop through each candidate and create a block
        while ($row = $result->fetch_assoc()) {
            echo '<div class="candidate-row">';
            echo '<div class="image-box">';
            if ($row['candidate_sex'] === 'Female') {
                echo '<img src="src/images/CandidatesList/Female.png" alt="Female Placeholder">';
            } else {
                echo '<img src="src/images/CandidatesList/Male.png" alt="Male Placeholder">';
            }
            echo '</div>';
            echo '<a href="CandidateInfo?id=' . $row['candidate_ID'] . '&table=' . $tableName . '" class="candidate-button">';
            echo htmlspecialchars($row['candidate_Name']); // Display candidate name
            echo '</a>';
            echo '</div>';
        }
    } else {
        echo "<p>No candidates found</p>";
    }

    echo "</div>"; // Close candidates-grid
    echo "</div>"; // Close flex-row-c
}
