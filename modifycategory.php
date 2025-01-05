<?php
include('connection.php');
if (isset($_GET['deletecat'])) {
    if (isset($_GET['rem'])) {
        $rem = mysqli_real_escape_string($con, $_GET['rem']); // Escape input
        
        // SQL query to fetch category
        $query = "SELECT * FROM category WHERE catid = '$rem'";
        $result = mysqli_query($con, $query); // Execute query
        
        // Check if query execution was successful
        if (!$result) {
            die("Query Failed! " . mysqli_error($con)); // Include $con in mysqli_error()
        } else {            
            $rem = mysqli_real_escape_string($con, $_GET['rem']);
            $query = "DELETE FROM books WHERE fcatid = '$rem'";
            $result = mysqli_query($con, $query);
            if (!$result) {
                die("Query failed: " . mysqli_error($con)); // Added $con parameter
            } else{
                $query = "DELETE FROM category WHERE catid = '$rem'";
            $result = mysqli_query($con, $query);
            if (!$result) {
                die("Query failed: " . mysqli_error($con)); // Added $con parameter
            } else {
                header('Location: admin.php?message=Category%20updated'); 
            }
            
            // Close the database connection after
            mysqli_close($con);
            exit();
            }
        }
    }
}


elseif(isset($_GET['newcatname'])){
    $newcategory = mysqli_real_escape_string($con, $_GET['newcatname']);
    if($newcategory == "" || empty($newcategory)){
        header('location:admin.php?Message=Name Not Entered');
        exit(); // Ensure the script stops executing after the redirect
    }
}
$query = "select  catid, catname from category where catid = '$rem'";
$result = mysqli_query($con, $query);
        
        // Error handling should come immediately after the query
        if (!$result) {die("Query Failed! " . mysqli_error($con));
        } else {
            $row = mysqli_fetch_assoc($result);
        }
        if (isset($_GET['rem'])) {
            $rem = mysqli_real_escape_string($con, $_GET['rem']);
            $query = "UPDATE category SET catname = '$newcategory' WHERE catid = '$rem'";
            $result = mysqli_query($con, $query);
            if (!$result) {
                die("Query failed: " . mysqli_error($con)); // Added $con parameter and closing parenthesis
            } else {
                header('Location: admin.php?message=Category%20updated'); // Corrected URL and added semicolon
            }
        }
        mysqli_free_result($result);
        mysqli_close($con);
?>