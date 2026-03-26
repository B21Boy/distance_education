<?php
if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once("../connection.php");
}

function registrarIsLoggedIn(): bool
{
    return isset($_SESSION['sun'], $_SESSION['spw'], $_SESSION['sfn'], $_SESSION['sln'], $_SESSION['srole']);
}

function registrarCurrentUserId(): string
{
    return isset($_SESSION['suid']) ? trim((string) $_SESSION['suid']) : '';
}

function registrarCurrentPhotoPath(): string
{
    $photo = isset($_SESSION['sphoto']) ? trim((string) $_SESSION['sphoto']) : '';
    return $photo !== '' ? $photo : '../images/default.png';
}

function registrarH($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function registrarFetchDepartments(mysqli $conn): array
{
    $result = mysqli_query($conn, "SELECT DName FROM department WHERE DName <> '' ORDER BY DName ASC");
    if (!$result instanceof mysqli_result) {
        return [];
    }

    $departments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $name = trim((string) ($row['DName'] ?? ''));
        if ($name !== '') {
            $departments[] = $name;
        }
    }
    mysqli_free_result($result);
    return $departments;
}

function registrarFetchUnreadMessages(mysqli $conn, string $userId): array
{
    if ($userId === '') {
        return [];
    }

    $sql = "SELECT m.M_ID, m.M_sender, m.message, m.date_sended,
                   COALESCE(NULLIF(TRIM(CONCAT_WS(' ', u.fname, u.lname)), ''), m.M_sender) AS sender_name
            FROM message m
            LEFT JOIN user u ON u.UID = m.M_sender
            WHERE m.M_reciever = ? AND m.status = 'no'
            ORDER BY m.date_sended DESC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function registrarRenderStandardStyles(): void
{
    ?>
    <style>
    .registrar-page-card {
        width: 100%;
        margin: 18px 0;
        padding: 30px 32px;
        background: linear-gradient(180deg, #ffffff 0%, #f4f8ff 100%);
        border: 1px solid #d7e2f1;
        border-radius: 20px;
        box-shadow: 0 18px 40px rgba(32, 71, 126, 0.12);
        box-sizing: border-box;
    }
    .registrar-page-header {
        margin-bottom: 24px;
    }
    .registrar-page-eyebrow {
        display: inline-block;
        margin-bottom: 10px;
        padding: 5px 12px;
        border-radius: 999px;
        background: #dbeafb;
        color: #174a7c;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .registrar-page-title {
        margin: 0;
        color: #163b67;
        font-size: 30px;
        line-height: 1.2;
    }
    .registrar-page-copy {
        margin: 10px 0 0;
        max-width: 760px;
        color: #566b86;
        font-size: 15px;
        line-height: 1.7;
    }
    .registrar-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 20px;
    }
    .registrar-form-field {
        display: grid;
        gap: 10px;
    }
    .registrar-form-field.full {
        grid-column: 1 / -1;
    }
    .registrar-label {
        color: #17324d;
        font-size: 15px;
        font-weight: 700;
    }
    .registrar-input,
    .registrar-select,
    .registrar-textarea {
        width: 100%;
        min-height: 46px;
        padding: 0 14px;
        border: 1px solid #bfd0e6;
        border-radius: 12px;
        background: #fbfdff;
        color: #20354d;
        font-size: 15px;
        box-sizing: border-box;
        transition: border-color 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
    }
    .registrar-textarea {
        min-height: 140px;
        padding: 14px 16px;
        resize: vertical;
    }
    .registrar-input:focus,
    .registrar-select:focus,
    .registrar-textarea:focus {
        outline: none;
        border-color: #2c74c9;
        box-shadow: 0 0 0 4px rgba(44, 116, 201, 0.12);
        background: #ffffff;
    }
    .registrar-file-input {
        display: block;
        width: 100%;
        padding: 16px;
        border: 2px dashed #8aa9d6;
        border-radius: 14px;
        background: #f8fbff;
        color: #29476b;
        box-sizing: border-box;
    }
    .registrar-file-input::file-selector-button,
    .registrar-file-input::-webkit-file-upload-button {
        margin-right: 14px;
        padding: 10px 18px;
        border: none;
        border-radius: 10px;
        background: #1f5fbf;
        color: #ffffff;
        font-weight: 700;
        cursor: pointer;
    }
    .registrar-form-note {
        margin-top: 10px;
        color: #667a93;
        font-size: 13px;
        line-height: 1.6;
    }
    .registrar-actions,
    .registrar-page-toolbar {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        align-items: center;
    }
    .registrar-page-toolbar {
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .registrar-btn,
    .registrar-btn-secondary,
    .registrar-link-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: 0 20px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        box-sizing: border-box;
    }
    .registrar-btn {
        border: none;
        background: linear-gradient(135deg, #215fb8 0%, #2f86de 100%);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(33, 95, 184, 0.22);
    }
    .registrar-btn-secondary {
        border: 1px solid #cdd8e7;
        background: #e9eef5;
        color: #27415f;
    }
    .registrar-link-btn {
        border: 1px solid #d5e2ef;
        background: #edf4fb;
        color: #18466f;
    }
    .registrar-btn:hover,
    .registrar-btn-secondary:hover,
    .registrar-link-btn:hover {
        transform: translateY(-1px);
    }
    .registrar-status {
        margin-bottom: 18px;
        padding: 14px 16px;
        border-radius: 14px;
        font-weight: 700;
        line-height: 1.6;
    }
    .registrar-status.success {
        background: #e8f7ea;
        border: 1px solid #8ac795;
        color: #1b5e20;
    }
    .registrar-status.error {
        background: #fdeaea;
        border: 1px solid #de9b9b;
        color: #8a1f1f;
    }
    .registrar-status.info {
        background: #eef6ff;
        border: 1px solid #a9c8ee;
        color: #1e4d87;
    }
    .registrar-inline-note {
        color: #4a6480;
        font-size: 14px;
    }
    .registrar-message-list {
        display: grid;
        gap: 16px;
    }
    .registrar-message-item {
        padding: 20px;
        border: 1px solid #dbe5f0;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 12px 26px rgba(17, 52, 84, 0.08);
    }
    .registrar-message-meta {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }
    .registrar-message-sender {
        color: #163b60;
        font-size: 16px;
        font-weight: 700;
    }
    .registrar-message-date {
        color: #5f7590;
        font-size: 13px;
    }
    .registrar-message-body {
        margin: 0 0 16px;
        color: #334c66;
        line-height: 1.7;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .registrar-empty {
        padding: 18px 20px;
        border-radius: 14px;
        background: #f8fbff;
        border: 1px dashed #bfd0e2;
        color: #48637f;
    }
    @media (max-width: 760px) {
        .registrar-page-card {
            padding: 22px 18px;
        }
        .registrar-form-grid {
            grid-template-columns: 1fr;
        }
        .registrar-actions,
        .registrar-page-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        .registrar-btn,
        .registrar-btn-secondary,
        .registrar-link-btn {
            width: 100%;
        }
    }
    </style>
    <?php
}

function registrarRenderSidebar(string $photoPath): void
{
    ?>
    <div class="sidebar-panel profile-panel">
        <div class="sidebar-panel-title">User Profile</div>
        <div class="sidebar-panel-body">
            <div class="registrar-inline-note"><strong>Welcome:</strong> <?php echo registrarH(($_SESSION['sfn'] ?? '') . ' ' . ($_SESSION['sln'] ?? '')); ?></div>
            <img src="<?php echo registrarH($photoPath); ?>" alt="Registrar profile photo">
            <div id="sidebarr">
                <ul>
                    <li><a href="#.html">Change Photo</a></li>
                    <li><a href="changepass.php">Change password</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="sidebar-panel social-panel">
        <div class="sidebar-panel-title">Social Link</div>
        <div class="sidebar-panel-body">
            <a href="https://www.facebook.com/"><span><ion-icon name="logo-facebook"></ion-icon></span>Facebook</a>
            <a href="https://www.twitter.com/"><span><ion-icon name="logo-twitter"></ion-icon></span>Twitter</a>
            <a href="https://www.youtube.com/"><span><ion-icon name="logo-youtube"></ion-icon></span>YouTube</a>
            <a href="https://plus.google.com/"><span><ion-icon name="logo-google"></ion-icon></span>Google++</a>
        </div>
    </div>
    <?php
}

function registrarRenderIconScripts(): void
{
    ?>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <?php
}
?>
