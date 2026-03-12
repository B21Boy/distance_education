
<?php
	//Include the PS_Pagination id
		include('ps_pagination.php');
	
	// Use centralized mysqli connection
	include('../connection.php');
?>                                         
<form method="post" action="" name="form1" id="form1">   
<p style="font-size:18px; margin-left:5px;">Search user  
<input type="text" autofocus="autofocus" name="search_file" id="search_file" style="width:230px; font-size:18px;" id="textboxid"placeholder="userid or user name" /> 
<input type="submit"  id="btn btn-primary" name="submit" style="height: 30px;width: 100px;background-color: #4b80b4;" value="Filter"> </p>
</form>
<p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">Number of users:<?php $count_item=mysqli_query($conn, "select * from account " ) or die(mysqli_error($conn));
$count=mysqli_num_rows($count_item);
//$a=count($sql2);
echo"<font color='red'>".($count)."</font>"; ?></p>
<?php 
if (isset($_POST['submit']) and isset($_POST['search_file'])) {
	$search_file = $_POST['search_file'];
	
$sql="select * from account where  UID like '%$search_file%' or Role like '%$search_file%'   Order by UID ASC";
$try=mysqli_query($conn, $sql);


if(mysqli_num_rows($try)>=1){

	 
	//Create a PS_Pagination object
	$pager = new PS_Pagination($conn, $sql, 10, 1);
  	//The paginate() function returns a mysql result set for the current page
	$rs = $pager->paginate();
		
	 ?>
<form name="frmUser" method="post" action="" id="frm1">
<table cellpadding="1" cellspacing="1" id="resultTable">
	
		        <tr>			        
					
                    <th>UID</th>
					<th>UserName</th>
					
			        <th>Role</th>
					<th>Status</th>
					<th>Action</th>
</tr>
<?php
$i=0;
while($row = mysqli_fetch_array($rs)) {
$user_id = $row['UID'];
		?>							
		<tr>
		    <td> <?php echo $row['UID']; ?></td>
			<td><?php echo $row['UserName']; ?></td>
			
			<td><?php echo $row['Role']; ?></td>
			<td><?php echo $row['status']; ?></td>
  <?php
$id=$row['UID'];
$data6=$row['UserName'];

$data4=$row['Role'];
$data5=$row['status'];
$data3='yes';?>
<td><a href="ACTION.php?status=<?php echo $row['UID'];?>" 
 id="btn" onchange="Block" onclick="return confirm('Are you sure <?php echo $id?>');">
 <?php
$select=mysqli_query($conn, "select * from account WHERE UID='$id' ");
$row=mysqli_fetch_object($select);
$status_var=$row->status;
IF($status_var=='yes'){
	?>
	 <input type="button" value="Block" style="background-color: #243cdb;color: #fffbfb;height: 25px;width: 100px; text-decoration: none;"/> </a></td>
	 <?php
}
else
{
 ?>
<td><input type="button" value="UNBlock" style="background-color: red;color: ##ffffff;height: 25px;width: 100px; text-decoration: none;" /> </td>
</tr>
<?php
$i++;
}
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
 	$sql = "SELECT * FROM account ";
	//Create a PS_Pagination object
	$pager = new PS_Pagination($conn, $sql, 10, 1);
 	//The paginate() function returns a mysql result set for the current page
	$rs = $pager->paginate();
 	

?>
<form name="frmUser" method="post" action="" id="frm1">
<table cellpadding="1" cellspacing="1" id="resultTable" style="margin-left:-17px;">
	
		        <tr>			        
					
                    <th>UID</th>
					<th>UserName</th>
					
			        <th>Role</th>
					<th>Status</th>
					<th>Action</th>
</tr>

<?php
$i=0;
while($row = mysqli_fetch_assoc($rs)) {
?>
<tr>
		    <td> <?php echo $row['UID']; ?></td>
			<td><?php echo $row['UserName']; ?></td>
		
			<td><?php echo $row['Role']; ?></td>
			<td><?php echo $row['status']; ?></td>
 <?php
$id=$row['UID'];
$data6=$row['UserName'];
$data4=$row['Role'];
$data5=$row['status'];
$data3='yes';?>
<td><a href="ACTION.php?status=<?php echo $row['UID'];?>" 
 id="btn" onchange="Block" onclick="return confirm('Are you sure <?php echo $id?>');">
 <?php
$select=mysqli_query($conn, "select * from account WHERE UID='$id' ");
$row=mysqli_fetch_object($select);
$status_var=$row->status;
IF($status_var=='yes'){
	?>
<input type="button" value="Block" style="background-color: #243cdb;color: #fffbfb;height: 25px;width: 100px; text-decoration: none;"/> 
	 <?php
}
else
{
 ?>
<input type="button" value="UNBlock" style="background-color: red;color: #ffffff;height: 25px;width: 100px; text-decoration: none;" /></a></td>
</tr>
<?php
$i++;
}
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
