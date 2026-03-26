<?php
session_start();
include __DIR__ . '/../../connection.php';

// Check if session has data
if (!isset($_SESSION['username']) || !isset($_SESSION['phone_number'])) {
    header("Location: ../../onliner.php");
    exit;
}

$selectedCollege = $_GET['college'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Select College and Department</title>
<link rel="stylesheet" href="../online.css">
<style>
.register-shell {
    width: min(1180px, calc(100% - 32px));
    margin: 32px auto;
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(0, 0.9fr);
    gap: 20px;
}

.intro-panel,
.form-panel {
    background: var(--panel-bg);
    border: 1px solid var(--border);
    border-radius: 24px;
    box-shadow: 0 20px 40px rgba(12, 45, 65, 0.1);
}

.intro-panel {
    padding: 26px;
    background: linear-gradient(160deg, rgba(255,255,255,0.98), rgba(236,246,251,0.96));
}

.form-panel {
    padding: 20px;
}

.college-list,
.department-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 12px;
}
.college-card {
    border: 1px solid #ddd;
    padding: 16px;
    background: #fff;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s, box-shadow 0.3s;
    text-align: left;
}
.college-card:hover {
    background: #f8f9fa;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.college-card h4 {
    margin: 0 0 8px;
    font-size: 18px;
    color: var(--accent-dark);
}
.department-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.department-card {
    border: 1px solid #ddd;
    padding: 16px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: box-shadow 0.3s;
}
.department-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.department-card h4 {
    margin: 0 0 8px;
    font-size: 18px;
    color: var(--accent-dark);
}
.department-description {
    color: #666;
    font-size: 14px;
    line-height: 1.5;
    margin: 8px 0;
}
.department-card p {
    margin: 8px 0;
    font-weight: 600;
}
.department-card button {
    background: var(--accent);
    color: #fff;
    border: none;
    padding: 10px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}
.department-card button:hover {
    background: var(--accent-dark);
}
.page-description {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
    font-size: 16px;
    line-height: 1.6;
}
.page-description p {
    margin-bottom: 15px;
}
.page-description ol {
    margin-left: 20px;
    margin-bottom: 15px;
}
.page-description li {
    margin-bottom: 8px;
}
.page-description .note {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 4px;
    padding: 10px;
    color: #856404;
    font-weight: bold;
}
</style>
</head>
<body class="student-portal-page">
<main class="register-shell">

    <section class="intro-panel">
        <p class="eyebrow">Online Register Flow</p>
        <h1>Choose Your College & Department</h1>
        <p class="intro-copy">After OTP verification, select your college and then choose a department with semester fee option.</p>
        <div class="process-card">
            <h2>How it works</h2>
            <div class="process-list">
                <div class="process-item" id="process-step-1">
                    <span class="process-number">1</span>
                    <div><h3>Select a college</h3><p>Pick your college from the list.</p></div>
                </div>
                <div class="process-item" id="process-step-2">
                    <span class="process-number">2</span>
                    <div><h3>Pick department</h3><p>See department and semester fee.</p></div>
                </div>
                <div class="process-item" id="process-step-3">
                    <span class="process-number">3</span>
                    <div><h3>Proceed to payment</h3><p>Click Select to continue to payment flow.</p></div>
                </div>
            </div>
        </div>
    </section>

    <section class="form-panel">
        <h2>Select College and Department</h2>
        <div class="page-description">
            <p>Pick a college then pick department; only department list + fee shows on this panel.</p>
        </div>

        <?php if (!$selectedCollege): ?>
                <h3>Choose a College</h3>
                <div class="college-list">
                    <?php
                    $result = $conn->query("SELECT Ccode, cname FROM collage ORDER BY cname ASC");
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='college-card' onclick=\"window.location.href='?college=" . $row['Ccode'] . "'\">";
                        echo "<h4>" . htmlspecialchars($row['cname']) . "</h4>";
                        echo "</div>";
                    }
                    ?>
                </div>
            <?php else: ?>
                <h3>Departments in <?php
                    $collegeResult = $conn->query("SELECT cname FROM collage WHERE Ccode='$selectedCollege'");
                    $collegeName = $collegeResult->fetch_assoc()['cname'];
                    echo htmlspecialchars($collegeName);
                ?></h3>
                <div class="department-list">
                    <?php
                    // Check if description column exists
                    $checkDesc = $conn->query("SHOW COLUMNS FROM department LIKE 'description'");
                    $hasDescription = $checkDesc->num_rows > 0;
                    
                    $query = "SELECT Dcode, DName, IFNULL(semester_fee, 0) as semester_fee";
                    if ($hasDescription) {
                        $query .= ", IFNULL(description, '') as description";
                    }
                    $query .= " FROM department WHERE Ccode='$selectedCollege' ORDER BY DName ASC";
                    
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='department-card'>";
                        echo "<h4>" . htmlspecialchars($row['DName']) . "</h4>";
                        if ($hasDescription && !empty($row['description'])) {
                            $shortDesc = strlen($row['description']) > 100 ? substr($row['description'], 0, 100) . '...' : $row['description'];
                            echo "<p class='department-description' id='desc-" . $row['Dcode'] . "'>" . htmlspecialchars($shortDesc) . "</p>";
                            if (strlen($row['description']) > 100) {
                                echo "<a href='#' onclick=\"toggleDescription('" . $row['Dcode'] . "', '" . addslashes($row['description']) . "'); return false;\">Read More</a>";
                            }
                        }
                        echo "<p>Semester Fee: " . htmlspecialchars($row['semester_fee']) . " ETB</p>";
                        echo "<button onclick=\"selectDepartment('" . $row['Dcode'] . "', '" . $row['DName'] . "', " . $row['semester_fee'] . ")\">Select This Department</button>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <br>
                <button onclick="window.location.href='departmentlist.php'">Back to Colleges</button>
            <?php endif; ?>
    </section>
</main>

<footer class="progress-footer">
    <div class="progress-container">
        <div class="step-item completed" id="footer-step-1">1</div>
        <div class="connector active" id="connector-1"></div>
        <div class="step-item current" id="footer-step-2">2</div>
        <div class="connector" id="connector-2"></div>
        <div class="step-item" id="footer-step-3">3</div>
    </div>
</footer>

<script>
function selectDepartment(dcode, dname, fee) {
    // Store in session and redirect to payment
    fetch('../initiate_payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            department_code: dcode,
            department_name: dname,
            semester_fee: fee
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.checkout_url) {
            window.location.href = data.checkout_url;
        } else {
            alert(data.error || 'Error initiating payment');
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}

function toggleDescription(dcode, fullDesc) {
    const descElement = document.getElementById('desc-' + dcode);
    const link = descElement.nextElementSibling;
    if (descElement.textContent.endsWith('...')) {
        descElement.textContent = fullDesc;
        link.textContent = 'Read Less';
    } else {
        descElement.textContent = fullDesc.substring(0, 100) + '...';
        link.textContent = 'Read More';
    }
}
</script>

</body>
</html>
