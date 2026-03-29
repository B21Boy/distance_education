<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photo_path = registrarCurrentPhotoPath();
$messages = registrarFetchUnreadMessages($conn, registrarCurrentUserId());
$status = isset($_GET['status']) ? trim((string) $_GET['status']) : '';
$status_message = '';
$status_class = 'info';
if ($status === 'sent') {
    $status_message = 'Your message was sent successfully.';
    $status_class = 'success';
} elseif ($status === 'replied') {
    $status_message = 'Your reply was sent successfully.';
    $status_class = 'success';
} elseif ($status === 'error') {
    $status_message = 'The message could not be sent. Please try again.';
    $status_class = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Registrar Officer Page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<?php registrarRenderStandardStyles(); ?>
<style>
.registrar-modal {
    position: fixed;
    inset: 0;
    z-index: 1400;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: rgba(12, 28, 48, 0.62);
    box-sizing: border-box;
}
.registrar-modal.is-open {
    display: flex;
}
.registrar-modal-panel {
    position: relative;
    width: min(840px, 100%);
    max-height: calc(100vh - 48px);
    overflow: auto;
    border-radius: 24px;
}
.registrar-modal-content {
    min-height: 120px;
}
.registrar-modal-close {
    position: absolute;
    top: 14px;
    right: 14px;
    z-index: 2;
    width: 42px;
    height: 42px;
    border: none;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.95);
    color: #15395f;
    font-size: 26px;
    line-height: 1;
    cursor: pointer;
    box-shadow: 0 10px 22px rgba(17, 42, 70, 0.16);
}
.registrar-modal-loading {
    padding: 32px 28px;
    border-radius: 20px;
    background: linear-gradient(180deg, #ffffff 0%, #f4f8ff 100%);
    border: 1px solid #d7e2f1;
    color: #24466b;
    font-size: 15px;
    font-weight: 700;
    box-shadow: 0 18px 40px rgba(32, 71, 126, 0.12);
}
.registrar-modal-content .registrar-page-card {
    margin: 0;
}
body.registrar-modal-open {
    overflow: hidden;
}
@media (max-width: 760px) {
    .registrar-modal {
        padding: 14px;
    }
    .registrar-modal-panel {
        max-height: calc(100vh - 28px);
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<div id="container">
<div id="header"><?php require("header.php"); ?></div>
<div id="menu"><?php require("menuro.php"); ?></div>
<div class="main-row">
    <div id="left"><?php require("sidemenuro.php"); ?></div>
    <div id="content">
        <div id="contentindex5">
            <div class="registrar-page-card">
                <div class="registrar-page-toolbar">
                    <div>
                        <span class="registrar-page-eyebrow">Messages</span>
                        <h1 class="registrar-page-title">View and Send Messages</h1>
                        <p class="registrar-page-copy">Review unread messages for the registrar account and reply directly from the message center.</p>
                    </div>
                    <a href="newnotification1.php" class="registrar-link-btn">New Message</a>
                </div>
                <?php if ($status_message !== ''): ?>
                    <div class="registrar-status <?php echo registrarH($status_class); ?>"><?php echo registrarH($status_message); ?></div>
                <?php endif; ?>
                <?php if (count($messages) > 0): ?>
                    <div class="registrar-message-list">
                        <?php foreach ($messages as $message): ?>
                            <div class="registrar-message-item">
                                <div class="registrar-message-meta">
                                    <div class="registrar-message-sender"><?php echo registrarH($message['sender_name'] ?? $message['M_sender'] ?? 'Unknown sender'); ?></div>
                                    <div class="registrar-message-date"><?php echo registrarH($message['date_sended'] ?? ''); ?></div>
                                </div>
                                <p class="registrar-message-body"><?php echo registrarH($message['message'] ?? ''); ?></p>
                                <a href="viewnotification1.php?M_ID=<?php echo urlencode((string) ($message['M_ID'] ?? '')); ?>" class="registrar-link-btn registrar-reply-trigger">Reply</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="registrar-empty">No new messages were found for your account.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="sidebar"><?php registrarRenderSidebar($photo_path); ?></div>
</div>
<div id="registrar-reply-modal" class="registrar-modal" aria-hidden="true">
    <div class="registrar-modal-panel" role="dialog" aria-modal="true" aria-labelledby="registrar-reply-modal-title">
        <button type="button" class="registrar-modal-close" id="registrar-reply-modal-close" aria-label="Close reply form">&times;</button>
        <div class="registrar-modal-content" id="registrar-reply-modal-content">
            <div class="registrar-modal-loading">Loading reply form...</div>
        </div>
    </div>
</div>
<div id="footer"><?php include("../footer.php"); ?></div>
</div>
<script>
(function () {
    var modal = document.getElementById('registrar-reply-modal');
    var modalContent = document.getElementById('registrar-reply-modal-content');
    var closeButton = document.getElementById('registrar-reply-modal-close');
    var triggers = document.querySelectorAll('.registrar-reply-trigger');

    if (!modal || !modalContent || !closeButton || !window.fetch) {
        return;
    }

    function openModal() {
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('registrar-modal-open');
    }

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('registrar-modal-open');
    }

    function setLoadingState(message) {
        modalContent.innerHTML = '<div class="registrar-modal-loading">' + message + '</div>';
    }

    triggers.forEach(function (trigger) {
        trigger.addEventListener('click', function (event) {
            event.preventDefault();
            openModal();
            setLoadingState('Loading reply form...');

            fetch(trigger.getAttribute('href'), {
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(function (response) {
                if (!response.ok) {
                    throw new Error('Unable to load the reply form.');
                }
                return response.text();
            }).then(function (html) {
                modalContent.innerHTML = html;
                var title = modalContent.querySelector('.registrar-page-title');
                if (title && !title.id) {
                    title.id = 'registrar-reply-modal-title';
                }
                var textarea = modalContent.querySelector('textarea[name="message"]');
                if (textarea) {
                    textarea.focus();
                }
            }).catch(function () {
                modalContent.innerHTML = '<div class="registrar-status error">The reply form could not be loaded. Please try again.</div>';
            });
        });
    });

    closeButton.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
            closeModal();
        }
    });
})();
</script>
<?php registrarRenderIconScripts(); ?>
</body>
</html>
