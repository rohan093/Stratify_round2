<?php
session_start();
include 'config.php';
include_once 'email_config.php';

//  logged in as a job seeker
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
    header('Location: login.php');
    exit;
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Error: Job ID not specified.');
}

$job_id = intval($_GET['id']);

// Fetch job details
$query = "SELECT * FROM jobs WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Error: Job not found.");
}
$job = $result->fetch_assoc();

// Handle job application submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_job'])) {
    $candidate_name = htmlspecialchars(trim($_POST['candidate_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $cover_letter = htmlspecialchars(trim($_POST['cover_letter'] ?? ''));
    $linkedin_profile = htmlspecialchars(trim($_POST['linkedin_profile'] ?? ''));

    // Handle resume upload
    $upload_dir = "uploads/resumes/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $resume_name = basename($_FILES['resume']['name']);
    $resume_tmp = $_FILES['resume']['tmp_name'];
    $resume_size = $_FILES['resume']['size'];
    $resume_ext = strtolower(pathinfo($resume_name, PATHINFO_EXTENSION));
    $resume_path = $upload_dir . uniqid() . "_" . $resume_name;

    // Validate resume file
    if (!in_array($resume_ext, ['pdf', 'doc', 'docx']) || $resume_size > 5242880) {
        echo "<div class='alert alert-danger'>Invalid file. Only PDF, DOC, and DOCX formats under 5 MB are allowed.</div>";
    } else {
        if (move_uploaded_file($resume_tmp, $resume_path)) {
            // Insert application into the database
            $sql = "INSERT INTO applications (job_id, candidate_name, email, resume, cover_letter, linkedin_profile) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "isssss",
                $job_id,
                $candidate_name,
                $email,
                $resume_path,
                $cover_letter,
                $linkedin_profile
            );

            if ($stmt->execute()) {
                // Notify employer via email
                $job_query = "SELECT users.email, users.name AS employer_name 
                              FROM jobs 
                              JOIN users ON jobs.posted_by = users.id 
                              WHERE jobs.id = ?";
                $stmt = $conn->prepare($job_query);
                $stmt->bind_param("i", $job_id);
                $stmt->execute();
                $job_result = $stmt->get_result();

                if ($job_result->num_rows > 0) {
                    $job_data = $job_result->fetch_assoc();
                    $employer_email = $job_data['email'];
                    $employer_name = $job_data['employer_name'];

                    $subject = "New Job Application Received";
                    $body = "
                        <p>Dear $employer_name,</p>
                        <p>A new application has been submitted for your job posting.</p>
                        <p>Candidate: $candidate_name</p>
                        <p>Email: $email</p>
                        <p>Please log in to your dashboard to review the application.</p>
                        <p>Regards,<br>Job Portal System</p>
                    ";
                    sendEmail($employer_email, $subject, $body);
                }

                echo "<div class='alert alert-success'>Application submitted successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error uploading resume.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
    <!-- Include Bootstrap -->
    <link rel="stylesheet" type="" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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

    <!-- Job Application Form -->
    <div class="container mt-4">
        <h2 class="text-center mb-4">Apply for <?php echo htmlspecialchars($job['title']); ?></h2>
        <form action="apply_job.php?id=<?php echo $job_id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="candidate_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="candidate_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="resume" class="form-label">Resume (Max 5 MB)</label>
                <input type="file" class="form-control" name="resume" accept=".pdf,.doc,.docx" required>
            </div>
            <div class="mb-3">
                <label for="cover_letter" class="form-label">Cover Letter (Optional)</label>
                <textarea class="form-control" name="cover_letter" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label for="linkedin_profile" class="form-label">LinkedIn Profile (Optional)</label>
                <input type="url" class="form-control" name="linkedin_profile">
            </div>
            <div class="text-center">
                <button type="submit" name="apply_job" class="btn btn-primary">Submit Application</button>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
