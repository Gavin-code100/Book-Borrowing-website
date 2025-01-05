<?php
include('connection.php');

// Query for all books
$sql = "SELECT bookid, fcatid, bookname, bookintro, bookpic, bookstatus FROM books";
$result = mysqli_query($con, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result); // Free result for books

// Initialize $var variable
$var = [];

// Check if 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    // Secure the ID using prepared statements to prevent SQL injection
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $sql1 = "SELECT * FROM books WHERE bookid = ?";
    $stmt = mysqli_prepare($con, $sql1);
    mysqli_stmt_bind_param($stmt, 's', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $var = mysqli_fetch_assoc($result);
    mysqli_free_result($result); // Free result for page
    mysqli_stmt_close($stmt); // Close the statement after use
}

mysqli_close($con); // Close the connection
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($var['bookname'] ?? 'No Book Selected'); ?></title>
    <link rel="stylesheet" type="text/css" href="monday.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
    <header>
        <a href="welcome.php" class="logo"></a>
        <h1><?php echo htmlspecialchars($var['bookname'] ?? 'No Book Selected'); ?></h1>
        <a href="cart.php" id="box" style="font-size: 25px">Cart</a>
    </header>
    <!-- Display book details -->
    <?php if (!empty($var)) : ?>
        <?php foreach ($books as $book): ?>
            <?php if ($book['bookid'] == $var['bookid'] && $book['bookstatus'] != '-'): ?>
                <div class="grid">
                    <div class="bookpic" style="background-image: url('<?php echo htmlspecialchars($book['bookpic'], ENT_QUOTES, 'UTF-8'); ?>');"></div>
                    <div class="abtbk">
                        <h1><?php echo htmlspecialchars($book['bookname'], ENT_QUOTES, 'UTF-8'); ?></h1>
                        <h3>About Book</h3>
                        <p class="para"><?php echo htmlspecialchars($book['bookintro'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <!-- Corrected "Add to Cart" button with correct variable -->
                        <?php if (isset($var['bookid'])): ?>
                        <a href="atoc.php?id=<?php echo htmlspecialchars($var['bookid']); ?>"><button type="button" name="buttn" class="atoc">
                        <?php if ($var['bookstatus'] == 'a') {echo "Add To Cart";
                        } else {echo "Done";} ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No book found or selected.</p>
    <?php endif; ?>

    <br/><br/><br/>

    <!-- Display book availability status -->
    <?php if (!empty($var)): ?>
        <div class="status" id="<?php echo ($var['bookstatus'] != 'b' && $var['bookstatus'] != '-') ? 'available' : 'unavailable'; ?>">
            <?php echo ($var['bookstatus'] != 'b' && $var['bookstatus'] != '-') ? "Available" : "Unavailable"; ?>
        </div>
    <?php endif; ?>

    <br/>
    <?php include('footer.php'); ?>
</body>
</html>
