<?php
include('connection.php');

// Query for all books
$sql = "SELECT bookid, fcatid, bookpic, bookstatus FROM books";
$result = mysqli_query($con, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result); // Free result for books

// Initialize $page variable
$page = [];

if (isset($_GET['id'])) {
    // Secure the ID using prepared statements to prevent SQL injection
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $sql1 = "SELECT * FROM category WHERE catid = ?";
    $stmt = mysqli_prepare($con, $sql1);
    mysqli_stmt_bind_param($stmt, 's', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $page = mysqli_fetch_assoc($result);
    mysqli_free_result($result); // Free result for page
}

mysqli_close($con); // Close the connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['catname'] ?? 'Default Title'); ?></title>
    <link rel="stylesheet" type="text/css" href="monday.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
    <header>
        <a href="welcome.php" class="logo"></a>
        <div class="carthd"><?php echo htmlspecialchars($page['catname']); ?></div>
        <a href="cart.php" id="cart1" style="font-size: 25px"><i class="fa-solid fa-cart-shopping"></i></a>
    </header>

    <h1><?php echo htmlspecialchars($page['catname']); ?> category books:</h1> 

    <div class="bigcat">
        <div id="bookspace"></div>
        <div class="catbooks">
            <!-- Display books from the table -->
            <?php foreach ($books as $book): ?>
                <?php if ($book['fcatid'] == $page['catid'] && $book['bookstatus'] != '-'): ?>
                    <a class="bookopt" style="background-image: url('<?php echo htmlspecialchars($book['bookpic'], ENT_QUOTES, 'UTF-8'); ?>');" href="bookpg.php?id=<?php echo htmlspecialchars($book['bookid']); ?>"></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>  
    </div>
    <br>
    <br>
    <?php include 'footer.php'; ?>
</body>
</html>
