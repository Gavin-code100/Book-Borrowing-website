<?php
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Books</title>
    <link rel="stylesheet" type="text/css" href="monday.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
    <header>
        <a href="admin.php" class="logo"></a>
        <div class="carthd">Deleted Books:</div>
        <a href="index.html" id="box" style="font-size: 23px">Log Out</a>
    </header>
    <div id="fortable">
        <table class="table-custom">
        <thead>
                <tr>
                    <th>no.</th>
                    <th>Book Name</th>
                    <th>Mark as Available</th>
                </tr>
            </thead>
            
            <?php
                $query = "SELECT bookid, bookname, bookstatus FROM books";
                $result = mysqli_query($con, $query);
                
                // Error handling should come immediately after the query
                if (!$result) {die("Query Failed! " . mysqli_error($con));
                } else {
                // Fetch all results as an associative array
                $karte = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>
            <tbody><?php $no = 1; ?>
            <?php foreach ($karte as $kart): ?>
            <?php if ($kart['bookstatus'] == '-'): ?>
                <tr>
                    <td><?php echo "$no"?>.</td></td><?php $no++;?>
                    <td><?php echo htmlspecialchars($kart['bookname']); ?></td>
                    <td><a href="losttoa.php?rem=<?php echo htmlspecialchars($kart['bookid']); ?>"><button class="returnbk" type="#" name="buttn">Make Available</button></a></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
<?php } ?>

        </tbody>
        </table> 
    </div>
    <br>
    <br>
    <?php include 'footer.php'; ?>
</body>
</html>