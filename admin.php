<?php
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="monday.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
    <header>
        <div class="logo"></div>
        <div><h1>Welcome Admin</h1></div>
        <a href="index.html" id="box" style="font-size: 23px">Log Out</a>
    </header>
    <div class="adminbody">
        <a href="lostbks.php" id="crud1">Deleted Books</a>
    </div>
    <div class="container">
        <h1 class="inline-element">Categories:</h1>
        <div class="inline-element">
            <form action="insertcategory.php" method="post" class="inline-element">
                <input type="text" id="inputsize" name="newcatname" placeholder="Add New Category:">
                <input type="submit" id="addbutton" name="addcat" value="ADD">
            </form>
        </div>
    </div>

    <table class="table-admin" id="tableadmin">
    <thead>
        <tr>
            <th>no.</th>
            <th>Category Name</th>
            <th>Modify</th>
            <th>Delete</th>
            <th>Books</th>
        </tr>
    </thead>
    
    <?php
        $query = "SELECT catid, catname, catstatus FROM category";
        $result = mysqli_query($con, $query);
        
        // Error handling should come immediately after the query
        if (!$result) {die("Query Failed! " . mysqli_error($con));
        } else {
        // Fetch all results as an associative array
        $karte = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
    ?>
    <tbody><?php $number = 1 ?>
    <?php foreach ($karte as $kart): ?>
    <?php if ($kart['catstatus'] == 'a'): ?>
        <tr>
            <td class="largetext"><?php echo $number; ?>.</td><?php $number++ ?>
            <td class="largetext"><?php echo htmlspecialchars($kart['catname']); ?></td>
            <td>
                <form action="modifycategory.php" method="get">
                    <input type="text" id="inputsize" class="tblinput" placeholder="Enter New Name" name="newcatname">
                    <input type="hidden" name="rem" value="<?php echo htmlspecialchars($kart['catid']); ?>">
                    <button type="submit" class="delete"><i class="fa-solid fa-pencil"></i></button>
                </form>
            </td>
            <td><form action="modifycategory.php" method="get">
                <input type="hidden" name="rem" value="<?php echo htmlspecialchars($kart['catid']); ?>">
                <button class="kill" name="deletecat"><i class="fa-solid fa-trash-can"></i></button>
                </form>
            </td>
            <!-- view corresponding books -->
            <td><a href="adminbks.php?rem=<?php echo htmlspecialchars($kart['catid']); ?>"><button class="delete" name="buttn"><i class="fa-solid fa-eye"></i></button></a></td>
        </tr>
    <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
    <?php } ?>
</table>
<br>
    <br>
    <?php include 'footer.php'; ?>
</body>
</html>