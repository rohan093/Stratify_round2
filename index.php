<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search</title>
    <!-- Include Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-bottom: 15px;
        }
    </style>
    \ <link rel="stylesheet" type="" href="style.css">
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
    <h2 class="text-center mb-4">Search for Jobs</h2>
    <form method="GET" action="index.php">
        <div class="row">
            <div class="col-md-3 mb-3">
                <input type="text" class="form-control" name="title" placeholder="Job Title">
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" class="form-control" name="company" placeholder="Company Name">
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" class="form-control" name="location" placeholder="Location">
            </div>
            <div class="col-md-3 mb-3">
                <select class="form-select" name="job_type">
                    <option value="">Job Type</option>
                    <option value="Full Time">Full Time</option>
                    <option value="Part Time">Part Time</option>
                    <option value="Contract">Contract</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>
    <hr>
    <h3 class="mb-4">Job Listings</h3>
    <div class="row">
        <?php
        include 'config.php';

        // Build the query
        $query = "SELECT * FROM jobs WHERE 1=1";
        if (!empty($_GET['title'])) {
            $title = $_GET['title'];
            $query .= " AND title LIKE '%$title%'";
        }
        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
            $query .= " AND company_name LIKE '%$company%'";
        }
        if (!empty($_GET['location'])) {
            $location = $_GET['location'];
            $query .= " AND location LIKE '%$location%'";
        }
        if (!empty($_GET['job_type'])) {
            $job_type = $_GET['job_type'];
            $query .= " AND job_type = '$job_type'";
        }

        // Fetch jobs
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='col-md-4'>
                    <div class='card'>
                        <img src='{$row['company_logo']}' class='card-img-top' alt='Company Logo'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$row['title']}</h5>
                            <p class='card-text'><strong>Company:</strong> {$row['company_name']}</p>
                            <p class='card-text'><strong>Location:</strong> {$row['location']}</p>
                            <p class='card-text'><strong>Type:</strong> {$row['job_type']}</p>
                            <a href='apply_job.php?id={$row['id']}' class='btn btn-primary'>Apply Now</a>
                        </div>
                    </div>
                </div>
                ";
            }
        } else {
            echo "<p>No jobs found.</p>";
        }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
