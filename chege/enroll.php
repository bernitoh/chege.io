<?php
session_start();

// Your database connection parameters
$servername = "127.0.0.1"; // or "localhost"
$username = "root";
$password = "";
$dbname = "student_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

// Check if the enrollment form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enroll'])) {
    $studentId = $_SESSION['student_id'];
    $courseId = $_POST['course'];
    $unitName = $_POST['unit_name'];
    $grade = $_POST['grade'];

    // Validate and sanitize input as needed

    // Insert the enrollment record into the database
    $sql = "INSERT INTO enrollments (student_id, course_id, unit_name, grade) VALUES ($studentId, $courseId, '$unitName', '$grade')";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php"); // Redirect to the dashboard after successful enrollment
        exit();
    } else {
        $enrollError = "Error enrolling in the course: " . $conn->error;
    }
}

?>

<!-- Your HTML code for enroll.php goes here -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Form</title>
    <!-- Add your CSS styles if needed -->
</head>

<body>

    <header>
        <h1>Enrollment Form</h1>
    </header>

    <section>
        <form method="post" action="enroll.php">
            <label for="course">Select a course:</label>
            <select id="course" name="course" required>
                <!-- Populate the dropdown with course options dynamically from your database -->
                <option value="1">Course 1</option>
                <option value="2">Course 2</option>
                <!-- Add more options as needed -->
            </select>
            <br>
            <label for="unit_name">Enter unit name:</label>
            <input type="text" id="unit_name" name="unit_name" required>
            <br>
            <label for="grade">Enter grade:</label>
            <input type="text" id="grade" name="grade" required>
            <br>
            <button type="submit" name="enroll">Enroll</button>
        </form>
    </section>

</body>

</html>
