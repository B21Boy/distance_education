<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" href="../setting.css">
<style>
/* inline fallback when stylesheet isn't loaded: keep columns, spacing, and proportions */
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; }
.main-row > #sidebar { flex: 0 0 260px !important; }
</style>
<script src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">

    <!-- Header -->
    <div id="header">
         <?php require("header.php"); ?>
    </div>

    <!-- Menu -->
    <div id="menu">
        <?php require("menu.php"); ?>
    </div>

    <!-- Main row: left | center | right -->
    <div class="main-row">
        <!-- Left Sidebar -->
        <div id="left">
            <?php require("sidemenu.php"); ?>
        </div>

        <!-- Main Content (center) -->
        <div id="content">
            <div id="contentindex5">

                        // use shared mysqli connection
                        $d_program = mysqli_query($conn, "SELECT * FROM department");
                        while($getDprog = mysqli_fetch_array($d_program)){
                            $name = $getDprog['DName'];
            <script>
            function Clickheretoprint()
            {
              var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,";
                  disp_setting+="scrollbars=yes,widtd=900, height=400, left=100, top=25";
              var content_vlue = document.getElementById("print_content").innerHTML;

              var docprint=window.open("","",disp_setting);
               docprint.document.open();
               docprint.document.write('<html><head><title>List of Passer</title>');
            <script src="theme.js"></script>
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

            </div>
        </div>

        <!-- Right Sidebar -->
        <div id="sidebar">
<?php require("rightsidebar.php"); ?>
</div>


    <!-- Footer -->
    <div id="footer">
        <?php include("../footer.php"); ?>
    </div>

</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>