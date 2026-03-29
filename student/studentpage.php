<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$firstName = studentSessionValue('sfn');
$academicChips = array_filter(array(
    studentSessionValue('sdpt') !== '' ? 'Department: ' . studentSessionValue('sdpt') : '',
    studentSessionValue('syear') !== '' ? 'Year: ' . studentSessionValue('syear') : '',
    studentSessionValue('ssemister') !== '' ? 'Semester: ' . studentSessionValue('ssemister') : '',
    studentSessionValue('ssection') !== '' ? 'Section: ' . studentSessionValue('ssection') : ''
));

studentRenderPageStart(
    "Student page",
    "Student Dashboard",
    "Welcome back, " . ($firstName !== '' ? $firstName : 'Student') . ".",
    "Use this area to download learning materials, submit assignment work, check results, and stay current with new academic notifications.",
    array('body_class' => 'student-portal-page light-theme home-page')
);
?>
<div class="student-dashboard-home">
    <?php if (!empty($academicChips)) { ?>
        <div class="student-stat-row">
            <?php foreach ($academicChips as $chip) { ?>
                <span class="student-stat-chip"><?php echo studentH($chip); ?></span>
            <?php } ?>
        </div>
    <?php } ?>

    <section class="student-hero">
        <p class="student-hero-label">Quick Start</p>
        <h2>Your student workspace is ready.</h2>
        <p>Each page in this section now uses the same wider layout so tables, forms, reports, and downloads are easier to read without squeezing the content.</p>
    </section>

    <section class="student-quick-grid" aria-label="Quick actions">
        <a class="student-quick-card" href="downloadmodule.php">
            <strong>Modules</strong>
            <span>Find approved course materials by class year and semester.</span>
        </a>
        <a class="student-quick-card" href="assignmentdownload.php">
            <strong>Assignment Files</strong>
            <span>Download the latest assignment briefs posted by your instructors.</span>
        </a>
        <a class="student-quick-card" href="assignmentsubmit.php">
            <strong>Submit Work</strong>
            <span>Open the upload form for assignments assigned to your class.</span>
        </a>
        <a class="student-quick-card" href="viewgradeallv.php">
            <strong>Grade Report</strong>
            <span>Review approved semester grades and cumulative performance.</span>
        </a>
        <a class="student-quick-card" href="viewcourseresult.php">
            <strong>Course Results</strong>
            <span>See posted course-result rows for your current record.</span>
        </a>
        <a class="student-quick-card" href="usernotification.php">
            <strong>Notifications</strong>
            <span>Read unread messages and respond directly to instructors.</span>
        </a>
    </section>
</div>
<?php
studentRenderPageEnd();
?>
