<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

departmentRequireLogin();

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Course result requests",
    "Review pending course-result submissions sent to the department and open each request for approval."
);
include("index.php");
departmentRenderPageEnd();
?>
