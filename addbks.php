<?php
include('connection.php');

if(isset($_GET['rem']) && isset($_POST['submit'])){
    $rem = mysqli_real_escape_string($con, $_GET['rem']);
    $bkname = mysqli_real_escape_string($con, $_POST['bkname']);
    $bkintro = mysqli_real_escape_string($con, $_POST['bkintro']);

    // Handling the file upload
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){ // Check file size limit (1MB)
                $fileNameNew = uniqid('', true) . "." . $fileActualExt; // Remove the misplaced comma
                $fileDestination = 'books/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                // SQL query to insert the book data
                $query = "INSERT INTO books (fcatid, bookname, bookintro, bookpic, bookstatus) 
                          VALUES ('$rem', '$bkname', '$bkintro', '$fileDestination', 'a')";
                $result = mysqli_query($con, $query);

                if(!$result){
                    die("Query Failed: " . mysqli_error($con)); // Correct the mysqli_error usage
                } else {
                    header("Location: adminbks.php?rem=" . $rem);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel = "stylesheet" type = "text/css" href = "monday.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>  
<div id = "bkform">
    <div class="bktop">
    <h1>Add Book:</h1>  
    <a href="adminbks.php?rem=<?php $rem ?>" id="cancel" style="font-size: 23px">Cancel</a>
    </div>

        <form method="post" name="f1" onsubmit = "" enctype="multipart/form-data">  
            <p>  
                <label>Book Name:</label><br> 
                <input type = "text" id ="bkname" name  = "bkname" placeholder="Enter Name"/>  
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
    <br>
    <br>
    <?php include 'footer.php'; ?>
</body>
</html>