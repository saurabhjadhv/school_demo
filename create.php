<?php
include "db.php";
$conn = mysqli_connect('localhost', 'root', '', 'school_db');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and file upload
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];

    // Validate image type
    if ($image['type'] == "image/jpeg" || $image['type'] == "image/png") {
        $image_path = 'upload/' . basename($image['name']);
        if (!move_uploaded_file($image['tmp_name'], $image_path)) {
            echo "Failed to upload image.";
            exit;
        }
    } else {
        echo "Invalid image format. Only JPG and PNG are allowed.";
        exit;
    }

    // Use prepared statement to insert data
    $stmt = $conn->prepare("INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)");
    
    
    if ($stmt->execute([$name, $email, $address, $class_id, $image_path])) {
        // Redirect to home page
        header("Location: index.php");
        exit;
    } else {
        echo "Failed to insert student data.";
    }
}

// Fetch classes for the dropdown
$classes = " SELECT * FROM classes ";
$result = $conn->query($classes);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Student</title>
    <style>
        /* Include your CSS styling here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        form input[type="text"],
        form input[type="email"],
        form textarea,
        form select,
        form input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form textarea {
            resize: vertical;
        }
        form button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form button[type="submit"]:hover {
            background-color: #45a049;
        }
        form input[type="file"] {
            padding: 3px;
        }
        form select option {
            padding: 8px;
        }
        form h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Create Student</h1>
    <form action="#" method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Address:</label>
        <textarea name="address" required></textarea><br>
        <label>Class:</label>
        <select name="class_id" required>
            <?php
            foreach ($result as $r) {
                ?>
                <option value=<?php echo $r['class_id']; ?>><?php echo $r['name']; ?></option>" ;
            <?php } ?>
        </select><br>
        <label>Image:</label>
        <input type="file" name="image" accept="image/jpeg, image/png" required><br>
        <button type="submit">Create</button>
    </form>
    </div>
</body>
</html>
