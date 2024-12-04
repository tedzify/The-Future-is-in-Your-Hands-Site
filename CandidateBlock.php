<?php
function displayCandidates($conn, $tableName, $sectionTitle) {
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
            echo '<div class="image-box"></div>'; // You can add an image here if available
            echo '<button class="candidate-button" onclick="showCandidate(\'' . $sectionTitle . '\', ' . $row['candidate_ID'] . ')">';
            echo htmlspecialchars($row['candidate_Name']); // Display candidate name
            echo '</button>';
            echo '</div>';
        }
    } else {
        echo "<p>No candidates found</p>";
    }

    echo "</div>"; // Close candidates-grid
    echo "</div>"; // Close flex-row-c
}
?>