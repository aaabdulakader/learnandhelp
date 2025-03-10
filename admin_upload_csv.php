<?php
// session
session_start();
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Database connection
  include 'db_configuration.php';
$conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

    // Checks connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Checks if a file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file']['tmp_name'];

        // Reads the uploaded file
        $handle = fopen($file, "r");

        // Skips the header row
        fgetcsv($handle);
        // skip first line
        while (($data = fgetcsv($handle, 1000, ",")) !== false && $data[0] != "id") {
            // Replaces empty strings with NULL
            foreach ($data as $key => $value) {
                if ($value === '') {
                    $data[$key] = 'NULL';
                } else {
                    $data[$key] = "'" . $conn->real_escape_string($value) . "'";
                }
            }

            // Generate the query using the values from the CSV
            $sql = "INSERT INTO schools (id, name, type, category, grade_level_start, grade_level_end, current_enrollment, address_text, state_name, state_code, pin_code, contact_name, contact_designation, contact_phone, contact_email, status, notes, referenced_by, supported_by) 
                    VALUES ($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $data[11], $data[12], $data[13], $data[14], $data[15], $data[16], $data[17], $data[18]) 
                    ON DUPLICATE KEY UPDATE 
                    name = VALUES(name), type = VALUES(type), category = VALUES(category), grade_level_start = VALUES(grade_level_start), grade_level_end = VALUES(grade_level_end), current_enrollment = VALUES(current_enrollment), 
                    address_text = VALUES(address_text), state_name = VALUES(state_name), state_code = VALUES(state_code), pin_code = VALUES(pin_code), contact_name = VALUES(contact_name), 
                    contact_designation = VALUES(contact_designation), contact_phone = VALUES(contact_phone), contact_email = VALUES(contact_email), status = VALUES(status), 
                    notes = VALUES(notes), referenced_by = VALUES(referenced_by), supported_by = VALUES(supported_by)";

            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        fclose($handle);

        // alert the user that the CSV file was uploaded successfully
        echo "<script type='text/javascript'>alert('CSV file uploaded successfully!');</script>";
    } else {
        echo "Error uploading file.";
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload CSV</title>
    <link style="text/css" rel="stylesheet" href="css/main.css">
</head>

<style>
       body {
            font-family: Arial, sans-serif;
            height: 100vh;
        }

        h2 {
            margin-bottom: 20px;
        }

        .form {
            margin-bottom: 20px;
            width: 30%;
        }

        input[type="file"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            padding: 5px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

    

       .container{
        width: 100%;
        height: 80%;
        display: flex;
        justify-content: center;
        align-items: center;
       }
</style>

<body>
    <!-- include navbar -->
    <?php include 'show-navbar.php';
    show_navbar();
    ?>
    <div class="container">
    <form class="form" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" name="submit" value="Upload">
    </form>
    </div>
</body>

</html>
