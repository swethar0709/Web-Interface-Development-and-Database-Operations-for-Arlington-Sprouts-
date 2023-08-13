<!DOCTYPE html>
<html>
<head>
    <title>Search Item</title>
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
        table {
            border-collapse: collapse;
            width: 100%;
            color: #588c7e;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
        }
        th {
            background-color: #588c7e;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2
        }
    </style>
</head>
<body>
    <h1>Search Item</h1>
    <form method="POST" action="">
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" id="item_name" required><br><br>
        <input type="submit" value="Submit">
    </form>



<?php
$dbhost = 'localhost:4306';
$dbuser = 'root';
$dbpass = '';
$db     = 'db';

$conn  = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['item_name'])) {
    // Get the item name from the form
    $item_name = $_POST['item_name'];

    // Prepare the SQL query with a parameter placeholder
    $sql = "SELECT Iid, Iname, Sprice FROM item WHERE Iname = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter to the statement
    $stmt->bind_param("s", $item_name);

    // Execute the statement
    $stmt->execute();

    // Get the results of the query
    $result = $stmt->get_result();

    // Check if any results were returned
    if ($result->num_rows > 0) {
        // Output the results in a table
        echo "<table>
                <tr>
                    <th>Iid</th>
                    <th>Iname</th>
                    <th>Sprice</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Iid"] . "</td>
                    <td>" . $row["Iname"] . "</td>
                    <td>" . $row["Sprice"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        // No results found
        echo "0 results";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

</body>
</html>

