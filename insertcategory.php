<?php
include 'connection.php'; 

if(isset($_POST['addcat'])){
    $newcatname = $_POST['newcatname'];

    // Check if the category name is empty
    if($newcatname == "" || empty($newcatname)){
        header('location:admin.php?Message=Name Not Entered');
        exit(); // Ensure the script stops executing after the redirect
    } else {
        // Prepare the SQL query
        $query = "INSERT INTO category (catname, catstatus) VALUES ('$newcatname', 'a')";
        
        // Execute the query (make sure $con is passed as the first parameter)
        $result = mysqli_query($con, $query);

        // Check if the query execution failed
        if(!$result){
            die("Query Failed: " . mysqli_error($con)); // Pass $con into mysqli_error for better error handling
        } else {
            header('location:admin.php?success=!!');
            exit(); // Stop script execution after redirect
        }
    }
}
?>
