<?php
session_start();
include 'config.php';
include 'email_config.php';

// Ensure only employers can update application status
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header('Location: login.php');
    exit;
}

if (isset($_POST['application_id']) && isset($_POST['status'])) {
    $application_id = $_POST['application_id'];
    $status = $_POST['status'];

    // Update application status
    $query = "UPDATE applications SET status = '$status' WHERE id = $application_id";
    if ($conn->query($query) === TRUE) {
        // Fetch candidate email
        $app_query = "SELECT email, candidate_name FROM applications WHERE id = $application_id";
        $app_result = $conn->query($app_query);
        if ($app_result->num_rows > 0) {
            $application = $app_result->fetch_assoc();
            $candidate_email = $application['email'];
            $candidate_name = $application['candidate_name'];

            // Send email notification
            $subject = "Application Status Update";
            $body = "
                <p>Dear $candidate_name,</p>
                <p>The status of your application has been updated to: <strong>$status</strong>.</p>
                <p>Thank you for applying!</p>
                <p>Regards,</p>
                <p>Job Board System</p>
            ";
            sendEmail($candidate_email, $subject, $body);
        }

        header('Location: view_applications.php');
    } else {
        echo "Error updating status: " . $conn->error;
    }
}
?>
