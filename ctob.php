<?php
include('connection.php'); // Make sure $con is your connection variable

// Prepare the SQL UPDATE query to change the bookstatus to 'b' where bookstatus is 'c'
$query = "UPDATE books SET bookstatus = 'b' WHERE bookstatus = 'c'";

// Initialize a statement
$stmt = mysqli_prepare($con, $query);

if (!$stmt) {
    die("Statement preparation failed: " . mysqli_error($con));
}

// Execute the query
if (mysqli_stmt_execute($stmt)) {
    header('Location: welcome.php');
    mysqli_close($con);
    exit();
} else {
    die("Query failed: " . mysqli_error($con));
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the connection
mysqli_close($con);
?>
