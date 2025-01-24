 <!-- <?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

echo "Welcome, " . $_SESSION['name'] . "!<br>";
echo "You are logged in as " . $_SESSION['role'] . ".<br>";

if ($_SESSION['role'] === 'employer') {
    echo "<a href='post_job.php'>Post a Job</a><br>";
    echo "<a href='view_applications.php'>View Applications</a><br>";
} else {
    echo "<a href='index.php'>Search Jobs</a><br>";
}

echo "<a href='logout.php'>Logout</a>";
?>  -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
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
    <div class="dashboard-container">
        <h2 class="text-center">Welcome, <?php echo $_SESSION['name']; ?>!</h2>
        <p class="text-center">You are logged in as <strong><?php echo $_SESSION['role']; ?></strong>.</p>
        <div class="text-center mt-4">
            <?php if ($_SESSION['role'] === 'employer'): ?>
                <a href="post_job.php" class="btn btn-primary btn-lg">Post a Job</a>
                <a href="view_applications.php" class="btn btn-secondary btn-lg">View Applications</a>
            <?php else: ?>
                <a href="index.php" class="btn btn-primary btn-lg">Search Jobs</a>
            <?php endif; ?>
            <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
