<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Calendar | JavaScript Examples | UIZE JavaScript Framework</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="keywords" content="widget Uize.Widgets.Calendar.Widget"/>
  <meta name="description" content="See an example of a calendar widget that you can use on your own Web site to let users choose a date from a grid, with controls for navigating months."/>
  <link rel="alternate" type="application/rss+xml" title="UIZE JavaScript Framework - Latest News" href="http://www.uize.com/latest-news.rss"/>
  <link rel="stylesheet" href="../css/page.css"/>
  <link rel="stylesheet" href="../css/page.example.css"/>
  <style type="text/css">
    .calendarShell {
      display: inline-block;
      background: #fff;
      padding: 5px;
      border: 1px solid #ccc;
    }
  </style>
</head>

<body>

<script type="text/javascript" src="../js/Uize.js"></script>

<h1 class="header">
  <a id="page-homeLink" href="../index.html" title="UIZE JavaScript Framework home"></a>
  <a href="../index.DROP TABLE IF EXISTS acadamic_calender;

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
  UNIQUE KEY `UID` (`UID`),
  UNIQUE KEY `UserName` (`UserName`),
  CONSTRAINT `account_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`)
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

INSERT INTO assign_instructor VALUES("14","ITEC003","maintenance","4","lawinst",html" class="homeLinkText" title="UIZE JavaScript Framework home">UIZE JavaScript Framework</a>
</h1>

<div class="main">
  <h1 class="document-title">
    <a href="../javascript-examples.html" class="breadcrumb breadcrumbWithArrow">JAVASCRIPT EXAMPLES</a>
    Calendar
    <div class="pageActionsShell">
      <div id="page-actions" class="pageActions"><a href="source-code/calendar.html" class="buttonLink">SOURCE</a></div>
    </div>
  </h1>

  <!-- explanation copy -->

  <div class="explanation">
    <p>In this example, an instance of the <a href="../reference/Uize.Widgets.Calendar.Widget.html"><code>Uize.Widgets.Calendar.Widget</code></a> class is used to wire up a simple calendar widget. Initially, the calendar's value is set to today's date. However, you can change it's value by clicking on a different date of this month, or you can use the arrows to navigate to and select a date from a different month. The month and year that the calendar displays are accessible through the <code>month</code> and <code>year</code> state properties, respectively. Below the calendar widget is a summary of its current state and some links to let you programmatically interact with the calendar. Play around with the calendar widget and see how the state updates, and mess with the links to control the calendar.</p>
  </div>

  <center>
    <div id="page-calendar" class="calendarShell"></div>
  </center>

  <!-- programmatic interface examples -->

  <div class="programmaticInterface">
    <ul>
      <li>Current State
        <ul>
          <li><b>calendar.get ('value') == </b>new Date ('<span id="page-calendarValue"></span>')</li>
          <li><b>calendar.get ('month') == </b><span id="page-calendarMonth"></span></li>
          <li><b>calendar.get ('year') == </b><span id="page-calendarYear"></span></li>
        </ul>
      </li>
      <li>Navigate Programmatically
        <ul>
          <li>MONTH
            <ul>
              <li>PREVIOUS MONTH: <a href="javascript://" class="linkedJs">calendar.set ({month:calendar.get ('month') - 1})</a></li>
              <li>NEXT MONTH: <a href="javascript://" class="linkedJs">calendar.set ({month:calendar.get ('month') + 1})</a></li>
            </ul>
          </li>
          <li>YEAR
            <ul>
              <li>PREVIOUS YEAR: <a href="javascript://" class="linkedJs">calendar.set ({year:calendar.get ('year') - 1})</a></li>
              <li>NEXT YEAR: <a href="javascript://" class="linkedJs">calendar.set ({year:calendar.get ('year') + 1})</a></li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</div>

<!-- JavaScript code to insert the calendar widget and wire up the page -->

<script type="text/javascript">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Calendar | JavaScript Examples | UIZE JavaScript Framework</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="keywords" content="widget Uize.Widgets.Calendar.Widget"/>
  <meta name="description" content="See an example of a calendar widget that you can use on your own Web site to let users choose a date from a grid, with controls for navigating months."/>
  <link rel="alternate" type="application/rss+xml" title="UIZE JavaScript Framework - Latest News" href="http://www.uize.com/latest-news.rss"/>
  <link rel="stylesheet" href="../css/page.css"/>
  <link rel="stylesheet" href="../css/page.example.css"/>
  <style type="text/css">
    .calendarShell {
      display: inline-block;
      background: #fff;
      padding: 5px;
      border: 1px solid #ccc;
    }
  </style>
</head>

<body>

<script type="text/javascript" src="../js/Uize.js"></script>

<h1 class="header">
  <a id="page-homeLink" href="../index.html" title="UIZE JavaScript Framework home"></a>
  <a href="../index.html" class="homeLinkText" title="UIZE JavaScript Framework home">UIZE JavaScript Framework</a>
</h1>

<div class="main">
  <h1 class="document-title">
    <a href="../javascript-examples.html" class="breadcrumb breadcrumbWithArrow">JAVASCRIPT EXAMPLES</a>
    Calendar
    <div class="pageActionsShell">
      <div id="page-actions" class="pageActions"><a href="source-code/calendar.html" class="buttonLink">SOURCE</a></div>
    </div>
  </h1>

  <!-- explanation copy -->

  <div class="explanation">
    <p>In this example, an instance of the <a href="../reference/Uize.Widgets.Calendar.Widget.html"><code>Uize.Widgets.Calendar.Widget</code></a> class is used to wire up a simple calendar widget. Initially, the calendar's value is set to today's date. However, you can change it's value by clicking on a different date of this month, or you can use the arrows to navigate to and select a date from a different month. The month and year that the calendar displays are accessible through the <code>month</code> and <code>year</code> state properties, respectively. Below the calendar widget is a summary of its current state and some links to let you programmatically interact with the calendar. Play around with the calendar widget and see how the state updates, and mess with the links to control the calendar.</p>
  </div>

  <center>
    <div id="page-calendar" class="calendarShell"></div>
  </center>

  <!-- programmatic interface examples -->

  <div class="programmaticInterface">
    <ul>
      <li>Current State
        <ul>
          <li><b>calendar.get ('value') == </b>new Date ('<span id="page-calendarValue"></span>')</li>
          <li><b>calendar.get ('month') == </b><span id="page-calendarMonth"></span></li>
          <li><b>calendar.get ('year') == </b><span id="page-calendarYear"></span></li>
        </ul>
      </li>
      <li>Navigate Programmatically
        <ul>
          <li>MONTH
            <ul>
              <li>PREVIOUS MONTH: <a href="javascript://" class="linkedJs">calendar.set ({month:calendar.get ('month') - 1})</a></li>
              <li>NEXT MONTH: <a href="javascript://" class="linkedJs">calendar.set ({month:calendar.get ('month') + 1})</a></li>
            </ul>
          </li>
          <li>YEAR
            <ul>
              <li>PREVIOUS YEAR: <a href="javascript://" class="linkedJs">calendar.set ({year:calendar.get ('year') - 1})</a></li>
              <li>NEXT YEAR: <a href="javascript://" class="linkedJs">calendar.set ({year:calendar.get ('year') + 1})</a></li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</div>

<!-- JavaScript code to insert the calendar widget and wire up the page -->

<script type="text/javascript">

Uize.require (
  [
    'UizeSite.Page.Example.library',
    'UizeSite.Page.Example',
    'Uize.Widgets.Calendar.Widget'
  ],
  function () {
    'use strict';

    /*** create the example page widget ***/
      var page = window.page = UizeSite.Page.Example ({evaluator:function (code) {eval (code)}});

    /*** add the calendar child widget ***/
      var calendar = page.addChild (
        'calendar',
        Uize.Widgets.Calendar.Widget,
        {
          built:false,
          size:'tiny'
        }
      );

    /*** wire up the page widget ***/
      page.wireUi ();

    /*** some code for demonstrating the widget's programmatic interface ***/
      function displayCalendarState () {
        page.setNodeValue ('calendarValue',calendar.get ('value'));
        page.setNodeValue ('calendarMonth',calendar.get ('month'));
        page.setNodeValue ('calendarYear',calendar.get ('year'));
      }
      calendar.wire ('Changed.value',displayCalendarState);
      calendar.wire ('Changed.month',displayCalendarState);
      calendar.wire ('Changed.year',displayCalendarState);
      displayCalendarState ();
  }
);

</script>

</body>
</html>
Uize.require (
  [
    'UizeSite.Page.Example.library',
    'UizeSite.Page.Example',
    'Uize.Widgets.Calendar.Widget'
  ],
  function () {
    'use strict';

    /*** create the example page widget ***/
      var page = window.page = UizeSite.Page.Example ({evaluator:function (code) {eval (code)}});

    /*** add the calendar child widget ***/
      var calendar = page.addChild (
        'calendar',
        Uize.Widgets.Calendar.Widget,
        {
          built:false,
          size:'tiny'
        }
      );

    /*** wire up the page widget ***/
      page.wireUi ();

    /*** some code for demonstrating the widget's programmatic interface ***/
      function displayCalendarState () {
        page.setNodeValue ('calendarValue',calendar.get ('value'));
        page.setNodeValue ('calendarMonth',calendar.get ('month'));
        page.setNodeValue ('calendarYear',calendar.get ('year'));
      }
      calendar.wire ('Changed.value',displayCalendarState);
      calendar.wire ('Changed.month',displayCalendarState);
      calendar.wire ('Changed.year',displayCalendarState);
      displayCalendarState ();
  }
);

</script>

</body>
</html>