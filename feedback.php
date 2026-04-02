<?php
session_start();
ob_start();
require_once("connection.php");

$status = trim((string) ($_GET['status'] ?? ''));
$statusMessages = array(
    'success' => array('class' => 'is-success', 'message' => 'Your feedback was sent successfully.'),
    'error' => array('class' => 'is-error', 'message' => 'The feedback could not be saved. Please try again.'),
    'invalid' => array('class' => 'is-info', 'message' => 'Please complete all feedback fields correctly before sending.')
);

function feedbackH(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Feedback</title>
<link rel="stylesheet" href="setting.css">
<style>
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; min-width: 0; }
.main-row > #sidebar { flex: 0 0 260px !important; }
.feedback-shell {
    display: grid;
    gap: 20px;
}
.feedback-banner,
.feedback-hero,
.feedback-card,
.feedback-side-card {
    border-radius: 24px;
    box-shadow: 0 20px 42px rgba(11, 36, 61, 0.11);
}
.feedback-banner {
    padding: 16px 20px;
    font-weight: 700;
}
.feedback-banner.is-success {
    background: #ebf8ee;
    border: 1px solid #7dc48b;
    color: #155724;
}
.feedback-banner.is-error {
    background: #fff0f0;
    border: 1px solid #e0a3a3;
    color: #8d2525;
}
.feedback-banner.is-info {
    background: #eef6ff;
    border: 1px solid #9fc1e6;
    color: #19496f;
}
.feedback-hero {
    padding: 28px;
    background:
        radial-gradient(circle at top right, rgba(255, 255, 255, 0.22), transparent 30%),
        linear-gradient(135deg, #0a516b 0%, #0f7d84 100%);
    color: #f6feff;
}
.feedback-kicker {
    display: inline-flex;
    margin-bottom: 12px;
    padding: 6px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.16);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}
.feedback-hero h1 {
    margin: 0 0 12px;
    font-size: 34px;
    line-height: 1.1;
}
.feedback-hero p {
    margin: 0;
    max-width: 680px;
    color: rgba(246, 254, 255, 0.88);
    line-height: 1.7;
}
.feedback-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}
.feedback-card,
.feedback-side-card {
    padding: 28px;
    background: linear-gradient(180deg, #ffffff 0%, #f4faf9 100%);
    border: 1px solid rgba(149, 194, 196, 0.35);
}
.feedback-card h2,
.feedback-side-card h2 {
    margin: 0 0 10px;
    color: #13374a;
    font-size: 25px;
}
.feedback-card p,
.feedback-side-card p,
.feedback-side-card li {
    color: #365063;
    line-height: 1.7;
}
.feedback-form {
    display: grid;
    gap: 18px;
    margin-top: 18px;
}
.feedback-form-row {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}
.feedback-field {
    display: grid;
    gap: 8px;
}
.feedback-label {
    color: #163c50;
    font-size: 14px;
    font-weight: 700;
}
.feedback-input,
.feedback-textarea {
    width: 100%;
    border: 1px solid #c8dbe0;
    border-radius: 16px;
    background: #fcfeff;
    box-sizing: border-box;
    color: #16384d;
    font-size: 15px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}
.feedback-input {
    min-height: 52px;
    padding: 0 16px;
}
.feedback-textarea {
    min-height: 190px;
    padding: 14px 16px;
    resize: vertical;
}
.feedback-input:focus,
.feedback-textarea:focus {
    outline: none;
    border-color: #2c8b97;
    box-shadow: 0 0 0 4px rgba(44, 139, 151, 0.14);
    transform: translateY(-1px);
}
.feedback-note {
    margin: 0;
    color: #557282;
    font-size: 13px;
}
.feedback-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.feedback-button,
.feedback-button-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 50px;
    padding: 0 22px;
    border: 0;
    border-radius: 999px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 700;
    transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
}
.feedback-button {
    background: linear-gradient(135deg, #0f6c77 0%, #0e8b85 100%);
    color: #ffffff;
    box-shadow: 0 16px 30px rgba(15, 108, 119, 0.22);
}
.feedback-button-secondary {
    background: #eaf3f5;
    color: #1f4b63;
}
.feedback-button:hover,
.feedback-button-secondary:hover {
    transform: translateY(-1px);
}
.feedback-side-card ul {
    margin: 14px 0 0;
    padding-left: 18px;
}
.feedback-db-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 12px;
    padding: 10px 14px;
    border-radius: 999px;
    background: #e9f7f7;
    color: #0f6770;
    font-weight: 700;
}
@media (max-width: 1100px) {
    .main-row {
        flex-direction: column !important;
    }
    .main-row > #left,
    .main-row > #content,
    .main-row > #sidebar {
        flex: 1 1 auto !important;
        width: 100% !important;
    }
}
@media (max-width: 900px) {
    .feedback-grid,
    .feedback-form-row {
        grid-template-columns: 1fr;
    }
}
@media (max-width: 700px) {
    .feedback-hero,
    .feedback-card,
    .feedback-side-card,
    .feedback-banner {
        padding: 22px 18px;
    }
    .feedback-hero h1,
    .feedback-card h2,
    .feedback-side-card h2 {
        font-size: 26px;
    }
    .feedback-actions {
        flex-direction: column;
    }
    .feedback-button,
    .feedback-button-secondary {
        width: 100%;
    }
}
</style>
<script src="javascript/date_time.js"></script>
</head>
<body class="student-portal-page">

<div id="container">
    <div id="header">
         <?php require("header.php"); ?>
    </div>

    <div id="menu">
        <?php require("menu.php"); ?>
    </div>

    <div class="main-row">
        <div id="left">
            <?php include("left.php"); ?>
        </div>

        <div id="content">
            <div class="feedback-shell">
                <?php if (isset($statusMessages[$status])) { ?>
                <div class="feedback-banner <?php echo feedbackH($statusMessages[$status]['class']); ?>">
                    <?php echo feedbackH($statusMessages[$status]['message']); ?>
                </div>
                <?php } ?>

                <div class="feedback-grid">
                    <section class="feedback-card">
                        <h2>Send Feedback</h2>
                        <p>Share bugs, suggestions, or general comments about the distance education portal. We keep the form simple and validate the data before it is saved.</p>

                        <form action="1.php" method="post" class="feedback-form">
                            <input type="hidden" name="ut" value="guest">

                            <div class="feedback-form-row">
                                <div class="feedback-field">
                                    <label class="feedback-label" for="faname">Full Name</label>
                                    <input class="feedback-input" type="text" name="faname" id="faname" required maxlength="50" placeholder="Your name" pattern="[A-Za-z .'-]+">
                                </div>

                                <div class="feedback-field">
                                    <label class="feedback-label" for="email">Email Address</label>
                                    <input class="feedback-input" type="email" name="em" id="email" required maxlength="100" placeholder="you@example.com">
                                </div>
                            </div>

                            <div class="feedback-field">
                                <label class="feedback-label" for="feedback-message">Comment</label>
                                <textarea class="feedback-textarea" name="feedback" id="feedback-message" required minlength="10" maxlength="10000" placeholder="Write your feedback here"></textarea>
                                <p class="feedback-note">Please use at least 10 characters so your message has enough detail to help the team.</p>
                            </div>

                            <div class="feedback-actions">
                                <button class="feedback-button" type="submit" name="submit">Send Feedback</button>
                                <button class="feedback-button-secondary" type="reset" name="clear">Clear Form</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>

        <div id="sidebar">
            <?php require("leftlogin.php"); ?>
            <div class="sidebar-panel social-panel">
                <div class="sidebar-panel-title">Social link</div>
                <div class="sidebar-panel-body">
                    <a href="https://www.facebook.com/"><span><ion-icon name="logo-facebook"></ion-icon></span>Facebook</a>
                    <a href="https://www.twitter.com/"><span><ion-icon name="logo-twitter"></ion-icon></span>Twitter</a>
                    <a href="https://www.youtube.com/"><span><ion-icon name="logo-youtube"></ion-icon></span>YouTube</a>
                    <a href="https://plus.google.com/"><span><ion-icon name="logo-google"></ion-icon></span>Google++</a>
                </div>
            </div>
        </div>
    </div>

    <div id="footer">
        <?php include("footer.php"); ?>
    </div>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
