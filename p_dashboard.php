<?php
include("connection.php");
session_start() ;
$sid = mysqli_real_escape_string($conn, $_SESSION['s_id']);
$query = "SELECT oid, reason, address, dfrom, dto, w_status, p_status ,sid
           FROM outpass 
           WHERE p_status = 'pending' AND w_status = 'pending' AND sid = '$sid' ;";


$result3 = mysqli_query($conn, $query);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oid = isset($_POST['oid']) ? mysqli_real_escape_string($conn, $_POST['oid']) : '';
    $wstatus = isset($_POST['wstatus']) ? mysqli_real_escape_string($conn, $_POST['wstatus']) : '';

    if (!empty($oid) && !empty($wstatus)) {
        $query2 = "UPDATE outpass
                   SET w_status = '$wstatus'
                   WHERE oid = $oid;";

        $result4 = mysqli_query($conn, $query2);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="p_dashboard.css">
</head>
<body>

<div class="header">
        PARENT DASHBOARD
        <button onclick="logout()">LogOut</button>
    </div>

    <div class="BOX">

   
    <div class="outpass_list">
    <?php if ($result3 && mysqli_num_rows($result3) > 0): ?>
                        
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
                                <?php while ($row = mysqli_fetch_assoc($result3)): ?>
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

    <div class="approval_box">
            <form action="p_dashboard.php" method="post" class="approval_form">
                <input type="number" name="oid" required></input>
                <select  name="wstatus">
                <option value="approved">Approve</option>
                <option value="rejected">Reject</option>
                </select>
                <input type="submit" class="btn" name="submit"></input>

            </form>
    </div>

    </div>

    <script>function logout() {
        sessionStorage.clear();
        alert('Logged Out');
        window.location.href = '/hostel/';
    }</script>

</body>
</html>