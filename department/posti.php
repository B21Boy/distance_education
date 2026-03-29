<?php
session_start();
require_once(__DIR__ . '/../connection.php');
require_once(__DIR__ . '/page_helpers.php');

function departmentReadDocxContent(string $filename): string
{
    if ($filename === '' || !file_exists($filename) || !class_exists('ZipArchive')) {
        return '';
    }

    $zip = new ZipArchive();
    if ($zip->open($filename) !== true) {
        return '';
    }

    $content = $zip->getFromName('word/document.xml') ?: '';
    $zip->close();

    if ($content === '') {
        return '';
    }

    $content = str_replace('</w:r></w:p></w:tc><w:tc>', ' ', $content);
    $content = str_replace('</w:r></w:p>', PHP_EOL, $content);
    return trim(strip_tags($content));
}

if (!departmentIsLoggedIn()) {
    http_response_code(403);
    ?>
    <style>
    .department-notice-popup-shell {
        width: min(100%, 760px);
        margin: 0 auto;
        font-family: Arial, Helvetica, sans-serif;
    }
    .department-notice-popup-alert {
        padding: 18px 20px;
        border: 1px solid #e4b2b2;
        border-radius: 18px;
        background: #fff5f5;
        color: #8f1f1f;
        font-weight: 700;
        line-height: 1.6;
    }
    </style>
    <div class="department-notice-popup-shell">
        <div class="department-notice-popup-alert">Your session has expired. Please sign in again.</div>
    </div>
    <?php
    exit;
}

$date = date('Y-m-d');
$defaultInfo = departmentReadDocxContent(__DIR__ . '/postu.docx');
$departmentName = departmentCurrentDepartmentName($conn);
$defaultPostedBy = $departmentName !== '' ? $departmentName : 'Department Office';
?>
<style>
#facebox .popup {
    border: none;
    border-radius: 28px;
    box-shadow: 0 28px 72px rgba(15, 23, 42, 0.24);
}

#facebox .content {
    display: block;
    width: 760px;
    max-width: calc(100vw - 32px);
    padding: 0;
    border-radius: 28px;
    background: transparent;
    overflow: hidden;
}

#facebox .close {
    top: 16px;
    right: 16px;
    width: 38px;
    height: 38px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.96);
    border: 1px solid rgba(148, 163, 184, 0.28);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.12);
}

#facebox .close img {
    display: none;
}

#facebox .close::before {
    content: "x";
    color: #34506b;
    font-size: 24px;
    line-height: 1;
}

#facebox_overlay.facebox_overlayBG {
    background: rgba(15, 23, 42, 0.66);
    backdrop-filter: blur(4px);
}

.department-notice-popup-shell {
    width: min(100%, 760px);
    margin: 0 auto;
    font-family: Arial, Helvetica, sans-serif;
    color: #17324d;
}

.department-notice-popup-card {
    background: linear-gradient(180deg, #ffffff 0%, #f6fbff 100%);
}

.department-notice-popup-header {
    padding: 30px 30px 22px;
    background: linear-gradient(135deg, #0f3c68 0%, #1f6aa5 58%, #64a6d8 100%);
    color: #ffffff;
}

.department-notice-popup-eyebrow {
    display: inline-flex;
    align-items: center;
    padding: 7px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.16);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.department-notice-popup-header h2 {
    margin: 14px 0 10px;
    font-size: 28px;
    line-height: 1.2;
}

.department-notice-popup-header p {
    margin: 0;
    color: rgba(255, 255, 255, 0.88);
    font-size: 15px;
    line-height: 1.7;
}

.department-notice-popup-body {
    padding: 28px 30px 30px;
}

.department-notice-popup-summary {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}

.department-notice-popup-summary-card {
    padding: 16px 18px;
    border: 1px solid #dbe7f2;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
}

.department-notice-popup-summary-label {
    color: #66809b;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.department-notice-popup-summary-value {
    margin-top: 8px;
    color: #17324d;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.6;
    word-break: break-word;
}

.department-notice-popup-form {
    display: grid;
    gap: 18px;
}

.department-notice-popup-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 20px;
}

.department-notice-popup-field {
    display: grid;
    gap: 8px;
}

.department-notice-popup-field.full {
    grid-column: 1 / -1;
}

.department-notice-popup-field label {
    color: #234766;
    font-size: 14px;
    font-weight: 700;
}

.department-notice-popup-field input,
.department-notice-popup-field textarea {
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #cfdceb;
    border-radius: 14px;
    background: #ffffff;
    color: #17324d;
    font-size: 14px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.department-notice-popup-field input {
    min-height: 48px;
    padding: 0 15px;
}

.department-notice-popup-field textarea {
    min-height: 220px;
    padding: 14px 15px;
    resize: vertical;
    line-height: 1.75;
}

.department-notice-popup-field input[readonly] {
    background: #f3f7fb;
    color: #617b95;
}

.department-notice-popup-field input:focus,
.department-notice-popup-field textarea:focus {
    outline: none;
    border-color: #2e78cb;
    box-shadow: 0 0 0 4px rgba(46, 120, 203, 0.12);
}

.department-notice-popup-help {
    color: #6a8197;
    font-size: 13px;
    line-height: 1.6;
}

.department-notice-popup-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.department-notice-popup-actions button {
    min-height: 48px;
    padding: 0 20px;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
}

.department-notice-popup-actions .is-primary {
    background: linear-gradient(135deg, #1f5fb6 0%, #2e84dd 100%);
    color: #ffffff;
    box-shadow: 0 14px 28px rgba(31, 95, 182, 0.24);
}

.department-notice-popup-actions .is-secondary {
    background: #eaf1f7;
    color: #24425f;
}

@media (max-width: 760px) {
    #facebox .content {
        max-width: calc(100vw - 20px);
    }

    .department-notice-popup-header,
    .department-notice-popup-body {
        padding-left: 20px;
        padding-right: 20px;
    }

    .department-notice-popup-summary,
    .department-notice-popup-grid {
        grid-template-columns: 1fr;
    }

    .department-notice-popup-actions button {
        width: 100%;
    }
}
</style>

<div class="department-notice-popup-shell">
    <div class="department-notice-popup-card">
        <div class="department-notice-popup-header">
            <span class="department-notice-popup-eyebrow">Post Notice</span>
            <h2>Publish Department Update</h2>
            <p>Create and publish a new department notice from this modern popup form. The notice will be saved to the database and shown on the notice page after submission.</p>
        </div>

        <div class="department-notice-popup-body">
            <div class="department-notice-popup-summary">
                <div class="department-notice-popup-summary-card">
                    <div class="department-notice-popup-summary-label">Notice Date</div>
                    <div class="department-notice-popup-summary-value"><?php echo departmentH($date); ?></div>
                </div>
                <div class="department-notice-popup-summary-card">
                    <div class="department-notice-popup-summary-label">Posted By</div>
                    <div class="department-notice-popup-summary-value"><?php echo departmentH($defaultPostedBy); ?></div>
                </div>
            </div>

            <form action="postedu.php" method="post" class="department-notice-popup-form">
                <div class="department-notice-popup-grid">
                    <div class="department-notice-popup-field">
                        <label for="notice-title">Title</label>
                        <input type="text" id="notice-title" name="title" value="ማስታወቂያ" required>
                    </div>

                    <div class="department-notice-popup-field">
                        <label for="notice-type">Type</label>
                        <input type="text" id="notice-type" name="typ" value="ለርቀት ትምህርት መርሃ-ግብር ተማሪዎች በሙሉ" required>
                    </div>

                    <div class="department-notice-popup-field full">
                        <label for="notice-info">Information</label>
                        <textarea id="notice-info" name="infor" required><?php echo departmentH($defaultInfo); ?></textarea>
                        <div class="department-notice-popup-help">Edit the notice content before posting. The saved notice will appear in the department notices list.</div>
                    </div>

                    <div class="department-notice-popup-field">
                        <label for="notice-date">Date</label>
                        <input type="text" id="notice-date" name="date" value="<?php echo departmentH($date); ?>" readonly>
                    </div>

                    <div class="department-notice-popup-field">
                        <label for="notice-expire-date">Expire Date</label>
                        <input type="date" id="notice-expire-date" name="edate">
                    </div>

                    <div class="department-notice-popup-field full">
                        <label for="notice-posted-by">Posted By</label>
                        <input type="text" id="notice-posted-by" name="pb" value="<?php echo departmentH($defaultPostedBy); ?>" required>
                    </div>
                </div>

                <div class="department-notice-popup-actions">
                    <button type="submit" name="sent" class="is-primary">Post Notice</button>
                    <button type="reset" class="is-secondary">Reset Form</button>
                </div>
            </form>
        </div>
    </div>
</div>
