<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

departmentRequireLogin();

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Grade report requests",
    "Check pending grade-report submissions from the department queue and open the details you need to approve."
);
include("indexg.php");
departmentRenderPageEnd();
?>
