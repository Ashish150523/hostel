<?php
include("connection.php");
session_start() ;
$query = "SELECT oid, reason, address, dfrom, dto, w_status, p_status ,sid
           FROM outpass 
           WHERE p_status = 'approved' AND w_status = 'approved'";


$result3 = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="ss_dashboard.css" >
</head>
<body>

<div class="header">
        SECURITY DASHBOARD
        <button onclick="logout()">LogOut</button>
    </div>

    <div class="box">
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
                                        <td style="color:lightgreen;"><?= ucfirst($row['p_status']) ?></td>
                                        <td style="color:lightgreen;"><?= ucfirst($row['w_status']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No outpass history found!</p>
                    <?php endif; ?>
        </div>

        </div>
        <script>function logout() {
        sessionStorage.clear();
        alert('Logged Out');
        window.location.href = '/hostel/';
    }</script>
</body>
</html>