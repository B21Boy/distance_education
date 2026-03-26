<?php
include("../connection.php");
session_start();
require("popup_styles.php");
?>
<div class="cde-popup-card">
    <div class="cde-popup-header">
        <span class="cde-popup-kicker">CDE Officer</span>
        <h1 class="cde-popup-title">Add College</h1>
        <p class="cde-popup-copy">Register a new college by filling in the code, name, and location fields.</p>
    </div>
    <form action="registercollage.php" method="POST" name="form1" enctype="multipart/form-data" class="cde-popup-form">
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="cc">
                College Code
                <input type="text" name="cc" id="cc" class="cde-popup-input" required placeholder="College code">
            </label>
            <label class="cde-popup-field" for="cn">
                College Name
                <input type="text" name="cn" id="cn" class="cde-popup-input" required placeholder="College name">
            </label>
        </div>
        <label class="cde-popup-field" for="loc">
            Location
            <input type="text" name="loc" id="loc" class="cde-popup-input" required placeholder="Enter location">
        </label>
        <div class="cde-popup-actions">
            <button type="submit" id="submit" name="submit" class="cde-popup-btn">Register</button>
            <button type="reset" name="validation" class="cde-popup-btn-secondary">Cancel</button>
        </div>
    </form>
</div>
