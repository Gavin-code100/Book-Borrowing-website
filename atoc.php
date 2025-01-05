<?php
include('connection.php'); // Make sure $con is your connection variable

if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $rem = mysqli_real_escape_string($con, $_GET['id']);

    // Prepare the SQL UPDATE query to change the bookstatus to 'c'
    $query = "UPDATE books SET bookstatus = 'c' WHERE bookid = ?";
    
    // Initialize a statement
    $stmt = mysqli_prepare($con, $query);
    
    // Bind the parameter to the SQL query
    mysqli_stmt_bind_param($stmt, 's', $rem);
    
    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        header('Location: bookpg.php?id=' . $rem);
        exit();
    } else {
        die("Query failed: " . mysqli_error($con));
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "No 'id' parameter provided.";
}

// Close the connection
mysqli_close($con);
?>
