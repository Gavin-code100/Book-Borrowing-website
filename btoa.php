<?php
include('connection.php'); // Make sure $con is your connection variable

if (isset($_GET['rem'])) {
    // Sanitize the input to prevent SQL injection
    $rem = mysqli_real_escape_string($con, $_GET['rem']);

    // Prepare the SQL UPDATE query to change the bookstatus to 'a'
    $query = "UPDATE books SET bookstatus = 'a' WHERE bookid = ?";
    
    // Initialize a statement
    $stmt = mysqli_prepare($con, $query);
    
    // Bind the parameter to the SQL query
    mysqli_stmt_bind_param($stmt, 's', $rem);
    
    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        header('Location: Returnbks.php');
        exit();
    } else {
        die("Query failed: " . mysqli_error($con));
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "No 'rem' parameter provided.";
}

// Close the connection
mysqli_close($con);
?>