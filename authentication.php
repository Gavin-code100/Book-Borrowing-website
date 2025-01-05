<?php      
    include('connection.php');  
    $username = $_POST['user'];  
    $password = $_POST['pass']; 
    
    // Stripslashes and escape special characters for security
    $username = stripcslashes($username);  
    $password = stripcslashes($password);  
    $username = mysqli_real_escape_string($con, $username);  
    $password = mysqli_real_escape_string($con, $password);  

    // SQL query to check if the user exists with the provided username and password
    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";  
    $result = mysqli_query($con, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);  
          
    if ($count == 1 && $username != 'admin') {  
        // Redirect to welcome.php if login is successful
        header("Location: welcome.php");
        exit(); // Ensure no further code is executed after redirection
    } elseif ($count == 1) {  
        header("Location: admin.php");
        exit(); 
    } else {
        echo "<h1>Login failed. Invalid username or password.</h1>";
    }  
?>
