DROP TABLE IF EXISTS acadamic_calender;

CREATE TABLE `acadamic_calender` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `semister` varchar(500) NOT NULL,
  `dates` varchar(1000) NOT NULL,
  `activities` varchar(1000) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

INSERT INTO acadamic_calender VALUES("1","Semister one","Nehasie 22/2009 E.C-Meskerem 27/2010 E.C	
\n	
\n","-Registration for Senior Distance  Students
\n
\n-Application Dates  for New Distance Students	
\n	
\n");
INSERT INTO acadamic_calender VALUES("2","Semister one","Meskerem 29/2010 E.C - Tikimt 04/2010 E.C	
\n	
\n","-Late Registration with Penalty  for Distance Students	
\n	
\n");
INSERT INTO acadamic_calender VALUES("3","Semister one","Tikimt 05/2010 E.C	
\n	
\n","-Entrance Exam for New Applicant Students	
\n	
\n");
INSERT INTO acadamic_calender VALUES("4","Semister one","Tikimt 13-16/2010 E.C	
\n	
\n","-Registration for New Applicant Students who Passed Entrance Examination	
\n	
\n");
INSERT INTO acadamic_calender VALUES("5","Semister one","Hidar 15-17/2010 E.C	
\n	
\n","-First Round Tutorial Class for all Distance Students	
\n	
\n");
INSERT INTO acadamic_calender VALUES("6","Semister one","Tahissas 13-15/2010 E.C	
\n	
\n","-Second Round Tutorial Class for all Distance Students
\n
\n-Last Date for Make-up and Re sit Application	
\n	
\n");
INSERT INTO acadamic_calender VALUES("7","Semister one","Tirr 23-27/2010 E.C	
\n	
\n","-Exam Program for all Distance Students
\n
\n-Last Date for Submission of Seminar, Project and Senior Essay	
\n	
\n");
INSERT INTO acadamic_calender VALUES("8","Semister one","Yekatit 17/2010 E.C	
\n	
\n","-Last Date of Submitting First Semester Grades on SIMS	
\n	
\n");
INSERT INTO acadamic_calender VALUES("9","Semister Two","Yekatit 15 - 30/2010 E.C	
\n	
\n","-Registration for Senior Distance  Students
\n
\n-2ND Round  Makeup Registration	
\n	
\n");
INSERT INTO acadamic_calender VALUES("10","Semister Two","Megabit 01 - 04/2010 E.C	
\n	
\n","-Late Registration with Penalty  for Distance Students	
\n	
\n");
INSERT INTO acadamic_calender VALUES("11","Semister Two","Megabit 10-14	
\n	
\n","-Registration slip submission period(Including makeup registration)to the Registrar	
\n	
\n");
INSERT INTO acadamic_calender VALUES("12","Semister Two","Megabit 21 - 23/2010 E.C	
\n	
\n","-First Round Tutorial Class for all Distance Students	
\n	
\n");
INSERT INTO acadamic_calender VALUES("13","Semister Two","Megabit 24 & 25/2010 E.C	
\n	
\n","-Make up examination Period for all distance students	
\n	
\n");
INSERT INTO acadamic_calender VALUES("14","Semister Two","Miazia 19-21/2010 E.C	
\n	
\n","-Second Round Tutorial Class for all Distance Student	
\n	
\n");
INSERT INTO acadamic_calender VALUES("15","Semister Two","Sene 30-Hamlie 04/2010 E.C	
\n	
\n","-Exam Program for all Distance Students
\n
\n-Last Date for Submission of Seminar, Project and Senior Essay	
\n	
\n");
INSERT INTO acadamic_calender VALUES("16","Semister Two","Hamlie 30/2010 E.C	
\n	
\n","-Last Date of Submitting second Semester Grades on SIMS	
\n	
\n");


DROP TABLE IF EXISTS account;

CREATE TABLE `account` (
  `UID` varchar(20) NOT NULL,
  `UserName` varchar(50) DEFAULT NULL,
  `Password` varchar(2000) DEFAULT NULL,
  `Role` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `UserName` (`UserName`),
  CONSTRAINT `account_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO account VALUES("9370","student","ad6a280417a0f533d8b670c61667e1a0","student","yes");
INSERT INTO account VALUES("accouninst","accouninst","8cce56cac50ed7aebe233099a1e5180c","instructor","yes");
INSERT INTO account VALUES("acuntgdepthead","acuntdept","fae055df8d53e6f49853e73103e924dc","department_head","yes");
INSERT INTO account VALUES("admn001","admin","0192023a7bbd73250516f069df18b500","administrator","yes");
INSERT INTO account VALUES("buriereg002","buriereg","aa81d032718cf60dace8fd162b275802","registrar","yes");
INSERT INTO account VALUES("cde001","cdeofficer","a4c3cf87a6143753a3604078cd6c2102","cdeofficer","yes");
INSERT INTO account VALUES("dmureg001","dmureg","06a90f92e90f8bbbc680d02a136a7b57","registrar","yes");
INSERT INTO account VALUES("ecmsinst","ecmsinst","7c5f07c629789be02b3b1f54f4bb3d8a","instructor","yes");
INSERT INTO account VALUES("ecnsdepthead","ecnsdept","7331c96cc418a20a9070bf13d2c8c8e6","department_head","yes");
INSERT INTO account VALUES("fbcollagedean","fbcollage","d55acde6801aebcd360c5a27bbfbdc5e","collage_dean","yes");
INSERT INTO account VALUES("finance001","finance","b9c9b331a8a5007cb2b766c6cd293372","financestaff","yes");
INSERT INTO account VALUES("lawcollagedean","lawcollage","2f6f05af63570f1e23965e9b0cfcaf7b","collage_dean","yes");
INSERT INTO account VALUES("lawdepthead","lawdept","e71822bfdb3bed9bfbf93d7588bed880","department_head","yes");
INSERT INTO account VALUES("lawinst","lawinst","c1839bd3124aa91fa63c991e446ab0d0","instructor","yes");
INSERT INTO account VALUES("mngtdepthead","mngtdept","de973357a0c6e03094c0162efc330794","department_head","yes");
INSERT INTO account VALUES("mngtinst","mngtinst","02c8c5772c4b5bd4522e8cab2f720e5a","instructor","yes");


DROP TABLE IF EXISTS applicant;

CREATE TABLE `applicant` (
  `A_ID` int(50) NOT NULL,
  `FName` varchar(50) NOT NULL DEFAULT 'no',
  `mname` varchar(30) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `Sex` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone_No` int(100) NOT NULL,
  `Location` varchar(550) NOT NULL,
  `Education_level` varchar(550) NOT NULL,
  `College` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `program` varchar(100) NOT NULL,
  `Doc1` varchar(10000) NOT NULL,
  `reciet` varchar(500) NOT NULL,
  `Date` datetime NOT NULL,
  `unread` varchar(10) NOT NULL,
  `reject` varchar(50) NOT NULL,
  PRIMARY KEY (`A_ID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO applicant VALUES("6234","ffg","fgfg","fgfg","male","f@gmail.com","937396003","danigla","Completed 12th (10+2)","fbcollage","Accounting","Degree","docc.pdf","recit.jpg","2018-05-11 04:02:30","no","");
INSERT INTO applicant VALUES("6720","Dagim","Belay","Woldie","male","dagi@gmail.com","937396003","Burie","Completed 12th (10+2)","fbcollage","Accounting","Degree","docc.pdf","recit.jpg","2018-05-11 11:08:20","not","not");
INSERT INTO applicant VALUES("8209","hhhhhh","kkkkkk","lllllllll","male","h@gmail.com","937396003","kosober","Completed 12th (10+2)","Busines and Economics","Bussines","Degree","docc.pdf","recit.jpg","2018-04-29 03:01:43","no","");
INSERT INTO applicant VALUES("8216","ghhg","ghhg","ghh","male","abe@gmail.com","937396003","bahir dar","Completed 12th (10+2)","dffd","Accounting","Degree","docc.pdf","recit.jpg","2018-05-11 04:08:12","yes","");
INSERT INTO applicant VALUES("9370","assefa","adamu","worku","male","as@gmail.com","937396003","mota","Completed 12th (10+2)","fbcollage","Accounting","Degree","docc.pdf","recit.jpg","2018-05-12 01:37:16","yes","");
INSERT INTO applicant VALUES("9721","aaaaaa","hghggh","aaaa","male","aa@gmail.com","937396003","gonder","Completed 12th (10+2)","Engineering","Accounting","dgree","docc.pdf","recit.jpg","2018-04-20 00:31:33","yes","");


DROP TABLE IF EXISTS assign_instructor;

CREATE TABLE `assign_instructor` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `corse_code` varchar(50) NOT NULL,
  `cname` varchar(100) NOT NULL,
  `chour` int(11) NOT NULL,
  `uid` varchar(23) NOT NULL,
  `Iname` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `section` varchar(10) NOT NULL,
  `Student_class_year` varchar(50) NOT NULL,
  `semister` varchar(50) NOT NULL,
  `ayear` int(11) NOT NULL,
  PRIMARY KEY (`no`),
  UNIQUE KEY `corse_code` (`corse_code`),
  KEY `uid` (`uid`),
  CONSTRAINT `dd` FOREIGN KEY (`uid`) REFERENCES `user` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `assign_instructor_ibfk_1` FOREIGN KEY (`corse_code`) REFERENCES `course` (`course_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

INSERT INTO assign_instructor VALUES("14","ITEC003","maintenance","4","lawinst","abebe  bazezew","law","A","1st","I","2010");
INSERT INTO assign_instructor VALUES("15","jhj","jhg","6","lawinst","abebe �bazezew","law","A","1st","I","2010");
INSERT INTO assign_instructor VALUES("16","aaa","aaaa","2","accouninst","abebe  bazezew","Accounting","A","1st","I","2010");
INSERT INTO assign_instructor VALUES("17","ITEC001","java","3","accouninst","abebe  bazezew","Accounting","A","1st","I","2010");
INSERT INTO assign_instructor VALUES("18","ITEC002","php","4","accouninst","abebe  bazezew","Accounting","A","1st","I","2010");
INSERT INTO assign_instructor VALUES("19","000","design","4","accouninst","abebe  bazezew","Accounting","A","1st","I","2010");


DROP TABLE IF EXISTS assignment;

CREATE TABLE `assignment` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `S_ID` varchar(20) NOT NULL,
  `asno` varchar(50) NOT NULL,
  `ccode` varchar(50) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `Student_class_year` varchar(50) NOT NULL,
  `semister` varchar(50) NOT NULL,
  `Submission_date` date NOT NULL,
  `fileName` varchar(5000) NOT NULL,
  `tmpName` varchar(5000) NOT NULL,
  `fileSize` varchar(5000) NOT NULL,
  `fileType` varchar(5000) NOT NULL,
  `status` varchar(20) NOT NULL,
  `unread` varchar(10) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

INSERT INTO assignment VALUES("8","4641","1","ITEC433","configuration","Accounting","2nd","II","2018-04-18","Assignment three.docx","C:wamp	mpphpD9C.tmp","33985","application/vnd.openxmlformats-officedocument.wordprocessingml.document","stud","");
INSERT INTO assignment VALUES("10","4642","2","ITEC436","configuration","law","2nd","II","2018-04-17","Assignment two.docx","C:wamp	mpphp7C2A.tmp","26257","application/vnd.openxmlformats-officedocument.wordprocessingml.document","stud","");
INSERT INTO assignment VALUES("12","Ins001","2","phd2233","configuration","law","1st","II","2018-04-10","Assignment two.docx","C:wamp	mpphp9F09.tmp","26257","application/vnd.openxmlformats-officedocument.wordprocessingml.document","inst","");
INSERT INTO assignment VALUES("13","4643","2","ITEC433","configuration","law","3rd","II","2018-04-10","Assignment two.docx","C:wamp	mpphp1D0F.tmp","26257","application/vnd.openxmlformats-officedocument.wordprocessingml.document","stud","");
INSERT INTO assignment VALUES("14","7879","1","ITEC001","java","Accounting","1st","I","2018-04-10","Assignment one.docx","C:wamp	mpphpC8CA.tmp","25133","application/vnd.openxmlformats-officedocument.wordprocessingml.document","stud","no");
INSERT INTO assignment VALUES("15","1111","Assignment 1","ITEC001","java","Accounting","1st","I","2018-04-03","Assignment three.docx","C:wamp	mpphp23A7.tmp","33985","application/vnd.openxmlformats-officedocument.wordprocessingml.document","stud","no");
INSERT INTO assignment VALUES("16","lawinst","11","ITEC003","maintenance","Accounting","1st","I","2018-05-25","Assignment two.docx","C:wamp	mpphp8A65.tmp","26257","application/vnd.openxmlformats-officedocument.wordprocessingml.document","inst","");
INSERT INTO assignment VALUES("17","lawinst","3","ITEC002","php","Accounting","1st","I","2018-05-15","Assignment three.docx","C:wamp	mpphp4657.tmp","33985","application/vnd.openxmlformats-officedocument.wordprocessingml.document","inst","yes");
INSERT INTO assignment VALUES("18","accouninst","5","000","design","Accounting","1st","I","2018-05-31","Assignment three.docx","C:wamp	mpphpE738.tmp","33985","application/vnd.openxmlformats-officedocument.wordprocessingml.document","inst","yes");
INSERT INTO assignment VALUES("19","accouninst","9","000","design","Accounting","1st","I","2018-05-30","Assignment one.docx","C:wamp	mpphp4C34.tmp","26257","application/vnd.openxmlformats-officedocument.wordprocessingml.document","inst","no");
INSERT INTO assignment VALUES("20","45","11","ITEC003","maintenance","Accounting","1st","I","2018-05-23","Assignment two.docx","C:wamp	mpphpE610.tmp","26257","application/vnd.openxmlformats-officedocument.wordprocessingml.document","stud","no");


DROP TABLE IF EXISTS collage;

CREATE TABLE `collage` (
  `Ccode` varchar(20) NOT NULL,
  `CName` varchar(50) DEFAULT NULL,
  `Location` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Ccode`),
  UNIQUE KEY `CName` (`CName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO collage VALUES("fbcollage001","fbcollage","B22");
INSERT INTO collage VALUES("lawcollage001","lawcollage","B23");


DROP TABLE IF EXISTS course;

CREATE TABLE `course` (
  `Sender_name` varchar(20) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `chour` int(11) NOT NULL,
  `s_c_year` varchar(10) NOT NULL,
  `semister` varchar(10) NOT NULL,
  `ayear` int(11) NOT NULL,
  `department` varchar(50) NOT NULL,
  `FileName` varchar(500) NOT NULL,
  `status` varchar(50) NOT NULL,
  `unread` varchar(10) NOT NULL,
  PRIMARY KEY (`course_code`),
  UNIQUE KEY `cname` (`cname`),
  KEY `department` (`department`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO course VALUES("accouninst","000","design","4","1st","I","2010","Accounting","Chapter-1.pptx","yes","no");
INSERT INTO course VALUES("accouninst","aaa","aaaa","2","1st","I","2010","Accounting","Chapter 7.docx","yes","yes");
INSERT INTO course VALUES("accouninst","ITEC001","java","3","","","2010","Accounting","Chapter-1.pptx","yes","");
INSERT INTO course VALUES("accouninst","ITEC002","php","4","1st","II","2010","Accounting","Chapter 6.docx","yes","no");
INSERT INTO course VALUES("lawinst","ITEC003","maintenance","4","4th","II","2010","law","Chapter 7.docx","yes","");
INSERT INTO course VALUES("lawinst","jhj","jhg","6","2nd","II","2010","law","Chapter 6.docx","yes","");
INSERT INTO course VALUES("","phd2222","multimedia","3","","","2010","Management","","","");
INSERT INTO course VALUES("lawinst","phd2233","configuration","3","2nd","II","2010","law","Chapter-1.pptx","yes","");
INSERT INTO course VALUES("","phd4422","database","3","","","2010","Economics","","","");
INSERT INTO course VALUES("","phd4433","networking","4","","","2010","Management","","","");


DROP TABLE IF EXISTS course_result;

CREATE TABLE `course_result` (
  `no` int(200) NOT NULL AUTO_INCREMENT,
  `S_ID` varchar(50) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `year` varchar(50) NOT NULL,
  `semister` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `Assignment1` int(11) NOT NULL,
  `Assignment2` int(11) NOT NULL,
  `Assignment3` int(11) NOT NULL,
  `Assignment4` int(11) NOT NULL,
  `Final` int(11) NOT NULL,
  `Total` int(11) NOT NULL,
  `Grade` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS department;

CREATE TABLE `department` (
  `Dcode` varchar(20) NOT NULL,
  `DName` varchar(50) NOT NULL,
  `Location` varchar(20) DEFAULT NULL,
  `Ccode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Dcode`),
  UNIQUE KEY `DName` (`DName`),
  KEY `Ccode` (`Ccode`),
  KEY `Ccode_2` (`Ccode`),
  CONSTRAINT `department_ibfk_1` FOREIGN KEY (`Ccode`) REFERENCES `collage` (`Ccode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO department VALUES("accounting001","Accounting","B23","fbcollage001");
INSERT INTO department VALUES("economics001","Economics","B23","fbcollage001");
INSERT INTO department VALUES("law001","law","B22","lawcollage001");
INSERT INTO department VALUES("mngt001","Managament","B22","fbcollage001");


DROP TABLE IF EXISTS feed_back;

CREATE TABLE `feed_back` (
  `fbid` int(20) NOT NULL AUTO_INCREMENT,
  `UID` int(20) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `user_name` varchar(30) NOT NULL,
  `Comment` varchar(10000) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`fbid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

INSERT INTO feed_back VALUES("11","77","depthead","77","fddfdf","2018-03-08 16:15:32");
INSERT INTO feed_back VALUES("12","22","directorate","22","dssddd","2018-03-08 16:16:07");
INSERT INTO feed_back VALUES("13","54","student","54","wewewewewewewewewewewe","2018-03-08 16:16:26");
INSERT INTO feed_back VALUES("14","23","registrar","23","weeeeeeeeeeeeeeeeeeeeeee","2018-03-08 16:17:54");
INSERT INTO feed_back VALUES("15","78","instructor","78","mmmmmmmmmm","2018-03-08 16:18:31");


DROP TABLE IF EXISTS grade;

CREATE TABLE `grade` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `sid` varchar(20) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `mname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `sex` varchar(20) NOT NULL,
  `department` varchar(20) NOT NULL,
  `year` varchar(20) NOT NULL,
  `semister` varchar(20) NOT NULL,
  `section` varchar(20) NOT NULL,
  `c1` varchar(20) NOT NULL,
  `c2` varchar(20) NOT NULL,
  `c3` varchar(20) NOT NULL,
  `c4` varchar(20) NOT NULL,
  `c5` varchar(20) NOT NULL,
  `c6` varchar(20) NOT NULL,
  `c7` varchar(20) NOT NULL,
  `ch1` int(11) NOT NULL,
  `ch2` int(11) NOT NULL,
  `ch3` int(11) NOT NULL,
  `ch4` int(11) NOT NULL,
  `ch5` int(11) NOT NULL,
  `ch6` int(11) NOT NULL,
  `ch7` int(11) NOT NULL,
  `g1` varchar(20) NOT NULL,
  `g2` varchar(20) NOT NULL,
  `g3` varchar(20) NOT NULL,
  `g4` varchar(20) NOT NULL,
  `g5` varchar(20) NOT NULL,
  `g6` varchar(20) NOT NULL,
  `g7` varchar(20) NOT NULL,
  `tcr` double NOT NULL,
  `tgp` double NOT NULL,
  `cgpa` double NOT NULL,
  `pcgpa` double NOT NULL,
  `ptc` double NOT NULL,
  `ncgpa` double NOT NULL,
  `status` varchar(30) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

INSERT INTO grade VALUES("16","ACC/0001/10","abebe","alemu","andargie","male","Accounting","1st","I","A","c1","c2","c3","c4","c5","","","3","3","3","3","3","0","0","A-","B+","C-","C","B","","","15","42","2.8","0","0","2.8","approved");
INSERT INTO grade VALUES("17","ACC/0002/10","kebede","gesese","worku","male","Accounting","1st","I","A","c1","c2","c3","c4","c5","","","3","3","3","3","3","0","0","A","B+","C-","C+","B+","","","15","45.75","3.05","0","0","3.05","approved");
INSERT INTO grade VALUES("18","ACC/0003/10","abebaw","addis","tafere","male","Accounting","1st","I","A","c1","c2","c3","c4","c5","","","3","3","3","3","3","0","0","A","B+","C-","C-","B-","","","15","41.25","2.75","0","0","2.75","approved");


DROP TABLE IF EXISTS logfile;

CREATE TABLE `logfile` (
  `logid` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `role` varchar(40) NOT NULL,
  `status` varchar(40) NOT NULL,
  `start_time` varchar(40) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `activity_performed` varchar(10000) NOT NULL,
  `date` date NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `end` varchar(40) NOT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

INSERT INTO logfile VA<style>
#container1 {
 position: relative;
 width: 180px;
 height: 280px;
 background: lighter;
 margin-top: -15px;
 box-shadow: 5 4px 7px rgba(0, 0, 0, .1);
 background-color: #aeaeae;
}
 
.form {
 margin: 0 auto;
 margin-top: 20px;
 
} 
.label1 {
 color: #020200;
 display: inline-block;
 margin-left: 18px;
 padding-top: 10px;
 font-size: 17px;
}
.input {
 font-family: "Helvetica Neue", Helvetica, sans-serif;
 font-size: 12px;
 outline: none;
}
 
.input[type=text],
.input[type=password] {
 color: #000;
 padding-left: 10px;
 margin: 10px;
 margin-top: 12px;
 margin-left: 18px;
 width: 150px;
 height: 30px;
 border: 1px solid #41b47a;
 border-radius: 10px;

 -webkit-transition: all .4s ease;
 -moz-transition: all .4s ease;
 transition: all .4s ease;
}
 
.input[type=text]:hover,
.input[type=password]:hover {
 border: 1px solid #41b47a;
 box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .7), 0 0 0 5px #D6AE58;
}
 
.input[type=text]:focus{
 border: 1px solid #a8c9e4;
 box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #e6f2f9;
}
.input[type=password]:focus {
 border: 1px solid #a8c9e4;
 box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #e6f2f9;
}


.btn{
  background:#3594D2;

  padding-top:5px;
  padding-bottom:5px;
  color:white;
  border-radius:4px;
  border: #2980b9 1px solid;
  padding-left: 10px;
  margin-top:20px;
  margin-bottom:20px;
  float:left;
  margin-left:26px;
  font-weight:800;
  font-size:15px;
}

.btn:hover{
  background:#0b2231; 
}
</style>
<div id="container1">
        <form action="" method="post" class="form">
		<label class="label1" for="username">Username:</label>
           <input type="text" id="username" name="un" placeholder="Username" required class="input">
            <label for="password" class="label1">Password:</label>
            <input type="password" id="password" name="pass" placeholder="Password" required class="input">
<input type="submit" id="submit" class="btn" name="login" value="Login" style="height: 34px; margin-left: 15px; width: 60px; padding: 5px; border: 3px double rgb(204, 204, 204);"/>
<input type="reset" id="reset" class="btn" name="reset" value="Reset" style="height: 34px; margin-left: 15px; width: 60px; padding: 5px; border: 3px double rgb(204, 204, 204);" />
</form>
<p style="color: blue">Forgot your password? <u style="color:#fff;background-color: #336699;"><a style="color:#fff;" href="forgot.php">Click Here!</a></u></p> 
   

<?php
if(isset($_POST["login"]))
{
	$un=$_POST["un"];
	$pass=$_POST["pass"];
function encryptIt( $q ) 
{
$cryptKey='qJB0rGtIn5UB1xG03efyCp';
$qEncoded= base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
return( $qEncoded );
}
$encrypted = encryptIt($pass);
$sql="select * from account where UserName='$un' and Password='$encrypted' and status='yes'";
		$matchfound=mysql_query($sql);
		$row=mysql_fetch_assoc($matchfound);
		$uid=$row["UID"];
		$username=$row['UserName'];
		$password=$row['Password'];
		$role=$row["Role"];
		$sql1="select * from user where UID='$uid'";
		$matchfound1=mysql_query($sql1);
		$row1=mysql_fetch_assoc($matchfound1);
		
		
		
		$fname=$row1["fname"];
		$lname=$row1["lname"];
		$photo=$row1["photo"];
		$ccode=$row1["c_code"];
		$dcode=$row1["d_code"];
		
		
		$sql2="select * from department where Dcode='$dcode'";
		$matchfound2=mysql_query($sql2);
		$row2=mysql_fetch_assoc($matchfound2);
		$dcod=$row2["DName"];
		
		$sql3="select * from student where S_ID='$uid'";
		$matchfound3=mysql_query($sql3);
		$row3=mysql_fetch_assoc($matchfound3);
		$sem=$row3["semister"];
		$sec=$row3["section"];
		$yea=$row3["year"];
		$dpt=$row3["Department"];
		
		$_SESSION['sdpt']=$dpt;
		$_SESSION['ssemister']=$sem;
		$_SESSION['ssection']=$sec;
		$_SESSION['syear']=$yea;		
		
		
		$_SESSION['scc']=$ccode;
		$_SESSION['sdc']=$dcode;
		
		$_SESSION['suid']=$uid;
		$_SESSION['sun']=$username;
		$_SESSION['spw']=$password;
		$_SESSION['sfn']=$fname;
		$_SESSION['sln']=$lname;
		$_SESSION['srole']=$role;
		$_SESSION['sphoto']=$photo;
		$_SESSION['sdcode']=$dcod;
		
$login_time = date("h:i:s");
$_SESSION['login_time']=$login_time;
	if($role=="registrar")
			header("location:registrar/registrarpage.php");
	else if($role=="administrator")
			header("location:admin/adminhomepage.php");
	else if($role=="department_head")
			header("location:department/deptheadpage.php");
	else if($role=="instructor")
			header("location:instructor/instructorpage.php");
	else if($role=="student")
			header("location:student/studentpage.php");
	else if($role=="cdeofficer")
			header("location:cdeofficer/cdeofficerpage.php");
	else if($role=="financestaff")
			header("location:finance/financestafpage.php");
	else if($role=="collage_dean")
			header("location:collage/financestafpage.php");
	else if($role=="acadamic_vice_presid")
			header("location:vice_presidant/vicepage.php");
	else if($role=="directorat")
			header("location:directorat/directorpage.php");
	else
	{
$sql=mysql_query("select*from attempt");
$total=mysql_num_rows($sql);
$total++;
if($total>3)
{
header("location:index1.php");
}
else
{
echo "<font color=red><font size=3px>Invalid username/password";
echo "<br>you are tries $total times,but allowed 4 times<h1></font></font>";
$insert=mysql_query("insert into attempt values(' ')");	
}
		
	}
}
?>
</div> 
  
LUES("1","Admin","system admin","yes","29 Apr 2018 @ 10:45:49","add user","uid[tt] name[ttt] father name[ttt] sex[female] user id[tt] phone[+251937396003] ","2018-04-29","127.0.0.1","29 Apr 2018 @ 10:46:04");
INSERT INTO logfile VALUES("8","Admin","system admin","yes","29 Apr 2018 @ 11:04:34","unblock user","uid[145]  status[yes] ","2018-04-29","127.0.0.1","29 Apr 2018 @ 12:08:21");
INSERT INTO logfile VALUES("9","Admin","system admin","yes","29 Apr 2018 @ 11:16:27","block user","uid[Reg001]  status[no] ","2018-04-29","127.0.0.1","29 Apr 2018 @ 12:08:21");
INSERT INTO logfile VALUES("17","Admin","system admin","yes","29 Apr 2018 @ 12:02:37","create account","uid[tt] role[student] status[yes] ","2018-04-29","127.0.0.1","29 Apr 2018 @ 12:08:21");
INSERT INTO logfile VALUES("28","depthead","Department_Head","yes","03 May 2018 @ 09:30:59","Add course","uid[depthead001] role[department_head] status[yes] ","2018-05-03","127.0.0.1","03 May 2018 @ 09:31:07");
INSERT INTO logfile VALUES("33","depthead","Department_Head","yes","03 May 2018 @ 14:19:25","Assign course to instructor","uid[depthead001] role[department_head] status[yes] ","2018-05-03","127.0.0.1","03 May 2018 @ 14:39:04");
INSERT INTO logfile VALUES("54","Admin","system admin","yes","04 May 2018 @ 18:11:22","create account","uid[dmureg001] role[registrar] status[yes] ","2018-05-04","127.0.0.1","04 May 2018 @ 18:19:56");
INSERT INTO logfile VALUES("73","depthead","Department_Head","yes","06 May 2018 @ 17:52:50","Assign course to instructor","uid[acuntgdepthead] role[department_head] status[yes] ","2018-05-06","127.0.0.1","06 May 2018 @ 17:54:08");
INSERT INTO logfile VALUES("77","Admin","system admin","yes","10 May 2018 @ 14:04:00","add user","uid[hggh] name[hghg] father name[hggh] sex[male] user id[hggh] phone[0937396003] ","2018-05-10","127.0.0.1","10 May 2018 @ 14:13:03");
INSERT INTO logfile VALUES("80","depthead","Department_Head","yes","10 May 2018 @ 14:26:26","Add course","uid[lawdepthead] role[department_head] status[yes] ","2018-05-10","127.0.0.1","10 May 2018 @ 14:43:38");
INSERT INTO logfile VALUES("90","depthead","Department_Head","yes","12 May 2018 @ 15:50:16","Assign course to instructor","uid[acuntgdepthead] role[department_head] status[yes] ","2018-05-12","127.0.0.1","12 May 2018 @ 15:50:39");
INSERT INTO logfile VALUES("91","depthead","Department_Head","yes","12 May 2018 @ 15:50:29","Assign course to instructor","uid[acuntgdepthead] role[department_head] status[yes] ","2018-05-12","127.0.0.1","12 May 2018 @ 15:50:39");
INSERT INTO logfile VALUES("92","depthead","Department_Head","yes","12 May 2018 @ 15:50:37","Assign course to instructor","uid[acuntgdepthead] role[department_head] status[yes] ","2018-05-12","127.0.0.1","12 May 2018 @ 15:50:39");
INSERT INTO logfile VALUES("93","depthead","Department_Head","yes","13 May 2018 @ 10:37:47","Add course","uid[acuntgdepthead] role[department_head] status[yes] ","2018-05-13","127.0.0.1","13 May 2018 @ 10:38:46");
INSERT INTO logfile VALUES("94","depthead","Department_Head","yes","13 May 2018 @ 10:38:40","Assign course to instructor","uid[acuntgdepthead] role[department_head] status[yes] ","2018-05-13","127.0.0.1","13 May 2018 @ 10:38:46");
INSERT INTO logfile VALUES("95","Admin","system admin","yes","14 May 2018 @ 16:48:51","block user","uid[accouninst]  status[no] ","2018-05-14","127.0.0.1","14 May 2018 @ 16:54:47");
INSERT INTO logfile VALUES("96","Admin","system admin","yes","14 May 2018 @ 18:06:27","add user","uid[9370] name[abebaw] father name[addis] sex[male] user id[9370] phone[0937396003] ","2018-05-14","127.0.0.1","14 May 2018 @ 18:07:03");
INSERT INTO logfile VALUES("97","Admin","system admin","yes","14 May 2018 @ 18:06:54","create account","uid[9370] role[student] status[yes] ","2018-05-14","127.0.0.1","14 May 2018 @ 18:07:03");
INSERT INTO logfile VALUES("98","Admin","system admin","yes","14 May 2018 @ 18:07:01","unblock user","uid[accouninst]  status[yes] ","2018-05-14","127.0.0.1","14 May 2018 @ 18:07:03");
INSERT INTO logfile VALUES("99","Admin","system admin","yes","17 May 2018 @ 16:02:43","block user","uid[9370]  status[no] ","2018-05-17","127.0.0.1","");
INSERT INTO logfile VALUES("100","Admin","system admin","yes","17 May 2018 @ 16:02:45","unblock user","uid[9370]  status[yes] ","2018-05-17","127.0.0.1","");


DROP TABLE IF EXISTS message;

CREATE TABLE `message` (
  `M_ID` int(20) NOT NULL AUTO_INCREMENT,
  `M_sender` varchar(30) NOT NULL,
  `M_reciever` varchar(40) NOT NULL,
  `message` varchar(200) NOT NULL,
  `date_sended` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`M_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

INSERT INTO message VALUES("55","replay","depthead001","Hi Dept head","2018-05-01 23:23:57","yes");
INSERT INTO message VALUES("56","depthead001","Ins001","Hi Instructor","2018-05-01 23:24:22","no");


DROP TABLE IF EXISTS payment_table;

CREATE TABLE `payment_table` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `UID` varchar(20) NOT NULL,
  `c_code` varchar(20) NOT NULL,
  `Instructors_Name` varchar(50) NOT NULL,
  `Course_Code` varchar(50) NOT NULL,
  `No_of_Sections` int(11) NOT NULL,
  `No_of_Assignment_Marked` int(11) NOT NULL,
  `No_of_Exams_Marked` int(11) NOT NULL,
  `Rank` varchar(50) NOT NULL,
  `CrHr` int(11) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `Year` varchar(50) NOT NULL,
  `Section` varchar(50) NOT NULL,
  `No_of_hours_she_he_gave_tutorial` int(11) NOT NULL,
  `No_of_Exams_prepared` int(11) NOT NULL,
  `No_of_pages_prepared` int(50) NOT NULL,
  `Payment_per` int(11) NOT NULL,
  `Payment_Per_Assignment` int(11) NOT NULL,
  `Total_Payment_for_Exams` int(11) NOT NULL,
  `Total_Payment_for_Assignments` int(11) NOT NULL,
  `Total_Payment` int(11) NOT NULL,
  `unread` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `payment` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `UID` (`UID`),
  CONSTRAINT `id` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

INSERT INTO payment_table VALUES("19","lawdepthead","lawcollage001","abebe","java","0","0","0","lecturer","3","Law","I","A","20","0","0","100","0","0","0","2000","yes","yes","checked","tutorial");
INSERT INTO payment_table VALUES("20","acuntgdepthead","fbcollage001","abebe","java","0","0","0","lecturer","3","Accounting","I","A","20","0","0","100","0","0","0","2000","yes","yes","check","tutorial");
INSERT INTO payment_table VALUES("21","lawdepthead","lawcollage001","alemu","","0","0","50","","0","","","","0","0","0","100","0","0","0","5000","yes","yes","checked","mexam");
INSERT INTO payment_table VALUES("22","lawdepthead","lawcollage001","alemu","","0","90","0","","0","","","","0","0","0","20","0","0","0","1800","yes","yes","checked","massignment");
INSERT INTO payment_table VALUES("23","lawdepthead","lawcollage001","worku","php","5","0","0","","0","","","","0","0","0","50","0","0","0","250","yes","yes","checked","iexam");
INSERT INTO payment_table VALUES("24","lawdepthead","lawcollage001","worku","php","0","0","0","","0","","","","0","100","0","50","0","0","0","5000","yes","yes","checked","pexam");
INSERT INTO payment_table VALUES("25","lawdepthead","lawcollage001","alemu","","0","30","50","","0","","","","0","0","0","10","20","500","600","1100","yes","yes","checked","mexamassign");
INSERT INTO payment_table VALUES("26","mngtdepthead","fbcollage001","ghhg","","0","0","10","","0","","","","0","0","0","50","0","0","0","500","yes","yes","checked","mexam");
INSERT INTO payment_table VALUES("27","acuntgdepthead","fbcollage001","fgfd","","0","3","0","","0","","","","0","0","0","0","0","0","0","0","yes","no","","massignment");
INSERT INTO payment_table VALUES("28","ecnsdepthead","fbcollage001","ghhg","","0","4","10","","0","","","","0","0","0","0","0","0","0","0","yes","no","","mexamassign");
INSERT INTO payment_table VALUES("29","lawdepthead","lawcollage001","fgfd","","0","0","33","","0","","","","0","0","0","0","0","0","0","0","yes","no","","mexam");
INSERT INTO payment_table VALUES("30","lawdepthead","lawcollage001","abebe","","0","0","50","","0","","","","0","0","0","0","0","0","0","0","yes","no","","mexam");
INSERT INTO payment_table VALUES("31","acuntgdepthead","fbcollage001","zerihun","java","0","0","0","lecturer","3","Accounting","I","A","10","0","0","0","0","0","0","0","yes","no","","tutorial");
INSERT INTO payment_table VALUES("32","acuntgdepthead","fbcollage001","ghhg","","0","23","0","","0","","","","0","0","0","0","0","0","0","0","no","","","massignment");
INSERT INTO payment_table VALUES("33","acuntgdepthead","fbcollage001","ytyt","ytyt","5","0","0","","0","","","","0","0","0","0","0","0","0","0","no","","","iexam");
INSERT INTO payment_table VALUES("34","acuntgdepthead","fbcollage001","abebe","","0","4","50","","0","","","","0","0","0","0","0","0","0","0","no","","","mexamassign");
INSERT INTO payment_table VALUES("35","acuntgdepthead","fbcollage001","ytyt","ytyt","0","0","0","","0","","","","0","5","0","0","0","0","0","0","no","","","pexam");
INSERT INTO payment_table VALUES("37","cde001","","abebe    bazezew","ITEC001    java","0","0","0","","3","","","","0","0","100","2","0","0","0","200","yes","yes","checked","module");
INSERT INTO payment_table VALUES("38","acuntgdepthead","fbcollage001","abebe   alemu","ITEC001 java","0","0","0","lecturer","3","Accounting","I","A","7","0","0","0","0","0","0","0","no","","","tutorial");


DROP TABLE IF EXISTS postss;

CREATE TABLE `postss` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `types` varchar(5000) NOT NULL,
  `dates` date NOT NULL,
  `Ex_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `info` mediumtext NOT NULL,
  `posted_by` varchar(500) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO postss VALUES("1","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-03-07","2018-05-30","0000-00-00","0000-00-00","&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;","&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4635;&#4661;&#4720;&#4707;&#4704;&#4650;&#4843; &#4851;&#4845;&#4652;&#4781;&#4726;&#4652;&#4725; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;","");
INSERT INTO postss VALUES("2","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-03-07","2018-05-31","0000-00-00","0000-00-00","&#4704;2010 &#4819;/&#4637; &#4704;&#4875; &#4616;&#4634;&#4656;&#4897; &#4782;&#4653;&#4662;&#4733; (&#4850;&#4661;&#4723;&#4757;&#4661; &#4782;&#4653;&#4662;&#4733;) &#4840;&#4609;&#4616;&#4720;&#4763; &#4825;&#4653; &#4637;&#4829;&#4872;&#4707; &#4776;&#4613;&#4851;&#4653; 24 &#4773;&#4661;&#4776; &#4723;&#4613;&#4659;&#4661; 27 &#4672;&#4757; 2010 &#4819;/&#4637; &#4707;&#4617;&#4725; &#4840;&#4661;&#4651; &#4672;&#4755;&#4725; &#4845;&#4779;&#4612;&#4851;&#4621;&#4961;&#4961; &#4661;&#4616;&#4614;&#4752;&#4637; &#4704;&#4632;&#4864;&#4632;&#4650;&#4843;&#4813; &#4825;&#4653; &#4637;&#4829;&#4872;&#4707; &#4843;&#4619;&#4779;&#4612;&#4851;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4720;&#4896;&#4672;&#4657;&#4725; &#4672;&#4755;&#4725; &#4773;&#4757;&#4853;&#4725;&#4632;&#4824;&#4872;&#4705; &#4773;&#4843;&#4659;&#4656;&#4709;&#4757;","&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4635;&#4661;&#4720;&#4707;&#4704;&#4650;&#4843; &#4851;&#4845;&#4652;&#4781;&#4726;&#4652;&#4725; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;","");
INSERT INTO postss VALUES("3","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-05-13","2018-04-30","2018-05-13","2018-05-15","
\n
\n&#4840; 2010 &#4819;/&#4637; &#4840;&#4725;&#4637;&#4725; &#4824;&#4632;&#4757; &#4609;&#4616;&#4720;&#4763;&#4809; &#4808;&#4656;&#4752; &#4725;&#4637;/&#4725; &#4637;&#4829;&#4872;&#4707; &#4840;&#4634;&#4779;&#4612;&#4848;&#4809; &#4704; 26/06/2010 &#4819;/&#4637; &#4773;&#4755; &#4704;27/06/2010 &#4819;/&#4637; &#4632;&#4614;&#4753;&#4757; &#4773;&#4843;&#4659;&#4808;&#4677;&#4757; &#4704;&#4720;&#4896;&#4672;&#4657;&#4725; &#4672;&#4755;&#4725; &#4773;&#4757;&#4853;&#4725;&#4632;&#4824;&#4872;&#4705; &#4704;&#4901;&#4709;&#4677; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961;
\n	
\n			
\n	
\n","&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4635;&#4661;&#4720;&#4707;&#4704;&#4650;&#4843; &#4851;&#4845;&#4652;&#4781;&#4726;&#4652;&#4725; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;","register");
INSERT INTO postss VALUES("4","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-05-13","2018-04-30","2018-05-01","2018-05-05","	
\n	
\n&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;	
\n		
\n	
\n","&#4720;&#4776;&#4723;&#4723;&#4845;&#4755; &#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4635;&#4661;&#4720;&#4707;&#4704;&#4650;&#4843; &#4851;&#4845;&#4652;&#4781;&#4726;&#4652;&#4725; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;","apply");
INSERT INTO postss VALUES("5","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-05-11","0000-00-00","0000-00-00","0000-00-00","	
\n
\n&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;&#4961;&#4961;
\n	
\n	
\n","&#4725;&#4637;&#4613;&#4653;&#4725; &#4781;&#4941;&#4617;","");
INSERT INTO postss VALUES("6","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-05-11","0000-00-00","0000-00-00","0000-00-00","	
\n
\n&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;&#4961;&#4961;
\n	
\n	
\n","&#4725;&#4637;&#4613;&#4653;&#4725; &#4781;&#4941;&#4617; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;","");
INSERT INTO postss VALUES("7","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-05-11","0000-00-00","0000-00-00","0000-00-00","	
\n
\n&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;&#4961;&#4961;
\n	
\n	
\n","&#4725;&#4637;&#4613;&#4653;&#4725; &#4781;&#4941;&#4617; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;","");
INSERT INTO postss VALUES("8","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-05-11","0000-00-00","0000-00-00","0000-00-00","	
\n
\n&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;&#4961;&#4961;
\n	
\n	
\n","&#4725;&#4637;&#4613;&#4653;&#4725; &#4781;&#4941;&#4617; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;","");
INSERT INTO postss VALUES("9","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-05-11","0000-00-00","0000-00-00","0000-00-00","	
\n
\n&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;&#4961;&#4961;
\n	
\n	
\n","&#4725;&#4637;&#4613;&#4653;&#4725; &#4781;&#4941;&#4617; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;","");
INSERT INTO postss VALUES("10","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-05-11","0000-00-00","0000-00-00","0000-00-00","	
\n
\n&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;&#4961;&#4961;
\n	
\n	
\n","&#4725;&#4637;&#4613;&#4653;&#4725; &#4781;&#4941;&#4617; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;","");
INSERT INTO postss VALUES("11","&#4635;&#4661;&#4723;&#4808;&#4674;&#4843;","&#4616;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611;-&#4877;&#4709;&#4653; &#4720;&#4635;&#4650;&#4814;&#4733; &#4704;&#4633;&#4617;","2018-05-11","0000-00-00","0000-00-00","0000-00-00","	
\n
\n&#4704;&#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722; &#4704;&#4653;&#4672;&#4725; &#4725;&#4637;&#4613;&#4653;&#4725; &#4632;&#4653;&#4611; &#4877;&#4709;&#4653; &#4704;&#4632;&#4635;&#4653; &#4619;&#4845; &#4843;&#4621;&#4733;&#4609; &#4720;&#4635;&#4650;&#4814;&#4733; &#4840;&#4634;&#4776;&#4720;&#4617;&#4725;&#4757; &#4873;&#4851;&#4846;&#4733; &#4725;&#4777;&#4648;&#4725; &#4656;&#4901;&#4723;&#4733;&#4609; &#4720;&#4877;&#4707;&#4651;&#4810; &#4773;&#4757;&#4853;&#4723;&#4848;&#4653;&#4873; &#4773;&#4755;&#4659;&#4661;&#4707;&#4616;&#4757;&#4961;&#4961; -&#4840;&#4782;&#4653;&#4661; &#4768;&#4659;&#4845;&#4632;&#4757;&#4726;&#4733;&#4757; &#4704;&#4840;&#4782;&#4653;&#4662;&#4733; &#4722;&#4726;&#4650;&#4843;&#4621; &#4616;&#4634;&#4656;&#4903;&#4733;&#4609; &#4632;&#4637;&#4613;&#4651;&#4757; &#4635;&#4661;&#4648;&#4776;&#4709; -&#4629;&#4757;&#4931; &#4673;&#4901;&#4653; 042 &#4706;&#4654; &#4673;&#4901;&#4653; 02 &#4808;&#4845;&#4637; 04 &#4704;&#4632;&#4612;&#4853; &#4776;&#4652;&#4869;&#4661;&#4725;&#4651;&#4653; &#4632;&#4723;&#4808;&#4674;&#4843; &#4632;&#4809;&#4656;&#4853; -&#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4840;&#4634;&#4656;&#4896;&#4809; &#4776;&#4840;&#4779;&#4722;&#4725; 16-18/2010 &#4819;.&#4637; &#4661;&#4616;&#4614;&#4752; &#4840;&#4779;&#4722;&#4725; 16/2010 &#4819;.&#4637; &#4776;&#4896;&#4811;&#4721;2:00 &#4704;&#4840;&#4637;&#4725;&#4632;&#4848;&#4705;&#4707;&#4728;&#4809; &#4840;&#4632;&#4936;&#4720;&#4763; &#4781;&#4941;&#4622;&#4733; &#4704;&#4632;&#4872;&#4760;&#4725; &#4632;&#4936;&#4720;&#4757; &#4635;&#4659;&#4656;&#4709;&#4843;&#4961; &#4632;&#4723;&#4814;&#4674;&#4843; &#4843;&#4621;&#4843;&#4824; &#4635;&#4752;&#4763;&#4809;&#4637; &#4720;&#4635;&#4650; &#4635;&#4896;&#4675;&#4616;&#4843; &#4936;&#4720;&#4755; &#4632;&#4936;&#4720;&#4757; &#4768;&#4845;&#4733;&#4621;&#4637;&#4961;&#4961;
\n	
\n	
\n","&#4725;&#4637;&#4613;&#4653;&#4725; &#4781;&#4941;&#4617; &#4848;&#4709;&#4648; &#4635;&#4653;&#4678;&#4661; &#4841;&#4754;&#4712;&#4653;&#4661;&#4722;","");


DROP TABLE IF EXISTS student;

CREATE TABLE `student` (
  `no` int(50) NOT NULL,
  `S_ID` varchar(50) NOT NULL,
  `FName` varchar(50) NOT NULL DEFAULT 'no',
  `mname` varchar(20) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `Sex` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone_No` int(100) NOT NULL,
  `College` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `semister` varchar(20) NOT NULL,
  `section` varchar(20) NOT NULL,
  `program` varchar(100) NOT NULL,
  `year` varchar(11) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Education_level` varchar(50) NOT NULL,
  `Date` varchar(50) NOT NULL,
  `unread` varchar(20) NOT NULL,
  PRIMARY KEY (`S_ID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO student VALUES("1","ACC/0001/10","Abebaw","Addis","Tafere","male","abie@gmail.com","910000000","Fbcollage","Accounting","I","A","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("19","ACC/0002/10","Chalachew�","Muluken","Ahunim�","male","chale@gmail.com","919000000","Fbcollage","Accounting","I","B","Degree","1st","","","6/9/2018","no");
INSERT INTO student VALUES("9","ACC/0003/10","Felegehiwot�","Zegeye","Issa�","female","fele@gmail.com","919000000","Fbcollage","Accounting","I","A","Degree","1st","","","6/9/2018","no");
INSERT INTO student VALUES("5","ACC/0004/10","Getahun�","Abebe","Belay�","male","gech@gmail.com","919000000","Fbcollage","Accounting","I","A","Degree","1st","","","6/9/2018","no");
INSERT INTO student VALUES("21","ACC/0005/10","Senait�","Tadesse","Zewudu�","female","seni@gmail.com","919000000","Fbcollage","Accounting","I","A","Degree","1st","","","6/9/2018","no");
INSERT INTO student VALUES("15","ACC/0006/10","Worku�","Abebe","Muluken�","male","worku@gmail.com","919000000","Fbcollage","Accounting","I","B","Degree","1st","","","6/9/2018","no");
INSERT INTO student VALUES("17","ACC/0007/10","Zelalem�","Adane","Zewudu�","male","zele@gmail.com","919000000","Fbcollage","Accounting","I","B","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("10","ECNS/0001/10","Abdi","Worku�","Chane","female","abdi@gmail.com","919000000","Fbcollage","Economics","I","A","Degree","1st","","","6/9/2018","no");
INSERT INTO student VALUES("2","ECNS/0002/10","Dessie","Techane","Belew","male","dessie@gmail.com","910000000","Fbcollage","Economics","I","A","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("6","ECNS/0003/10","Moges","Sahre�","Jemal","male","mogi@gmail.com","919000000","Fbcollage","Economics","I","A","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("18","ECNS/0004/10","Tsegaye","Tenaw�","Addis","male","tsegi@gmail.com","919000000","Fbcollage","Economics","I","A","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("3","LAW/0001/10","abebe","alemu","andargie","male","abebe@gmail.com","910000000","Law","Law","I","A","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("13","LAW/0002/10","Esubalew�","Sendekie","Areadom �","male","esu@gmail.com","919000000","Law","law","I","A","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("11","LAW/0003/10","Fikir�","Ebabu","Dawit�","female","fikr@gmail.com","919000000","Law","Law","I","A","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("14","LAW/0004/10","Hagos","Tadesse�","Mulu","male","hagos@gmail.com","919000000","Law","law","I","A","Degree","1st","","","6/9/2018","no");
INSERT INTO student VALUES("8","LAW/0005/10","Taye","Seyoum�","Teshome","male","taye@gmail.com","919000000","Law","law","I","A","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("20","MNGT/0001/10","Abebe","Mekonen�","Tekliye","male","abebe1@gmail.com","919000000","Fbcollage","Managament","I","A","Degree","1st","","","6/9/2018","no");
INSERT INTO student VALUES("7","MNGT/0002/10","Abebe�","Mamo","Gashaw�","male","abebe12@gmail.com","919000000","Fbcollage","Managament","I","A","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("16","MNGT/0003/10","Alemu","Habtamu�","belew","male","alemu@gmail.com","919000000","Fbcollage","Managament","I","A","Degree","1st","","","5/9/2018","no");
INSERT INTO student VALUES("4","MNGT/0004/10","Assefa","Adamu","worku","male","assefa@gmail.com","919000000","Fbcollage","Managament","I","A","Degree","1st","","","6/9/2018","no");
INSERT INTO student VALUES("12","MNGT/0005/10","Gidey","Aderaw�","Fentahun","female","gidey@gmail.com","919000000","Fbcollage","Managament","I","A","Degree","1st","","","5/9/2018","no");


DROP TABLE IF EXISTS user;

CREATE TABLE `user` (
  `UID` varchar(20) NOT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `sex` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `phone_No` int(11) DEFAULT NULL,
  `location` varchar(20) DEFAULT NULL,
  `photo` varchar(3000) NOT NULL,
  `d_code` varchar(20) DEFAULT NULL,
  `c_code` varchar(20) NOT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `UID` (`UID`),
  KEY `Dcode` (`d_code`),
  KEY `c_code` (`c_code`),
  CONSTRAINT `aa` FOREIGN KEY (`d_code`) REFERENCES `department` (`Dcode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO user VALUES("9370","abebaw","addis","male","a@gmail.com","937396003","dmu","userphoto/a.jpg","accounting001","fbcollage001");
INSERT INTO user VALUES("accouninst","abebe","bazezew","male","abebe11@gmail.com","2147483647","B22","userphoto/img1.jpg","accounting001","fbcollage001");
INSERT INTO user VALUES("acuntgdepthead","abebe","belete","male","abebe1@gmail.com","2147483647","B29","userphoto/img1.jpg","accounting001","fbcollage001");
INSERT INTO user VALUES("admn001","abebe","alemu","male","abebe@gmail.com","2147483647","B29","userphoto/a.jpg","","");
INSERT INTO user VALUES("buriereg002","habtamu","addis","male","habtamu@gmail.com","2147483647","B22","userphoto/img1.jpg","","");
INSERT INTO user VALUES("cde001","melikamu","teshager","male","melkamu@gmail.com","2147483647","B29","userphoto/img1.jpg","","");
INSERT INTO user VALUES("dmureg001","worku","belachew","male","worku@gmail.com","2147483647","B29","userphoto/img1.jpg","","");
INSERT INTO user VALUES("ecmsinst","kelemu","alemu","male","kelemu11@gmail.com","2147483647","B22","userphoto/img1.jpg","economics001","fbcollage001");
INSERT INTO user VALUES("ecnsdepthead","worku","abebe","male","worku1@gmail.com","2147483647","B29","userphoto/img1.jpg","economics001","fbcollage001");
INSERT INTO user VALUES("fbcollagedean","ayitenew","bazezew","male","ayitenew@gmail.com","2147483647","B29","userphoto/img1.jpg","","fbcollage001");
INSERT INTO user VALUES("finance001","melisew","assefa","male","melisew@gmail.com","2147483647","B29","userphoto/img1.jpg","","");
INSERT INTO user VALUES("lawcollagedean","shibabaw","belew","male","shibabaw@gmail.com","2147483647","B29","userphoto/img1.jpg","","lawcollage001");
INSERT INTO user VALUES("lawdepthead","bekele","alemu","male","bekele@gmail.com","2147483647","B29","userphoto/img1.jpg","law001","lawcollage001");
INSERT INTO user VALUES("lawinst","worku","addis","male","worku12@gmail.com","2147483647","B22","userphoto/img1.jpg","law001","lawcollage001");
INSERT INTO user VALUES("mngtdepthead","shibabaw","bazezew","male","shibabaw@gmail.com","2147483647","B29","userphoto/img1.jpg","mngt001","fbcollage001");
INSERT INTO user VALUES("mngtinst","ayitenew","teshager","male","ayitenew11@gmail.com","2147483647","B22","userphoto/img1.jpg","mngt001","fbcollage001");


