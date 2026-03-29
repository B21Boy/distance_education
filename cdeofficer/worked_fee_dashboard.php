<?php
if (!function_exists('cdeofficer_safe_count')) {
    function cdeofficer_safe_count(mysqli $conn, string $sql): int
    {
        $result = mysqli_query($conn, $sql);
        if ($result instanceof mysqli_result) {
            $count = mysqli_num_rows($result);
            mysqli_free_result($result);
            return $count;
        }

        return 0;
    }
}

if (!isset($conn)) {
    require_once("../connection.php");
}

$tutorialCount = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='tutorial'");
$iexamCount = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='iexam'");
$mexamAssignCount = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='mexamassign'");
$massignmentCount = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='massignment'");
$mexamCount = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='mexam'");
$pexamCount = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='pexam'");

$dashboardItems = [
    [
        'label' => 'Tutorial',
        'title' => 'Offering Tutorial Program',
        'description' => 'Review tutorial program offering requests and respond quickly.',
        'count' => $tutorialCount,
        'href' => 'unreaddotutorial.php',
        'accent' => 'accent-blue',
    ],
    [
        'label' => 'Final Exam',
        'title' => 'Invigilating Final Exam',
        'description' => 'Check new invigilation requests for final examinations.',
        'count' => $iexamCount,
        'href' => 'unreaddifexam.php',
        'accent' => 'accent-green',
    ],
    [
        'label' => 'Exam + Assignment',
        'title' => 'Marking Exam and Assignment',
        'description' => 'Track combined marking requests that need immediate attention.',
        'count' => $mexamAssignCount,
        'href' => 'unreaddmexamassgin.php',
        'accent' => 'accent-gold',
    ],
    [
        'label' => 'Assignment',
        'title' => 'Marking Assignment',
        'description' => 'View assignment marking requests waiting for action.',
        'count' => $massignmentCount,
        'href' => 'unreaddmassignment.php',
        'accent' => 'accent-orange',
    ],
    [
        'label' => 'Exam Marking',
        'title' => 'Marking Exam',
        'description' => 'Open the latest exam marking requests from instructors.',
        'count' => $mexamCount,
        'href' => 'unreaddmexam.php',
        'accent' => 'accent-purple',
    ],
    [
        'label' => 'Prepare Exam',
        'title' => 'Preparing Exam',
        'description' => 'Manage new exam preparation requests from the dashboard.',
        'count' => $pexamCount,
        'href' => 'unreaddpexam.php',
        'accent' => 'accent-teal',
    ],
];
?>
<style>
.cde-dashboard {
    width: 100%;
    max-width: 1320px;
    margin: 0 auto;
}
.cde-dashboard-hero {
    margin-bottom: 20px;
    padding: 24px 28px;
    border: 1px solid #d8e3f1;
    border-radius: 18px;
    background: linear-gradient(135deg, #ffffff 0%, #eef5ff 100%);
    box-shadow: 0 16px 36px rgba(21, 58, 109, 0.10);
}
.cde-dashboard-title {
    margin: 0;
    color: #143861;
    font-size: 30px;
    line-height: 1.2;
}
.cde-dashboard-copy {
    margin: 10px 0 0;
    color: #5d7189;
    font-size: 15px;
}
.cde-dashboard-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 22px;
    width: 100%;
}
.cde-dashboard-card {
    display: flex;
    flex-direction: column;
    min-height: 250px;
    min-width: 0;
    border-radius: 18px;
    border: 1px solid #dbe5f1;
    background: #ffffff;
    box-shadow: 0 16px 34px rgba(26, 54, 93, 0.10);
    overflow: hidden;
}
.cde-dashboard-card-head {
    padding: 18px 20px 14px;
    border-bottom: 1px solid #ecf1f7;
}
.cde-dashboard-chip {
    display: inline-flex;
    align-items: center;
    padding: 6px 11px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: bold;
    letter-spacing: 0.02em;
    color: #ffffff;
}
.cde-dashboard-status {
    margin-top: 14px;
    color: #1e406a;
    font-size: 14px;
    font-weight: bold;
}
.cde-dashboard-card-title {
    margin: 14px 0 0;
    color: #143861;
    font-size: 23px;
    line-height: 1.3;
}
.cde-dashboard-card-body {
    display: flex;
    flex: 1 1 auto;
    flex-direction: column;
    justify-content: space-between;
    padding: 0 20px 20px;
}
.cde-dashboard-description {
    margin: 16px 0 22px;
    color: #60748c;
    font-size: 14px;
    line-height: 1.6;
}
.cde-dashboard-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 46px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: bold;
    color: #ffffff;
    transition: transform 0.18s ease, opacity 0.18s ease, box-shadow 0.18s ease;
}
.cde-dashboard-action:hover {
    text-decoration: none;
    transform: translateY(-1px);
    opacity: 0.96;
}
.cde-dashboard-card.accent-blue .cde-dashboard-chip,
.cde-dashboard-card.accent-blue .cde-dashboard-action {
    background: linear-gradient(135deg, #1f5fbf 0%, #2f86de 100%);
}
.cde-dashboard-card.accent-green .cde-dashboard-chip,
.cde-dashboard-card.accent-green .cde-dashboard-action {
    background: linear-gradient(135deg, #1f8f67 0%, #31b57d 100%);
}
.cde-dashboard-card.accent-gold .cde-dashboard-chip,
.cde-dashboard-card.accent-gold .cde-dashboard-action {
    background: linear-gradient(135deg, #b77a15 0%, #d7a53c 100%);
}
.cde-dashboard-card.accent-orange .cde-dashboard-chip,
.cde-dashboard-card.accent-orange .cde-dashboard-action {
    background: linear-gradient(135deg, #c46517 0%, #ee8f2f 100%);
}
.cde-dashboard-card.accent-purple .cde-dashboard-chip,
.cde-dashboard-card.accent-purple .cde-dashboard-action {
    background: linear-gradient(135deg, #6a4bc4 0%, #8a63e8 100%);
}
.cde-dashboard-card.accent-teal .cde-dashboard-chip,
.cde-dashboard-card.accent-teal .cde-dashboard-action {
    background: linear-gradient(135deg, #0e7a8a 0%, #21a7be 100%);
}
@media (max-width: 1250px) {
    .cde-dashboard-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
@media (max-width: 760px) {
    .cde-dashboard-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="cde-dashboard">
    <div class="cde-dashboard-hero">
        <h2 class="cde-dashboard-title">Calculate Employee Worked Fee</h2>
        <p class="cde-dashboard-copy">Review all incoming program, exam, and marking requests from this fee and worked-task dashboard.</p>
    </div>

    <div class="cde-dashboard-grid">
        <?php foreach ($dashboardItems as $item) { ?>
        <div class="cde-dashboard-card <?php echo $item['accent']; ?>">
            <div class="cde-dashboard-card-head">
                <span class="cde-dashboard-chip"><?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?></span>
                <div class="cde-dashboard-status">
                    <?php if ($item['count'] > 0) { ?>
                        New Request [<?php echo (int) $item['count']; ?>]
                    <?php } else { ?>
                        No new requests
                    <?php } ?>
                </div>
                <h3 class="cde-dashboard-card-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
            </div>
            <div class="cde-dashboard-card-body">
                <p class="cde-dashboard-description"><?php echo htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                <a class="cde-dashboard-action" href="<?php echo htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>">View Details</a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
