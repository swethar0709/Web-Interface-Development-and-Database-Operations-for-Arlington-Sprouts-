<!DOCTYPE html>
<html>
<head>
    <title>Delete Item</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            background-color: #f2f2f2;
            font-family: sans-serif;
        }

        h1 {
            margin: 20px;
            text-align: center;
        }

        form {
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 20px auto;
            max-width: 600px;
            padding: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], input[type="number"] {
            border: 1px solid #ccc;
            border-radius: 3px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            font-size: 18px;
            padding: 10px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            border-radius: 3px;
            color: white;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
            padding: 10px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <h1>Delete Item</h1>
    <form method="POST" action="">
        <label for="item_id">Item Id:</label>
		<input type="number" name="item_id" id="item_id" required>

        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" id="item_name"  required>
        
        <input type="submit" name="submit" value="Delete">
    </form>
</body>
</html>
<?php
$dbhost = 'localhost:4306';
$dbuser = 'root';
$dbpass = '';
$db     = 'db';

$conn  = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete the item when the form is submitted
if (isset($_POST['submit'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];

    $sql = "DELETE FROM item WHERE Iid = ? AND Iname = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("is", $item_id, $item_name);
        if ($stmt->execute()) {
            if (mysqli_affected_rows($conn) > 0) {
                echo "Item deleted successfully!";
            } else {
                echo "Error: No rows were affected by the delete.";
            }
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
