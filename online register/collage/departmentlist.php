<?php
session_start();
include __DIR__ . '/../../connection.php';

// Check if session has data
if (!isset($_SESSION['username']) || !isset($_SESSION['phone_number'])) {
    header("Location: ../../onliner.php");
    exit;
}

$selectedCollege = $_GET['college'] ?? null;

if (isset($_GET['ajax']) && $_GET['ajax'] === '1' && isset($_GET['college'])) {
    $collegeCode = $conn->real_escape_string($_GET['college']);
    $checkDesc = $conn->query("SHOW COLUMNS FROM department LIKE 'description'");
    $hasDescription = $checkDesc->num_rows > 0;
    $query = "SELECT Dcode, DName, IFNULL(semester_fee, 0) as semester_fee";
    if ($hasDescription) {
        $query .= ", IFNULL(description, '') as description";
    }
    $query .= " FROM department WHERE Ccode='" . $collegeCode . "' ORDER BY DName ASC";
    $result = $conn->query($query);
    $departments = [];
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode(['departments' => $departments]);
    exit;
}
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
    grid-template-columns: 1fr;
    gap: 20px;
}

.form-panel {
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(148, 163, 184, 0.18);
    border-radius: 28px;
    box-shadow: 0 24px 50px rgba(15, 23, 42, 0.08);
    padding: 26px;
}

.form-panel h2 {
    font-size: clamp(1.8rem, 2.4vw, 2.1rem);
    font-weight: 700;
    margin-bottom: 0.35rem;
    color: #0f172a;
}

.form-panel h3 {
    font-size: 1rem;
    margin: 0 0 16px;
    color: #334155;
    font-weight: 600;
}

.section-subtitle {
    max-width: 760px;
    margin: 0 0 22px;
    color: #475569;
    font-size: 0.98rem;
    line-height: 1.75;
}

.department-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 12px;
}

.college-carousel {
    margin: 12px auto 0;
    overflow-x: auto;
    position: relative;
    display: flex;
    justify-content: center;
    background: transparent;
    border: none;
    border-radius: 28px;
    padding: 12px 0 12px;
    max-width: min(1120px, calc(100% - 40px));
}
.college-track {
    display: flex;
    gap: 24px;
    justify-content: center;
    align-items: center;
    padding: 0 14px;
}

/* Horizontal scrollbar styling */
.college-carousel::-webkit-scrollbar {
    height: 10px;
}
.college-carousel::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.45);
    border-radius: 999px;
}
.college-carousel::-webkit-scrollbar-track {
    background: transparent;
}
.college-card {
    flex: 0 0 400px;
    max-width: 400px;
    min-width: 400px;
    height: 400px;
    border: 1px solid rgba(148, 163, 184, 0.22);
    background: #ffffff;
    border-radius: 32px;
    cursor: pointer;
    transition: transform 0.25s ease, box-shadow 0.3s ease, background 0.3s ease;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
}
.college-card:hover {
    background: #ffffff;
    box-shadow: 0 24px 54px rgba(15, 23, 42, 0.14);
    transform: translateY(-3px);
}

.college-carousel::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: transparent;
    pointer-events: none;
}
.college-card h4 {
    margin: 0;
    font-size: 1.1rem;
    color: #0f172a;
    line-height: 1.35;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(8px);
    z-index: 1000;
    padding: 24px;
}
.modal-card {
    width: min(1100px, 100%);
    max-height: 90vh;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 28px;
    box-shadow: 0 28px 80px rgba(15, 23, 42, 0.22);
    padding: 28px;
    position: relative;
}
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 24px;
}
.modal-title {
    margin: 0;
    font-size: clamp(1.4rem, 2vw, 1.8rem);
    color: #0f172a;
}
.modal-caption {
    margin: 10px 0 0;
    color: #667085;
    font-size: 0.95rem;
    line-height: 1.6;
}
.modal-close {
    border: none;
    background: transparent;
    color: #475569;
    font-size: 1.8rem;
    cursor: pointer;
    line-height: 1;
}
.department-carousel {
    display: flex;
    gap: 18px;
    overflow-x: auto;
    padding-bottom: 14px;
    scroll-snap-type: x mandatory;
    justify-content: center;
}
.department-carousel::-webkit-scrollbar {
    height: 10px;
}
.department-carousel::-webkit-scrollbar-thumb {
    background: rgba(100, 116, 139, 0.45);
    border-radius: 999px;
}
.department-carousel::-webkit-scrollbar-track {
    background: transparent;
}
.department-card-inline {
    flex: 0 0 min(45%, 340px);
    max-width: 360px;
    min-width: 300px;
    aspect-ratio: 1 / 1.05;
    background: #ffffff;
    border: 1px solid rgba(148, 163, 184, 0.24);
    border-radius: 24px;
    padding: 22px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    scroll-snap-align: start;
    transition: transform 0.25s ease, box-shadow 0.3s ease;
}
.department-card-inline:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 32px rgba(15, 23, 42, 0.12);
}
.department-card-inline h4 {
    margin: 0 0 10px;
    font-size: 1.05rem;
    color: #0f172a;
}
.department-card-inline p {
    margin: 0;
    color: #475569;
    font-size: 0.96rem;
    line-height: 1.55;
}
.department-card-inline .fee {
    margin-top: 20px;
    font-weight: 700;
    color: #1e40af;
}
.department-card-inline button {
    margin-top: 18px;
    padding: 12px 16px;
    border-radius: 14px;
    background: #2563eb;
    color: #fff;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: background 0.25s ease;
}
.department-card-inline button:hover {
    background: #1d4ed8;
}
.modal-loading,
.modal-empty {
    min-height: 170px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
    font-size: 1rem;
}
.modal-empty {
    padding: 28px;
}
.department-description-small {
    margin-top: 10px;
    color: #64748b;
    font-size: 0.92rem;
    line-height: 1.5;
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
</style>
</head>
<body class="student-portal-page">
<main class="register-shell">

    <section class="form-panel">
        <?php if (!$selectedCollege): ?>
                <h3>Choose a College</h3>
                <div class="college-carousel">
                    <div class="college-track">
                    <?php
                    $result = $conn->query("SELECT Ccode, cname FROM collage ORDER BY cname ASC");
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='college-card' onclick=\"openCollegeModal('" . htmlspecialchars(addslashes($row['Ccode'])) . "', '" . htmlspecialchars(addslashes($row['cname'])) . "')\">";
                        echo "<h4>" . htmlspecialchars($row['cname']) . "</h4>";
                        echo "</div>";
                    }
                    ?>
                    </div>
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
    <div class="modal-overlay" id="college-modal" onclick="if (event.target === this) closeCollegeModal();">
        <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modal-college-name">
            <div class="modal-header">
                <div>
                    <p class="eyebrow">Departments</p>
                    <h2 class="modal-title" id="modal-college-name">College</h2>
                    <p class="modal-caption">Swipe to see more departments in this college.</p>
                </div>
                <button class="modal-close" type="button" aria-label="Close department modal" onclick="closeCollegeModal()">×</button>
            </div>
            <div class="department-carousel" id="modal-department-list">
                <div class="modal-loading">Loading departments…</div>
            </div>
            <div class="modal-empty" id="modal-empty" style="display:none;">No departments found for this college.</div>
        </div>
    </div>
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
function openCollegeModal(code, name) {
    const modal = document.getElementById('college-modal');
    const title = document.getElementById('modal-college-name');
    const list = document.getElementById('modal-department-list');
    const empty = document.getElementById('modal-empty');

    title.textContent = name;
    list.innerHTML = '<div class="modal-loading">Loading departments…</div>';
    empty.style.display = 'none';
    modal.style.display = 'flex';

    fetch(`departmentlist.php?ajax=1&college=${encodeURIComponent(code)}`)
        .then(response => response.json())
        .then(data => {
            list.innerHTML = '';
            if (!data.departments || data.departments.length === 0) {
                empty.style.display = 'block';
                return;
            }

            data.departments.forEach(dep => {
                const card = document.createElement('div');
                card.className = 'department-card-inline';

                const contentWrapper = document.createElement('div');
                const title = document.createElement('h4');
                title.textContent = dep.DName;
                contentWrapper.appendChild(title);

                if (dep.description) {
                    const desc = document.createElement('p');
                    desc.className = 'department-description-small';
                    desc.textContent = dep.description;
                    contentWrapper.appendChild(desc);
                }

                const actionWrapper = document.createElement('div');
                const fee = document.createElement('p');
                fee.className = 'fee';
                fee.textContent = `Semester Fee: ${dep.semester_fee} ETB`;
                actionWrapper.appendChild(fee);

                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = 'Select Department';
                button.addEventListener('click', () => selectDepartment(dep.Dcode, dep.DName, parseInt(dep.semester_fee, 10)));
                actionWrapper.appendChild(button);

                card.appendChild(contentWrapper);
                card.appendChild(actionWrapper);
                list.appendChild(card);
            });
        })
        .catch(error => {
            list.innerHTML = '<div class="modal-empty">Unable to load departments. Please try again.</div>';
            console.error(error);
        });
}

function closeCollegeModal() {
    const modal = document.getElementById('college-modal');
    modal.style.display = 'none';
}

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
