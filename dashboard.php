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

// Retrieve student information
$studentId = $_SESSION['student_id'];
$sqlStudent = "SELECT * FROM students WHERE student_id = $studentId";
$resultStudent = $conn->query($sqlStudent);

// Check if the query was successful
if (!$resultStudent) {
    echo "Error: " . $sqlStudent . "<br>" . $conn->error;
    // Handle the error (log it, display an error page, etc.)
    exit();
}

$student = $resultStudent->fetch_assoc();

// Retrieve enrolled courses
$sqlEnrolledCourses = "SELECT courses.course_name, units.unit_name, years_of_study.year_number
                      FROM enrollments
                      JOIN courses ON enrollments.course_id = courses.course_id
                      JOIN units ON courses.course_id = units.course_id
                      JOIN years_of_study ON units.year_id = years_of_study.year_id
                      WHERE enrollments.student_id = $studentId";
$resultEnrolledCourses = $conn->query($sqlEnrolledCourses);

// Check if the query was successful
if (!$resultEnrolledCourses) {
    echo "Error: " . $sqlEnrolledCourses . "<br>" . $conn->error;
    // Handle the error (log it, display an error page, etc.)
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        select, button {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .logout {
            text-align: right;
            margin-top: 20px;
        }

        .logout a {
            color: #3498db;
            text-decoration: none;
        }

        .logout a:hover {
            text-decoration: underline;
        }
        .home a {
            color: white;
            text-decoration: none;
        }
        .home a:hover{
            text-decoration:none;
        }
    </style>
    
</head>

<body>

    <header>
        <h1>Welcome, <?php echo $student['student_name']; ?>!</h1>
        <div class="home">
            <h2><a href="tunaanza.html">HOME</a></h2>
            <p></p>
        </div>
    </header>

    <section>
        <h2>Enrolled Courses</h2>
        <?php if ($resultEnrolledCourses->num_rows > 0) : ?>
            <table>
                <tr>
                    <th>Course Name</th>
                    <th>Unit Name</th>
                    <th>Year of Study</th>
                </tr>
                <?php while ($row = $resultEnrolledCourses->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['course_name']; ?></td>
                        <td><?php echo $row['unit_name']; ?></td>
                        <td><?php echo $row['year_number']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else : ?>
            <p>No enrolled courses</p>
        <?php endif; ?>
    </section>

    <section>
        <h2>Enroll in a Course</h2>
        <form method="post" action="enroll.php">
            <label for="course">Select a course:</label>
            <select id="course" name="course" required>
                <option value="" disabled selected>Select a course</option>
                <?php
                $resultAvailableCourses = $conn->query("SELECT * FROM courses");
                while ($row = $resultAvailableCourses->fetch_assoc()) :
                ?>
                    <option value="<?php echo $row['course_id']; ?>"><?php echo $row['course_name']; ?></option>
                <?php endwhile; ?>
            </select>
            <br>
            <label for="unit">Select a unit:</label>
            <select id="unit" name="unit" required>
                <option value="" disabled selected>Select a unit</option>
                <?php
                $resultUnits = $conn->query("SELECT * FROM units");
                while ($row = $resultUnits->fetch_assoc()) :
                ?>
                    <option value="<?php echo $row['unit_id']; ?>"><?php echo $row['unit_name']; ?></option>
                <?php endwhile; ?>
            </select>
            <br>
            <label for="year">Select a year of study:</label>
            <select id="year" name="year" required>
                <option value="" disabled selected>Select a year</option>
                <?php
                $resultYearsOfStudy = $conn->query("SELECT * FROM years_of_study");
                while ($row = $resultYearsOfStudy->fetch_assoc()) :
                ?>
                    <option value="<?php echo $row['year_id']; ?>"><?php echo $row['year_number']; ?></option>
                <?php endwhile; ?>
            </select>
            <br>
            <button type="submit" name="enroll">Enroll</button>
        </form>
    </section>

    <section>
        <!-- Logout and Login with Another Account in the top right -->
        <div class="logout">
            <h2><a href="logout.php">logout</a></h2>
            <p></p>
        </div>
    </section>

</body>

</html>
