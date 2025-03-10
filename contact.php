<?php
session_start(); // Start the session to store messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Invalid email format.";
        header("Location: subindex.html");
        exit;
    }

    // Change this to your actual email
    $to = "rb@reginablye.com";  
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $email_message = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message\n";

    // Send email
    if (mail($to, $subject, $email_message, $headers)) {
        $_SESSION["success"] = "Your message was sent successfully!";
    } else {
        $_SESSION["error"] = "Failed to send your message. Please try again later.";
    }

    // Redirect back to the form page
    header("Location: subindex.html");
    exit;
} else {
    $_SESSION["error"] = "Invalid request.";
    header("Location: subindex.html");
    exit;
}
?>
