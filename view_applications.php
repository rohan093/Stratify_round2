<?php
session_start();
include 'config.php';

// Redirect if not logged in as an employer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header('Location: login.php');
    exit;
}

// Fetch job postings 
$employer_id = $_SESSION['user_id'];
$jobs_query = "SELECT * FROM jobs WHERE posted_by = $employer_id";
$jobs_result = $conn->query($jobs_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applications</title>
    <!-- Include Bootstrap -->
    <link rel="stylesheet" type="" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">JobPortal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Applications for Your Job Postings</h2>

    <?php
    if ($jobs_result->num_rows > 0) {
        while ($job = $jobs_result->fetch_assoc()) {
            $job_id = $job['id'];

            // Fetch applications for each job
            $applications_query = "SELECT * FROM applications WHERE job_id = $job_id";
            $applications_result = $conn->query($applications_query);

            echo "<h4>Job Title: {$job['title']}</h4>";
            echo "<p>Location: {$job['location']}, Job Type: {$job['job_type']}</p>";

            if ($applications_result->num_rows > 0) {
                echo "<table class='table table-bordered mt-3'>";
                echo "<thead><tr><th>Candidate Name</th><th>Email</th><th>Resume</th><th>Status</th><th>Actions</th></tr></thead>";
                echo "<tbody>";

                while ($application = $applications_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$application['candidate_name']}</td>";
                    echo "<td>{$application['email']}</td>";
                    echo "<td><a href='{$application['resume']}' target='_blank'>View Resume</a></td>";
                    echo "<td>{$application['status']}</td>";
                    echo "<td>
                            <form method='POST' action='update_application_status.php' style='display:inline-block;'>
                                <input type='hidden' name='application_id' value='{$application['id']}'>
                                <select name='status' class='form-select' required>
                                    <option value='New' " . ($application['status'] === 'New' ? 'selected' : '') . ">New</option>
                                    <option value='Reviewed' " . ($application['status'] === 'Reviewed' ? 'selected' : '') . ">Reviewed</option>
                                    <option value='Interview Scheduled' " . ($application['status'] === 'Interview Scheduled' ? 'selected' : '') . ">Interview Scheduled</option>
                                </select>
                                <button type='submit' class='btn btn-primary btn-sm mt-1'>Update</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No applications found for this job.</p>";
            }

            echo "<hr>";
        }
    } else {
        echo "<p>No job postings found.</p>";
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
