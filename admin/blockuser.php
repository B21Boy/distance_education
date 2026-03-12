
<?php
	//Include the PS_Pagination id
		include('ps_pagination.php');
	
	// Use centralized mysqli connection
	include('../connection.php'); // provides $conn (mysqli)
	if (!($conn instanceof mysqli)) {
		die("Database connection failed or not available.");
	}
?>                                         
<form method="post" action="" name="form1" id="form1"> 
 <table>
    <tr><td>  
<p style="font-size:18px; margin-left:5px;">Search user  </td><td>
<input type="text" autofocus="autofocus" name="search_file" id="search_file" style="width:230px; font-size:18px;" id="textboxid"placeholder="userid" /> </td>
<td>
<input type="submit"  id="btn btn-primary" name="submit" style="height: 30px;width: 100px;background-color: #4b80b4;" value="Filter">  </td>  
    <td>&nbsp;&nbsp;</td> <td> 
 <a rel="facebox" href="addnewuser.php" title="">Add New User</a>

	</td>
     </tr>
     </table>
	  </p>
</form>
<p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">Number of users:<?php include '../connection.php'; $count_item=mysqli_query($conn, "select * from user " ) or die(mysqli_error($conn));
$count=mysqli_num_rows($count_item);
//$a=count($sql2);
echo"<font color='red'>".($count)."</font>"; ?></p>
<?php 
if (isset($_POST['submit']) and isset($_POST['search_file'])) {
	$search_file = $_POST['search_file'];
	
$sql = "select * from user where  UID like '%$search_file%'  Order by UID ASC";
$try = mysqli_query($conn, $sql);

if (mysqli_num_rows($try) >= 1) {

	//Create a PS_Pagination object (supports mysqli)
	$pager = new PS_Pagination($conn, $sql, 4, 1);
	//The paginate() function returns a mysqli_result for mysqli
	$rs = $pager->paginate();
		
	 ?>
<form name="frmUser" method="post" action="" id="frm1">
<table cellpadding="1" cellspacing="1" id="resultTable">
	
		        <tr>			        
					
                    <th>UID</th>
					<th>First<br>Name</th>
					<th>Last<br>Name</th>
			        <th>Sex</th>
					<th>Email</th>
				    <th>Phone_No</th>
				    <th>Location</th>
				    <th>Photo</th>
</tr>
<?php
$i=0;
while($row = mysqli_fetch_array($rs)) {
$user_id = $row['UID'];
		?>							
		<tr>
			<td> <?php echo $row['UID']; ?></td>
			<td><?php echo $row['fname']; ?></td>
			<td><?php echo $row['lname']; ?></td>
			<td><?php echo $row['sex']; ?></td>
			<td><?php echo $row['Email']; ?></td>
			<td><?php echo $row['phone_No']; ?></td>		
		    <td><?php echo $row['location']; ?></td>
	<td><img src="<?php echo $row['photo']; ?>" width="100" height="60"/></td>
 
</tr>
<?php
$i++;
}

?>

</table>
</form>
<?php
}
else{	
echo "no result found!!";
 }
}
 else
 {
 	$sql = "SELECT * FROM user ";
	//Create a PS_Pagination object
	$pager = new PS_Pagination($conn, $sql, 4, 1);
 	//The paginate() function returns a mysql result set for the current page
	$rs = $pager->paginate();
 	

?>
<form name="frmUser" method="post" action="" id="frm1">
<table cellpadding="1" cellspacing="1" id="resultTable" style="margin-left: -15px;">
	
		        <tr>			        
					
                    <th>UID</th>
					<th>First<br>Name</th>
					<th>Last<br>Name</th>
			        <th>Sex</th>
					<th>Email</th>
				    <th>Phone_No</th>
				    <th>Location</th>
				    <th>Photo</th>
</tr>

<?php
$i=0;
while($row = mysqli_fetch_assoc($rs)) {
?>
<tr>
		    <td> <?php echo $row['UID']; ?></td>
			<td><?php echo $row['fname']; ?></td>
			<td><?php echo $row['lname']; ?></td>
			<td><?php echo $row['sex']; ?></td>
			<td><?php echo $row['Email']; ?></td>
			<td><?php echo $row['phone_No']; ?></td>		
		    <td><?php echo $row['location']; ?></td>
	<td><img src="<?php echo $row['photo']; ?>" width="100" height="60"/></td>

</tr>
<?php
$i++;
}
?>
</table>
</form>
<?php

	//Display the navigation
	//echo $pager->renderFullNav();
	echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
	}
	
?>
