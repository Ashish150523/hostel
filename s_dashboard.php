<?php
include("connection.php");
session_start() ;

if (isset($_POST['submit'])) {
  $reason = mysqli_real_escape_string($conn, $_POST['reason']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $from = mysqli_real_escape_string($conn, $_POST['from']);
  $to = mysqli_real_escape_string($conn, $_POST['to']);




  $sql = "INSERT INTO outpass (sid, semail, reason, address, dfrom, dto,hno ,rno)
  VALUES ('" . $_SESSION["s_id"] . "', '" . $_SESSION["semail"] . "', '$reason', '$address', '$from', '$to', '" . $_SESSION["hostel_no"] . "', '" . $_SESSION["room_no"] . "')";
$result = mysqli_query($conn, $sql);
      echo "
    <script>
    alert('outpass request successfull!');
    window.location.href='/hostel/s_dashboard.php';
    </script>
    ";
}


if (isset($_SESSION['s_id'])) {
    $sid = $_SESSION['s_id'];

    $query = "SELECT oid, reason, address, dfrom, dto, w_status, p_status 
              FROM outpass 
              WHERE sid = '$sid' 
              ORDER BY dfrom DESC 
              LIMIT 1";
    $query2 = "SELECT oid, reason, address, dfrom, dto, w_status, p_status 
    FROM outpass 
    WHERE sid = '$sid' 
    ORDER BY dfrom ";

    $result = mysqli_query($conn, $query);
    $result1 = mysqli_query($conn, $query2);


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="s_dashboard.css" >
</head>
<body>

    <div class="header">
        STUDENT DASHBOARD
        <button onclick="logout()">LogOut</button>
    </div>

    <div class="welcome">
        WELCOME ,
        <?= $_SESSION["sname"]?>
    </div>

    <div class="container">

        <div class="apply_out btn">
            REQUEST <p>FOR OUTPASS</p>
        </div>

        <div class="check_status btn">
            CHECK STATUS
        </div>

        <div class="show_history btn">
            HISTORY
        </div>

    </div>

    <div class="dialog_box">
        <div class="request_click" >
            <form action="s_dashboard.php" method="post" class="request">

                <input type="text" name="reason" placeholder="REASON" required id="reason"><br>
                <input type="text" name="address" placeholder="ADDRESS" required id="address"><br>
                <input type="date" name="from" placeholder="FROM" required id="from">
                <input type="date" name="to" placeholder="TO" required id="to">
                <input type="submit" name="submit" placeholder="SUBMIT" id="submit">

            </form>
        </div>

        <div class="status_click" style="display: none;">

            <div class="status">

                <?php if ($result && mysqli_num_rows($result) > 0): $row = mysqli_fetch_assoc($result); ?>
                    
                    
                    <table>
                    <tr>
                        <td>Outpass ID :</td>
                        <td><?= $row['oid'] ?> </td>
                    </tr>
                    <tr>
                        <td>Reason : </td>
                        <td><?=$row['reason'] ?>
                    </tr>
                    <tr>
                        <td>Address :</td>
                        <td><?=$row['address']?></td>
                    </tr>
                    <tr>
                        <td>Date From :</td>
                        <td><?=$row['dfrom']?></td>
                    </tr>                <tr>
                        <td>Date To :</td>
                        <td><?=$row['dto']?></td>
                    </tr>                <tr>
                        <td>Parents status :</td>
                        <td><?=$row['p_status']?></td>
                    </tr>                
                    <tr>
                        <td>Warden status :</td>
                        <td><?=$row['w_status']?></td>
                    </tr>
    
                </table>
            <?php else: ?>
                    <p>No outpass requests found!</p>
            <?php endif; ?>


            </div>

        </div>

        <div class="history_click"  style="display: none;">

            <div class="history" >
            <?php if ($result1 && mysqli_num_rows($result1) > 0): ?>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Outpass ID</th>
                                <th>Reason</th>
                                <th>Address</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Parents Status</th>
                                <th>Warden Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result1)): ?>
                                <tr>
                                    <td><?= $row['oid'] ?></td>
                                    <td><?= $row['reason'] ?></td>
                                    <td><?= $row['address'] ?></td>
                                    <td><?= $row['dfrom'] ?></td>
                                    <td><?= $row['dto'] ?></td>
                                    <td><?= ucfirst($row['p_status']) ?></td>
                                    <td><?= ucfirst($row['w_status']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No outpass history found!</p>
                <?php endif; ?>
            </div>

        </div>


    </div>

    <script src="s_dash.js" ></script>
</body>
</html>