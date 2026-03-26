<?php
include("../connection.php");
require("popup_styles.php");

$colleges = array();
$d_program = mysql_query("SELECT * FROM collage");
while ($getDprog = mysql_fetch_array($d_program)) {
    $colleges[] = $getDprog['Ccode'];
}
?>
<div class="cde-popup-card">
    <div class="cde-popup-header">
        <span class="cde-popup-kicker">CDE Officer</span>
        <h1 class="cde-popup-title">Add Department</h1>
        <p class="cde-popup-copy">Register a department and assign it to the correct college code.</p>
    </div>
    <form action="registerdept.php" method="POST" name="form1" enctype="multipart/form-data" class="cde-popup-form">
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="dc">
                Department Code
                <input type="text" name="dc" id="dc" class="cde-popup-input" required placeholder="Department code">
            </label>
            <label class="cde-popup-field" for="dn">
                Department Name
                <input type="text" name="dn" id="dn" class="cde-popup-input" required placeholder="Department name">
            </label>
        </div>
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="loc">
                Location
                <input type="text" name="loc" id="loc" class="cde-popup-input" required placeholder="Enter location">
            </label>
            <label class="cde-popup-field" for="cc">
                College Code
                <select name="cc" id="cc" class="cde-popup-select" required>
                    <option value="">--Choose college code--</option>
                    <?php foreach ($colleges as $college_code) { ?>
                    <option value="<?php echo htmlspecialchars($college_code, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($college_code, ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php } ?>
                </select>
            </label>
        </div>
        <div class="cde-popup-actions">
            <button type="submit" id="submit" name="submit" class="cde-popup-btn">Register</button>
            <button type="reset" name="validation" class="cde-popup-btn-secondary">Cancel</button>
        </div>
    </form>
</div>
