<?php
include "db.php";
$conn = mysqli_connect('localhost', 'root', '', 'school_db');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch students with their class names using a JOIN query
$sql = "
    SELECT 
        student.id, 
        student.name, 
        student.email, 
        student.created_at, 
        student.image, 
        classes.name AS class_name 
    FROM 
        student 
    LEFT JOIN 
        classes 
    ON 
        student.class_id = classes.class_id
";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .actions {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student List</h1>
        <button type="button"><a href="create.php">go to form</a></button>
        <table>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Class</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['class_name']) . "</td>";
                    echo "<td><img src='" . htmlspecialchars($row['image']) . "' alt='Student Image'></td>";
                    echo "<td class='actions'>
                            <a href='view.php?id=" . $row['id'] . "'>View</a> |
                            <a href='edit.php?id=" . $row['id'] . "'>Edit</a> |
                            <a href='delete.php?id=" . $row['id'] . "'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No students found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
