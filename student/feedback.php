<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$status = trim((string) ($_GET['status'] ?? ''));
$statusMessages = array(
    'success' => array('class' => 'success', 'message' => 'Your feedback was sent successfully.'),
    'error' => array('class' => 'error', 'message' => 'The feedback could not be saved. Please try again.'),
    'invalid' => array('class' => 'info', 'message' => 'Please complete all required feedback fields correctly before submitting.')
);

$fullName = studentCurrentFullName();

studentRenderPageStart(
    "Feedback",
    "Feedback",
    "Send Feedback",
    "Use this form to send platform feedback from your student account. The submission is saved directly into the feedback table through the shared database connection."
);
?>
<?php if (isset($statusMessages[$status])) { ?>
    <div class="student-status-banner <?php echo studentH($statusMessages[$status]['class']); ?>">
        <?php echo studentH($statusMessages[$status]['message']); ?>
    </div>
<?php } ?>

<fieldset>
    <legend>Feedback Form</legend>
    <form action="1.php" method="post" class="student-form-grid two-col">
        <input type="hidden" name="ut" value="student">
        <div class="student-form-field">
            <label class="student-label" for="feedback-name">Name</label>
            <input type="text" id="feedback-name" name="faname" value="<?php echo studentH($fullName); ?>" required>
        </div>
        <div class="student-form-field">
            <label class="student-label" for="feedback-email">Email</label>
            <input type="email" id="feedback-email" name="em" required>
        </div>
        <div class="student-form-field full">
            <label class="student-label" for="feedback-message">Comment</label>
            <textarea id="feedback-message" name="feedback" rows="8" required minlength="10" placeholder="Write your feedback here"></textarea>
            <p class="student-form-note">Feedback should be at least 10 characters long.</p>
        </div>
        <div class="student-form-field">
            <label class="student-label">&nbsp;</label>
            <input type="submit" name="submit" value="Send Feedback">
        </div>
        <div class="student-form-field">
            <label class="student-label">&nbsp;</label>
            <input type="reset" name="clear" value="Clear Form">
        </div>
    </form>
</fieldset>
<?php
studentRenderPageEnd();
?>
