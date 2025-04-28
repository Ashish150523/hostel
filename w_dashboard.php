<?php
include("connection.php");
session_start() ;

$query = "SELECT oid, reason, address, dfrom, dto, w_status, p_status 
           FROM outpass 
           WHERE p_status = 'approved' AND w_status = 'pending' 
           ORDER BY dfrom DESC;";


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

$query3 = "SELECT s_id, sname, semail, year, hostel_no, room_no, contact_no
           FROM student 
           ORDER BY s_id ;";

$result5 = mysqli_query($conn, $query3);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="w_dashboard.css" >
</head>
<body>
    <div class="header">
        WARDEN DASHBOARD
        <button onclick="logout()">LogOut</button>
    </div>


    <div class="outpass_requests">

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
            <form action="w_dashboard.php" method="post" class="approval_form">
                <input type="number" name="oid" required></input>
                <select  name="wstatus">
                <option value="approved">Approve</option>
                <option value="rejected">Reject</option>
                </select>
                <input type="submit" class="btn" name="submit"></input>

            </form>
        </div>
    </div>


    <div class="edit_students">

    </div>

    <div class="other_options">

        <div class="all_details">
        <div class="searchbox">
            <form action="w_dashboard.php" method="post" style="display:flex;">
                <input type="text" placeholder="Search by roll no." style="width:600px"></input>
                <input type="submit" style="width:50px"></input>
            </form>
        </div>
        <?php if ($result5 && mysqli_num_rows($result5) > 0): ?>
                            
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Year</th>
                                        <th>Hostel no.</th>
                                        <th>Room no.</th>
                                        <th>Contact no.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result5)): ?>
                                        <tr>
                                            <td><?= $row['s_id'] ?></td>
                                            <td><?= $row['sname'] ?></td>
                                            <td><?= $row['semail'] ?></td>
                                            <td><?= $row['year'] ?></td>
                                            <td><?= $row['hostel_no'] ?></td>
                                            <td><?= $row['room_no'] ?></td>
                                            <td><?= $row['contact_no'] ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No outpass history found!</p>
                        <?php endif; ?>
        </div>

        <div class="editstudent">
            Edit student Details
        </div>

    </div>

    <script>function logout() {
        sessionStorage.clear();
        alert('Logged Out');
        window.location.href = '/hostel/';
    }</script>
</body>
</html>