<?php
session_start(); // Start the session at the beginning of the file

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the index page if not logged in
    header("Location: index.html");
    exit();
}

include 'includes/connect.php';

if (isset($_GET['id']) && isset($_GET['table'])) {
    $candidateID = $_GET['id'];
    $tableName = $_GET['table'];

    // Prepare the SQL statement to delete the candidate from the specified table
    $sql = "DELETE FROM $tableName WHERE candidate_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $candidateID);

    if ($stmt->execute()) {
        // Deletion successful
        $_SESSION['alert'] = "<div class='alert alert-success'>Candidate deleted successfully.</div>";
    } else {
        // Deletion failed
        $_SESSION['alert'] = "<div class='alert alert-danger'>Failed to delete candidate. Please try again.</div>";
    }

    // Close the statement
    $stmt->close();
} else {
    // Required parameters missing
    $_SESSION['alert'] = "<div class='alert alert-warning'>Invalid request. Candidate ID and table name are required.</div>";
}

// Close the database connection
$conn->close();

// Redirect back to the candidate list page
header("Location: AdminCandidatesList");
exit();
