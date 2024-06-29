<?php
include 'db.php';
$conn = mysqli_connect('localhost', 'root', '', 'school_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

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
    WHERE
        student.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // "i" denotes the type (integer) of the parameter
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<h1>Data for ID: " . htmlspecialchars($id) . "</h1>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
        echo "<p><strong>Created At:</strong> " . htmlspecialchars($row['created_at']) . "</p>";
        echo "<p><strong>Class Name:</strong> " . htmlspecialchars($row['class_name']) . "</p>";
        echo "<p><strong>Image:</strong> <img src='" . htmlspecialchars($row['image']) . "' alt='Student Image'></p>";
    }
} else {
    echo "<p>No data found for ID: " . htmlspecialchars($id) . "</p>";
}

// Close the connection
$stmt->close();
$conn->close();
?>
</body>
</html>
