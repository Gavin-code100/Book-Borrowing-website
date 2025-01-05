<?php
include('connection.php');
if (isset($_GET['rem'])) {
    // Secure the ID using prepared statements to prevent SQL injection
    $rem = mysqli_real_escape_string($con, $_GET['rem']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book table</title>
    <link rel="stylesheet" type="text/css" href="monday.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
<header>
        <a href="admin".php class="logo"></a>
        <div><h1>Welcome Admin</h1></div>
        <a href="index.html" id="box" style="font-size: 23px">Log Out</a>
</header>
<div class="container">
        <h1 class="inline-element">Corresponding Books:</h1>
        <a href='addbks.php?rem=<?php echo $rem; ?>' class="inline-element" id="addbutton">ADD</a>
</div>
</div>

    <table class="table-custom" id="tableadmin">
    <thead>
        <tr>
            <th>no.</th>
            <th>Book Name</th>
            <th>Modify</th>
            <th>Delete</th>
        </tr>
    </thead>
    
    <?php
        $query = "SELECT * FROM books";
        $result = mysqli_query($con, $query);
        
        // Error handling should come immediately after the query
        if (!$result) {die("Query Failed! " . mysqli_error($con));
        } else {
        // Fetch all results as an associative array
        $karte = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
    <tbody>
    <?php foreach ($karte as $kart): ?>
    <?php if ($kart['fcatid'] == $rem && $kart['bookstatus'] != '-'): ?>
        <tr>
            <td class="largetext"><?php echo htmlspecialchars($kart['bookid']); ?>.</td>
            <td class="largetext"><?php echo htmlspecialchars($kart['bookname']); ?></td>
            <td><a href="modbkform.php?rem=<?php echo htmlspecialchars($kart['bookid']); ?>"><button class="delete" type="#" name="buttn"><i class="fa-solid fa-pencil"></i></button></a></td>
            <td><a href="btolost.php?rem=<?php echo htmlspecialchars($kart['bookid']); ?>"><button class="kill" type="#" name="buttn"><i class="fa-solid fa-trash-can"></i></button></a></td>
        </tr>
    <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
    <?php } 
    mysqli_free_result($result);
    mysqli_close($con);?>
</table>
<br>
    <br>
    <?php include 'footer.php'; ?>
</body>
</html>