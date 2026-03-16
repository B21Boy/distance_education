<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("connection.php");

$error = "";

if (isset($_POST["login"])) {
    $un = trim($_POST["un"]);
    $pass = trim($_POST["pass"]);

    $sql = "SELECT * FROM account WHERE UserName=? AND Password=? AND status='yes'";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $un, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $_SESSION['suid'] = $row["UID"];
            $_SESSION['sun'] = $row["UserName"];
            $_SESSION['spw'] = $row["Password"];
            $_SESSION['srole'] = $row["Role"];
            $_SESSION['login_time'] = date("H:i:s");

            $uid = $row["UID"];
            $user_sql = "SELECT fname, lname, photo FROM user WHERE UID = ?";
            if ($user_stmt = $conn->prepare($user_sql)) {
                $user_stmt->bind_param("s", $uid);
                $user_stmt->execute();
                $user_result = $user_stmt->get_result();
                if ($user_row = $user_result->fetch_assoc()) {
                    $_SESSION['sfn'] = $user_row['fname'];
                    $_SESSION['sln'] = $user_row['lname'];
                    $_SESSION['sphoto'] = $user_row['photo'];
                } else {
                    $_SESSION['sfn'] = "";
                    $_SESSION['sln'] = "";
                    $_SESSION['sphoto'] = "";
                }
            }

            if (ob_get_length()) {
                ob_end_clean();
            }

            switch ($row["Role"]) {
                case "administrator":
                    header("Location: admin/adminhomepage.php");
                    exit();
                case "registrar":
                    header("Location: registrar/registrarpage.php");
                    exit();
                case "department_head":
                    header("Location: department/deptheadpage.php");
                    exit();
                case "instructor":
                    header("Location: instructor/instructorpage.php");
                    exit();
                case "student":
                    header("Location: student/studentpage.php");
                    exit();
                case "cdeofficer":
                    header("Location: cdeofficer/cdeofficerpage.php");
                    exit();
                case "financestaff":
                    header("Location: finance/financestafpage.php");
                    exit();
                case "collage_dean":
                    header("Location: collage/financestafpage.php");
                    exit();
                case "acadamic_vice_presid":
                    header("Location: vice_presidant/vicepage.php");
                    exit();
                case "directorat":
                    header("Location: directorat/directorpage.php");
                    exit();
                default:
                    $error = "Unknown role type.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Login temporarily unavailable.";
    }
}
?>

<div class="sidebar-panel login-panel">
    <div class="sidebar-panel-title">User Login</div>
    <div class="sidebar-panel-body">
        <form method="post" class="login-form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="un" placeholder="Username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="pass" placeholder="Password" required>

            <div class="login-actions">
                <button type="submit" name="login">Login</button>
                <button type="reset">Reset</button>
            </div>
        </form>
        <?php if ($error): ?>
            <div class="login-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <div class="login-forgot">
            <a href="forgot.php">Forgot your password? Click Here!</a>
        </div>
    </div>
</div>
