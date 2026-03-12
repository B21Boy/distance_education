<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Administrator page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>

</head>
<body>
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">
<table><tr><td>
<?php
    require("header.php");
?>
</td></tr><tr><td colspan="3">
<?php
    require("menu.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenu.php");
?>
	
</td><td>
	<div id="contentindex5">
	
						// use shared mysqli connection
						$d_program = mysqli_query($conn, "SELECT * FROM department");
						while($getDprog = mysqli_fetch_array($d_program)){
							$name = $getDprog['DName'];
function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,widtd=900, height=400, left=100, top=25"; 
  var content_vlue = document.getElementById("print_content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('<html><head><title>List of Passer</title>'); 
   docprint.document.write('</head><body onLoad="self.print()" style="width:600px;border:-10px solid red;margin-left:400px; font-size:16px; font-family:TimesNewRoman;">');          
				 	$d_program = mysqli_query($conn, "SELECT * FROM department where DName='$d'");
   docprint.document.write('</body></html>'); 
   docprint.document.close(); 
   docprint.focus(); 
}
</script>

				<form action=" " method="post">   
                Select Department to print student account<br>    
                    
					<select name="dpt"  class="login-form2"  style="height:30px; width:180px;" required>
                      <option value="">--select department--</option>
                        <?php
						mysql_connect("localhost","root","");
						mysql_select_db("cde");

					$d_program = mysql_query("SELECT * FROM department");
					while($getDprog = mysql_fetch_array($d_program)){
						$name = $getDprog['DName'];
				 ?>
					<option value="<?php echo $name;  ?>"><?php echo $name; ?></option>
				<?php } ?>
                    </select>
					<input type="submit" value="Search"  name="search"/>
                 </form>
                 <?php
                 if(isset($_POST['search']))
                 {
				 	$d=$_POST['dpt'];
				 	$d_program = mysql_query("SELECT * FROM department where DName='$d'");
					if($getDprog = mysql_fetch_array($d_program)){
						 $name = $getDprog['Dcode'];    
                 ?>
<div id="print_content">
<table style="width: 516.8pt;margin-left:-15px; border-collapse: collapse;" border="1" width="689" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td style="width: 118pt; border-style: solid solid solid none; border-top-width: 1pt; border-top-color: windowtext; border-right-width: 1pt; border-right-color: windowtext; border-bottom-width: 1pt; border-bottom-color: windowtext; padding: 0in 5.4pt;" valign="top">
            <p><span style="font-size: 12pt; font-family: &quot;times new roman&quot;, serif;">Student ID</span></p>
            </td>
           <td style="width: 118pt; border-style: solid solid solid none; border-top-width: 1pt; border-top-color: windowtext; border-right-width: 1pt; border-right-color: windowtext; border-bottom-width: 1pt; border-bottom-color: windowtext; padding: 0in 5.4pt;" valign="top">
            <p><span style="font-size: 12pt; font-family: &quot;times new roman&quot;, serif;">Department</span></p>
            </td>
            
            <td style="width: 109.8pt; border-style: solid solid solid none; border-top-width: 1pt; border-top-color: windowtext; border-right-width: 1pt; border-right-color: windowtext; border-bottom-width: 1pt; border-bottom-color: windowtext; padding: 0in 5.4pt;" valign="top">
            <p><span style="font-size: 12pt; font-family: &quot;times new roman&quot;, serif;">User Name will be</span></p>
            </td>
            <td style="width: 101.8pt; border-style: solid solid solid none; border-top-width: 1pt; border-top-color: windowtext; border-right-width: 1pt; border-right-color: windowtext; border-bottom-width: 1pt; border-bottom-color: windowtext; padding: 0in 5.4pt;" valign="top">
            <p><span style="font-size: 12pt; font-family: &quot;times new roman&quot;, serif;">Temporary password</span></p>
            </td>
            <td style="width: 82.55pt; border-style: solid solid solid none; border-top-width: 1pt; border-top-color: windowtext; border-right-width: 1pt; border-right-color: windowtext; border-bottom-width: 1pt; border-bottom-color: windowtext; padding: 0in 5.4pt;" valign="top">
            <p><span style="font-size: 12pt; font-family: &quot;times new roman&quot;, serif;">Remark</span></p>
            </td>
        </tr>
        <?php
function decryptIt( $q )
{
$cryptKey= 'qJB0rGtIn5UB1xG03efyCp';
$qDecoded= rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
return( $qDecoded );
}
        $sql=mysql_query("select * from account where Role='student' and status='yes' ORDER BY UID ASC");
        while($row=mysql_fetch_array($sql))
        {
        $idd=$row['UID'];
       	 $sql1=mysql_query("select * from user where  d_code='$name' and UID='$idd'");
       	if($row11=mysql_fetch_array($sql1))
       	{
       		
				$p=$row['Password'];
        	$decrypted = decryptIt($p);
        ?>
        <tr>
    <td style="width: 118pt; border-style: none solid solid none; border-bottom-width: 1pt; border-bottom-color: windowtext; border-right-width: 1pt; border-right-color: windowtext; padding: 0in 5.4pt;" valign="top">
            <p><span style="font-size: 12pt; font-family: &quot;times new roman&quot;, serif;"><?php echo $row['UID'];?></span></p>
            </td>
            <?php
            ?>
            <td style="width: 118pt; border-style: none solid solid none; border-bottom-width: 1pt; border-bottom-color: windowtext; border-right-width: 1pt; border-right-color: windowtext; padding: 0in 5.4pt;" valign="top">
            <p><span style="font-size: 12pt; font-family: &quot;times new roman&quot;, serif;"><?php echo $d;?></span></p>
            </td>
            <td style="width: 109.8pt; border-style: none solid solid none; border-bottom-width: 1pt; border-bottom-color: windowtext; border-right-width: 1pt; border-right-color: windowtext; padding: 0in 5.4pt;" valign="top">
<p style="margin-left: -12.45pt; text-indent: 12.45pt;"><span style="font-size: 12pt; font-family: &quot;times new roman&quot;, serif;"><?php echo $row['UserName'];?></span></p>
            </td>
            <td style="width: 101.8pt; border-style: none solid solid none; border-bottom-width: 1pt; border-bottom-color: windowtext; border-right-width: 1pt; border-right-color: windowtext; padding: 0in 5.4pt;" valign="top">
            <p><span style="font-size: 12pt; font-family: &quot;times new roman&quot;, serif;"><?php echo $decrypted;?></span></p>
            </td>
<?php
}
}
?>
            <td rowspan="5" style="width: 82.55pt; border-style: none solid solid none; border-bottom-width: 1pt; border-bottom-color: windowtext; border-right-width: 1pt; border-right-color: windowtext; padding: 0in 5.4pt;" valign="top">
            <p><span style="font-size: 12pt; font-family: &quot;times new roman&quot;, serif;">All characters in the temporary Password are &nbsp;in small letter upper letter.</span></p>
            </td>
        </tr>


    </tbody>
</table>
	<center><a href="javascript:Clickheretoprint()"><font size="5"color="#3d80c2">Print it Now!</font></a>
		</center>
				</div>
			<?php
			}
			}
			?>	

</div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#b00404>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
?>
<div id="sidebarr">
<ul>
 <li><a href="updateprofilephoto.php">Change Photo</a></li>
	<li><a href="changepass.php">Change password</a></li>
	 </ul>
</div>
	 </div>
	 <div id="siderightindexadational">
	 <div id="siderightindexadational1">
	 Social link 
	 </div>
	 <div id="siderightindexadational12">
	 <table>
	 <tr><td><div id="facebook"></div></td><td>
	<p><a href="https://www.facebook.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Facebook</a><p></td></tr>
	<tr><td><div id="twitter"></div></td><td><p><a href="https://www.twitter.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Twitter</a></p></td></tr>
	<tr><td><div id="you"></div></td><td><p><a href="https://www.youtube.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Youtube</a></p></td></tr>
	<tr><td><div id="googleplus"></div></td><td><p><a href="https://plus.google.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Google++</a></p></td></tr></table>
	</div>
	 </div>
	  </td>
	 </tr>
	 <tr><td>
<?php
include("../footer.php");
?>
</td></tr>

</div>
</table>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>