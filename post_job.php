
<?php
session_start();
include 'config.php';

//  only employers can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header('Location: login.php');
    exit;
}

if (isset($_POST['post_job'])) {
    $title = $_POST['title'];
    $company_name = $_POST['company_name'];
    $description = $_POST['description'];
    $job_type = $_POST['job_type'];
    $location = $_POST['location'];
    $salary_range = $_POST['salary_range'];
    $application_deadline = $_POST['application_deadline'];

    // Handle file upload
    $logo_dir = "uploads/";
    $company_logo = $logo_dir . basename($_FILES['company_logo']['name']);
    $logo_file_type = strtolower(pathinfo($company_logo, PATHINFO_EXTENSION));

    // Validate file type and size
    if (!in_array($logo_file_type, ['jpg', 'jpeg', 'png']) || $_FILES['company_logo']['size'] > 500000) {
        echo "<div class='alert alert-danger'>Invalid logo file. Only JPG, JPEG, and PNG formats under 500 KB are allowed.</div>";
    } else {
        if (move_uploaded_file($_FILES['company_logo']['tmp_name'], $company_logo)) {
            $posted_by = $_SESSION['user_id'];
            $sql = "INSERT INTO jobs (title, company_name, description, job_type, location, salary_range, application_deadline, company_logo, posted_by) 
                    VALUES ('$title', '$company_name', '$description', '$job_type', '$location', '$salary_range', '$application_deadline', '$company_logo', '$posted_by')";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Job posted successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error uploading company logo.</div>";
        }
    }
}
?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
    <!-- Include Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

   
     <link rel="stylesheet" type="" href="style.css">
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-container">
                <h2 class="text-center mb-4">Post a Job</h2>
                <form action="post_job.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Job Title</label>
                        <input type="text" class="form-control" name="title" maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Job Description</label>
                        <textarea class="form-control" name="description" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="job_type" class="form-label">Job Type</label>
                        <select class="form-select" name="job_type" required>
                            <option value="Full Time">Full Time</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Contract">Contract</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="salary_range" class="form-label">Salary Range</label>
                        <input type="text" class="form-control" name="salary_range" required>
                    </div>
                    <div class="mb-3">
                        <label for="application_deadline" class="form-label">Application Deadline</label>
                        <input type="date" class="form-control" name="application_deadline" required>
                    </div>
                    <div class="mb-3">
                        <label for="company_logo" class="form-label">Company Logo (400x400 px)</label>
                        <input type="file" class="form-control" name="company_logo" accept="image/*" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="post_job" class="btn btn-primary btn-block">Post Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
