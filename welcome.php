<?php
include('connection.php');
//write quey for all categories
$sql = "SELECT catid, catname, catstatus FROM category";
// make query and get results
$result = mysqli_query($con, $sql);
//fetch the resulting rows as an array
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
// free result from memory
mysqli_free_result($result);
mysqli_close($con);
//print_r($categories);
?> 
<?php
include('connection.php');
//write quey for all categories
$sql = "SELECT bookid, bookpic, bookstatus FROM books";
// make query and get results
$result = mysqli_query($con, $sql);
//fetch the resulting rows as an array
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);
// free result from memory
mysqli_free_result($result);
mysqli_close($con);
//print_r($categories);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrowing</title>
    <link rel="stylesheet" type="text/css" href="monday.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
    <header>
        <a class="logo"></a>
        <a href="index.html" id="box" style="font-size: 23px">Log Out</a>
        <a href="Returnbks.php" id="box" style="font-size: 25px">Return</a>
        <a href="cart.php" id="cart1" style="font-size: 25px"><i class="fa-solid fa-cart-shopping"></i></a>
    </header>
    <br/>
    <h1>Categories:</h1>
    <div class="bigcat">
        <div class="spacecat">
        </div>
        <div class="categories">
    <!-- categoeries from table -->
        <?php foreach($categories as $category): ?>

        <?php
        if ($category['catstatus'] != '-'):
            echo '<a id="box" href="category.php?id=' . $category['catid'] . '" class="options">';
            echo htmlspecialchars($category['catname']);
            echo '</a>';
        endif;
        ?>
<?php endforeach; ?>

    </div>
    </div>
        <h1>Currently Borrowing:</h1>
    <div class="catbooks">    
    <?php foreach($books as $book): ?>
    <?php 
    if ($book['bookstatus'] == 'b'):
        // echo '<a href="bookpg.php?id='. htmlspecialchars($book['bookid'], ENT_QUOTES, 'UTF-8') .' class="bookopt" style="background-image: url('. htmlspecialchars($book['bookpic'], ENT_QUOTES, 'UTF-8') .');"></a>';
        echo '<a href="bookpg.php?id=' . htmlspecialchars($book['bookid'], ENT_QUOTES, 'UTF-8') . '">
        <div class="bookopt" style="background-image: url(' . htmlspecialchars($book['bookpic'], ENT_QUOTES, 'UTF-8') . ');"></div></a>';

    endif;
    endforeach;
    ?>
    </div>
    <br/>
    <br/>
    <link rel="import" href="footer.html"> 
    <br>
    <br>
    <?php include 'footer.php'; ?>
</body>
</html>
