<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("connection.php");

$error = "";

function normalize_login_role(string $role): string
{
    $normalized = strtolower(trim($role));
    $normalized = str_replace(array('-', ' '), '_', $normalized);

    $aliases = array(
        'admin' => 'administrator',
        'administrator' => 'administrator',
        'system_admin' => 'administrator',
        'cde_officer' => 'cdeofficer',
        'cdeofficer' => 'cdeofficer',
        'registrar' => 'registrar',
        'department_head' => 'department_head',
        'dept_head' => 'department_head',
        'instructor' => 'instructor',
        'student' => 'student',
        'finance_staff' => 'financestaff',
        'finance' => 'financestaff',
        'financestaff' => 'financestaff',
        'collage_dean' => 'collage_dean',
        'college_dean' => 'collage_dean',
        'acadamic_vice_presid' => 'acadamic_vice_presidant',
        'acadamic_vice_presidant' => 'acadamic_vice_presidant',
        'academic_vice_president' => 'acadamic_vice_presidant',
        'academic_vice_presidant' => 'acadamic_vice_presidant',
        'vice_president' => 'acadamic_vice_presidant',
        'vice_presidant' => 'acadamic_vice_presidant',
        'directorat' => 'directorat',
        'directorate' => 'directorat',
        'director' => 'directorat',
    );

    return isset($aliases[$normalized]) ? $aliases[$normalized] : $normalized;
}

function login_dashboard_route(string $role): string
{
    $roleKey = normalize_login_role($role);

    $routes = array(
        'administrator' => 'admin/adminhomepage.php',
        'registrar' => 'registrar/registrarpage.php',
        'department_head' => 'department/deptheadpage.php',
        'instructor' => 'instructor/instructorpage.php',
        'student' => 'student/studentpage.php',
        'cdeofficer' => 'cdeofficer/cdeofficerpage.php',
        'financestaff' => 'finance/financestafpage.php',
        'collage_dean' => 'collage/financestafpage.php',
        'acadamic_vice_presidant' => 'vice_presidant/vicepage.php',
        // The project has no dedicated directorat dashboard directory.
        'directorat' => 'vice_presidant/vicepage.php',
    );

    return isset($routes[$roleKey]) ? $routes[$roleKey] : '';
}

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
            $_SESSION['srole_key'] = normalize_login_role((string) $row["Role"]);
            $_SESSION['login_time'] = date("H:i:s");

            $uid = $row["UID"];
            $user_sql = "SELECT fname, lname, photo, d_code, c_code FROM user WHERE UID = ?";
            if ($user_stmt = $conn->prepare($user_sql)) {
                $user_stmt->bind_param("s", $uid);
                $user_stmt->execute();
                $user_result = $user_stmt->get_result();
                if ($user_row = $user_result->fetch_assoc()) {
                    $_SESSION['sfn'] = $user_row['fname'];
                    $_SESSION['sln'] = $user_row['lname'];
                    $_SESSION['sphoto'] = $user_row['photo'];
                    $_SESSION['sdc'] = isset($user_row['d_code']) ? (string) $user_row['d_code'] : "";
                    $_SESSION['sdcode'] = isset($user_row['d_code']) ? (string) $user_row['d_code'] : "";
                    $_SESSION['sccode'] = isset($user_row['c_code']) ? (string) $user_row['c_code'] : "";
                } else {
                    $_SESSION['sfn'] = "";
                    $_SESSION['sln'] = "";
                    $_SESSION['sphoto'] = "";
                    $_SESSION['sdc'] = "";
                    $_SESSION['sdcode'] = "";
                    $_SESSION['sccode'] = "";
                }
            }

            if (ob_get_length()) {
                ob_end_clean();
            }

            $route = login_dashboard_route((string) $row["Role"]);
            if ($route !== '' && file_exists(__DIR__ . '/' . $route)) {
                header("Location: " . $route);
                exit();
            }

            $error = "This account role does not have a valid dashboard route yet.";
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
