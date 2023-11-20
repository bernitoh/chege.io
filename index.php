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

// Function to authenticate a student
function authenticateStudent($registrationNumber, $password) {
    global $conn;
    $sql = "SELECT * FROM students WHERE registration_number = '$registrationNumber' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['student_id'] = $row['student_id'];
        return true;
    } else {
        return false;
    }
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $registrationNumber = $_POST['registration_number'];
    $password = $_POST['password'];

    // Validate and sanitize input as needed

    // Authenticate the student
    if (authenticateStudent($registrationNumber, $password)) {
        header("Location: dashboard.php"); // Redirect to the dashboard after successful login
        exit();
    } else {
        $loginError = "Invalid registration number or password";
    }
}

// Check if the registration form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $registrationNumber = $_POST['registration_number'];
    $password = $_POST['password'];
    $studentName = $_POST['student_name'];

    // Validate and sanitize input as needed

    // Check if the registration number is unique
    $checkDuplicateQuery = "SELECT * FROM students WHERE registration_number = '$registrationNumber'";
    $result = $conn->query($checkDuplicateQuery);

    if ($result->num_rows > 0) {
        $registrationError = "Registration number is already in use";
    } else {
        // Insert the new student record into the database
        $insertQuery = "INSERT INTO students (registration_number, password, student_name) VALUES ('$registrationNumber', '$password', '$studentName')";
        if ($conn->query($insertQuery) === TRUE) {
            // Authenticate the student after successful registration
            authenticateStudent($registrationNumber, $password);
            header("Location: dashboard.php");
            exit();
        } else {
            $registrationError = "Error registering the student: " . $conn->error;
        }
    }
}

// Check if the student is already logged in
if (isset($_SESSION['student_id'])) {
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollment System</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url("img 9.jpg");
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        header {
            display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: #354753;
    color: #fff;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000; 
        }

        section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            margin: 0 20px; /* Adjusted margin for spacing */
            text-align: center;
            box-sizing: border-box;
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        p.error-message {
            color: red;
            margin-top: 10px;
        }
        a {
            display: inline-block;
            color: #3498db;
            text-decoration: none;
            padding: 10px 20px;
            margin: 10px;
            border: 2px solid #3498db;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        a:hover {
            background-color: #3498db;
            color: #fff;
        }
    </style>
</head>

<body>

    <header>
        <h1>Student Enrollment System</h1> &nbsp;<a href="tunaanza.html">HOME</a>&nbsp;&nbsp;&nbsp;&nbsp;
    </header>

    <section>
    <h2>Register</h2>
<?php if (isset($registrationError)) echo "<p class='error-message'>$registrationError</p>"; ?>
<form method="post" action="" class="registration-form">
    <label for="registration_number">Registration Number (Format: b012/12345/1234):</label>
    <input type="text" id="registration_number" name="registration_number" pattern="^[bB]\d{3}/\d{5}/\d{4}$" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <label for="student_name">Student Name:</label>
    <input type="text" id="student_name" name="student_name" required>
    <button type="submit" name="register">Register</button>
</form>

    </section>

    <section>
        <h2>Login</h2>
        <?php if (isset($loginError)) echo "<p class='error-message'>$loginError</p>"; ?>
        <form method="post" action="">
            <label for="login_registration_number">Registration Number:</label>
            <input type="text" id="login_registration_number" name="registration_number" required>
            <br>
            <label for="login_password">Password:</label>
            <input type="password" id="login_password" name="password" required>
            <br>
            <button type="submit" name="login">Login</button>
        </form>
    </section>

</body>

</html>
