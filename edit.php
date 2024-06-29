<?php

$conn = mysqli_connect('localhost', 'root', '', 'school_db');
$sql = "
    SELECT 
        student.id, 
        student.name, 
        student.email,
        student.address,
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
    <h1>Update Student</h1>
    <?php  while ($row = $result->fetch_assoc()) { ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value=<?php echo $row['name']; ?> required><br>
        <label>Email:</label>
        <input type="email" name="email"  value=<?php echo $row['email'];  ?> required><br>
        <label>Address:</label>
        <textarea name="address" value=<?php echo $row['address']; ?> required></textarea><br>
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
        <?php  } ?>
        <button type="submit">Create</button>
    </form>
    </div>
</body>
</html>
