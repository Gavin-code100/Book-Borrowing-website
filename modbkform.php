<?php
include('connection.php');

if (isset($_GET['rem']) && isset($_POST['submit'])) {
    $rem = mysqli_real_escape_string($con, $_GET['rem']);
    $query = "SELECT * FROM books WHERE bookid = '$rem'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query Failed! " . mysqli_error($con)); // Include $con in mysqli_error()
    } else {
        $row = mysqli_fetch_assoc($result);

        // Check if the file was uploaded successfully
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];

            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png');

            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 1000000) { // Check file size limit (1MB)
                        $fileNameNew = uniqid('', true) . "." . $fileActualExt; // Remove the misplaced comma
                        $fileDestination = 'books/' . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);

                        // Validate bkname and bkintro
                        $bkname = mysqli_real_escape_string($con, $_POST['bkname']);
                        $bkintro = mysqli_real_escape_string($con, $_POST['bkintro']);

                        // SQL query to modify the book data
                        $query = "UPDATE books 
                                  SET bookname = '$bkname', 
                                      bookintro = '$bkintro', 
                                      bookpic = '$fileDestination', 
                                      bookstatus = 'a' 
                                  WHERE bookid = '$rem'";

                        $result = mysqli_query($con, $query);

                        if (!$result) {
                            die("Query Failed! " . mysqli_error($con)); // Include $con in mysqli_error()
                        } else {
                            mysqli_close($con);
                            header("Location: adminbks.php?rem=" . $row['fcatid']);
                            exit();
                        }
                    } else {
                        echo "File too big. (img < 1MB)";
                    }
                } else {
                    echo "There was an error uploading the file.";
                }
            } else {
                echo "File type not allowed!";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel = "stylesheet" type = "text/css" href = "monday.css">
</head>
<body>  
<div id = "bkform">
    <div class="bktop">
    <h1>Book:</h1>  
    <a href="admin.php" id="cancel" style="font-size: 23px">Cancel</a>
    </div>

        <form method="post" name="f1" onsubmit = "" enctype="multipart/form-data">  
            <p>  
                <label>Book Name:</label><br> 
                <input type = "text" id ="bkname" name  = "bkname" placeholder="Enter Name"  />  
            </p>  
            <p>  
                <label>Book Image:</label>  <br>
                <input type="file" name="file">
                <!-- <input type = "text" id ="Bookimg" name  = "bookimg" />   -->
            </p>
            <p>  
                <label>Book Introduction:</label>  <br>
                <textarea class="large-textarea" name  = "bkintro" placeholder="Enter Introduction"></textarea> 
            </p>  
            <p> 
                <input type ="submit" id="btn" name="submit" value="Submit" />  
            </p>  
        </form>  
    </div>
</body>
</html>