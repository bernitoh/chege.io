<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <style>
        /* Your existing CSS styles */

        .enroll-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .enroll-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <header>
        <h1>Student Management System</h1>
    </header>

    <section>
        <div class="course" id="computerScience">
            <h2>Course: Computer Science</h2>
            <table>
                <!-- Unit rows as before -->
            </table>
            <button class="enroll-button" onclick="enroll('Computer Science')">Enroll</button>
        </div>

        <div class="course" id="mathematics">
            <h2>Course: Mathematics</h2>
            <table>
                <!-- Unit rows as before -->
            </table>
            <button class="enroll-button" onclick="enroll('Mathematics')">Enroll</button>
        </div>
    </section>

    <script>
        function enroll(course) {
            // You can add more complex logic here
            // For a simple example, let's use AJAX to send a request to the server
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.open("GET", "enroll.php?course=" + course, true);
            xhr.send();
        }
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <style>
        /* Your existing CSS styles */

        .enroll-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .enroll-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <header>
        <h1>Student Management System</h1>
    </header>

    <section>
        <div class="course" id="computerScience">
            <h2>Course: Computer Science</h2>
            <table>
                <!-- Unit rows as before -->
            </table>
            <button class="enroll-button" onclick="enroll('Computer Science')">Enroll</button>
        </div>

        <div class="course" id="mathematics">
            <h2>Course: Mathematics</h2>
            <table>
                <!-- Unit rows as before -->
            </table>
            <button class="enroll-button" onclick="enroll('Mathematics')">Enroll</button>
        </div>
    </section>

    <script>
        function enroll(course) {
            // You can add more complex logic here
            // For a simple example, let's use AJAX to send a request to the server
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.open("GET", "enroll.php?course=" + course, true);
            xhr.send();
        }
    </script>

</body>

</html>
