<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "add your database name";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert Data
if (isset($_POST['add'])) {
    $batchid = $_POST['batchid'];
    $batchno = $_POST['batchno'];
    $mfgdate = $_POST['mfgdate'];
    $expdate = $_POST['expdate'];
    $itemname = $_POST['itemname'];

    $sql = "INSERT INTO batchsetup (batchid, batchno, mfgdate, expdate, itemname) 
            VALUES ('$batchid', '$batchno', '$mfgdate', '$expdate', '$itemname')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Batch added successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete Data
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM batchsetup WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Batch deleted successfully!');</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Update Data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $batchid = $_POST['batchid'];
    $batchno = $_POST['batchno'];
    $mfgdate = $_POST['mfgdate'];
    $expdate = $_POST['expdate'];
    $itemname = $_POST['itemname'];

    $sql = "UPDATE batchsetup SET batchid='$batchid', batchno='$batchno', mfgdate='$mfgdate', expdate='$expdate', itemname='$itemname' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Batch updated successfully!');</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Batch Number Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-container {
            background: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button.delete {
            background: red;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Batch Number Setup</h2>
        <form method="POST" id="BatchForm">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label>Batch ID:</label>
                <input type="text" name="batchid" id="batchid" required>
            </div>
            <div class="form-group">
                <label>Batch No:</label>
                <input type="text" name="batchno" id="batchno" required>
            </div>
            <div class="form-group">
                <label>MFG Date:</label>
                <input type="date" name="mfgdate" id="mfgdate" required>
            </div>
            <div class="form-group">
                <label>EXP Date:</label>
                <input type="date" name="expdate" id="expdate" required>
            </div>
            <div class="form-group">
                <label>Item Name:</label>
                <input type="text" name="itemname" id="itemname" required>
            </div>
            <button type="submit" name="add">Add</button>
            <button type="submit" name="update">Re-Edits</button>
        </form>
    </div>

    <h3>Batch Setup Details</h3>
    <table>
        <tr>
            <th>Batch ID</th>
            <th>Batch NO</th>
            <th>MFG Date</th>
            <th>EXP Date</th>
            <th>Item Name</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM batchsetup");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["batchid"]."</td>
                        <td>".$row["batchno"]."</td>
                        <td>".$row["mfgdate"]."</td>
                        <td>".$row["expdate"]."</td>
                        <td>".$row["itemname"]."</td>
                        <td>
                            <button onclick='batchedit(".$row["id"].", \"".$row["batchid"]."\", \"".$row["batchno"]."\", \"".$row["mfgdate"]."\", \"".$row["expdate"]."\", \"".$row["itemname"]."\")'>Edit</button>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='".$row["id"]."'>
                                <button type='submit' name='delete' class='delete'>Delete</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No Batch ID found</td></tr>";
        }
        ?>
    </table>

    <script>
        function batchedit(id, batchid, batchno, mfgdate, expdate, itemname) {
            document.getElementById('id').value = id;
            document.getElementById('batchid').value = batchid;
            document.getElementById('batchno').value = batchno;
            document.getElementById('mfgdate').value = mfgdate;
            document.getElementById('expdate').value = expdate;
            document.getElementById('itemname').value = itemname;
        }
    </script>
</body>
</html>
