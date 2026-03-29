<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photo_path = registrarCurrentPhotoPath();
$upload_message = '';
$upload_message_class = 'error';

function registrarNormalizeCsvText(string $value): string
{
    $value = trim($value);
    if ($value === '') {
        return '';
    }

    if (!preg_match('//u', $value)) {
        if (function_exists('iconv')) {
            $converted = @iconv('Windows-1252', 'UTF-8//IGNORE', $value);
            if (is_string($converted) && $converted !== '') {
                $value = $converted;
            } else {
                $converted = @iconv('ISO-8859-1', 'UTF-8//IGNORE', $value);
                if (is_string($converted) && $converted !== '') {
                    $value = $converted;
                }
            }
        }

        if (!preg_match('//u', $value) && function_exists('mb_convert_encoding')) {
            $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1252,ISO-8859-1,UTF-8');
        }
    }

    $value = str_replace("\xC2\xA0", ' ', $value);
    $value = preg_replace('/\s+/u', ' ', $value);
    $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value);

    return trim($value);
}

function registrarNormalizeCsvDate(string $value): string
{
    $value = registrarNormalizeCsvText($value);
    if ($value === '') {
        return date('Y-m-d');
    }

    $formats = array('Y-m-d', 'm/d/Y', 'n/j/Y', 'd/m/Y', 'j/n/Y', 'm-d-Y', 'n-j-Y');
    foreach ($formats as $format) {
        $date = DateTime::createFromFormat($format, $value);
        if ($date instanceof DateTime) {
            return $date->format('Y-m-d');
        }
    }

    $timestamp = strtotime($value);
    if ($timestamp !== false) {
        return date('Y-m-d', $timestamp);
    }

    return date('Y-m-d');
}

if (isset($_POST['submit'])) {
    $file = $_FILES['file'] ?? null;

    if (!is_array($file) || trim((string) ($file['name'] ?? '')) === '') {
        $upload_message = 'Please choose a CSV file first.';
    } elseif ((int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $upload_message = 'The CSV upload failed before it reached the registrar importer.';
    } else {
        $extension = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        if ($extension !== 'csv') {
            $upload_message = 'Only CSV files are allowed.';
        } else {
            $handle = fopen((string) $file['tmp_name'], 'r');
            if ($handle === false) {
                $upload_message = 'The selected file could not be opened.';
            } else {
                $sql = "INSERT INTO student
                            (S_ID, FName, mname, LName, Sex, Email, Phone_No, College, Department, year, section, semister, program, Location, Education_level, Date, unread, status)
                        VALUES
                            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE
                            FName = VALUES(FName),
                            mname = VALUES(mname),
                            LName = VALUES(LName),
                            Sex = VALUES(Sex),
                            Email = VALUES(Email),
                            Phone_No = VALUES(Phone_No),
                            College = VALUES(College),
                            Department = VALUES(Department),
                            year = VALUES(year),
                            section = VALUES(section),
                            semister = VALUES(semister),
                            program = VALUES(program),
                            Location = VALUES(Location),
                            Education_level = VALUES(Education_level),
                            Date = VALUES(Date),
                            unread = VALUES(unread),
                            status = VALUES(status)";
                $stmt = mysqli_prepare($conn, $sql);

                if (!$stmt) {
                    $upload_message = 'The student register query could not be prepared.';
                    fclose($handle);
                } else {
                    $result = true;
                    $row_number = 0;
                    $processed_rows = 0;

                    try {
                        while (($data = fgetcsv($handle)) !== false) {
                            $row_number++;
                            if (!is_array($data) || count($data) < 13) {
                                continue;
                            }

                            $id = registrarNormalizeCsvText((string) ($data[0] ?? ''));
                            if ($id === '' || strcasecmp($id, 'S_ID') === 0) {
                                continue;
                            }

                            $fname = registrarNormalizeCsvText((string) ($data[1] ?? ''));
                            $mname = registrarNormalizeCsvText((string) ($data[2] ?? ''));
                            $lname = registrarNormalizeCsvText((string) ($data[3] ?? ''));
                            $sex = registrarNormalizeCsvText((string) ($data[4] ?? ''));
                            $email = registrarNormalizeCsvText((string) ($data[5] ?? ''));
                            $pno = registrarNormalizeCsvText((string) ($data[6] ?? ''));
                            $coll = registrarNormalizeCsvText((string) ($data[7] ?? ''));
                            $dept = registrarNormalizeCsvText((string) ($data[8] ?? ''));
                            $year = registrarNormalizeCsvText((string) ($data[9] ?? ''));
                            $sem = registrarNormalizeCsvText((string) ($data[10] ?? ''));
                            $program = registrarNormalizeCsvText((string) ($data[11] ?? ''));
                            $date = registrarNormalizeCsvDate((string) ($data[12] ?? ''));

                            $section = registrarNormalizeCsvText((string) ($data[13] ?? ''));
                            $location = registrarNormalizeCsvText((string) ($data[14] ?? ''));
                            $education_level = registrarNormalizeCsvText((string) ($data[15] ?? ''));
                            $unread = registrarNormalizeCsvText((string) ($data[16] ?? ''));
                            $status = registrarNormalizeCsvText((string) ($data[17] ?? ''));

                            if ($section === '') {
                                $section = ' ';
                            }
                            if ($location === '') {
                                $location = ' ';
                            }
                            if ($education_level === '') {
                                $education_level = ' ';
                            }
                            if ($unread === '') {
                                $unread = 'yes';
                            }
                            if ($status === '') {
                                $status = 'active';
                            }

                            mysqli_stmt_bind_param(
                                $stmt,
                                'ssssssssssssssssss',
                                $id,
                                $fname,
                                $mname,
                                $lname,
                                $sex,
                                $email,
                                $pno,
                                $coll,
                                $dept,
                                $year,
                                $section,
                                $sem,
                                $program,
                                $location,
                                $education_level,
                                $date,
                                $unread,
                                $status
                            );

                            if (!mysqli_stmt_execute($stmt)) {
                                $result = false;
                                $upload_message = 'CSV import stopped on row ' . $row_number . ': ' . mysqli_stmt_error($stmt);
                                break;
                            }

                            $processed_rows++;
                        }
                    } catch (Throwable $exception) {
                        $result = false;
                        $upload_message = 'CSV import stopped on row ' . $row_number . ': ' . $exception->getMessage();
                    }

                    fclose($handle);
                    mysqli_stmt_close($stmt);

                    if ($result && $upload_message === '') {
                        if ($processed_rows > 0) {
                            $upload_message = 'Student records were registered successfully. Processed rows: ' . $processed_rows . '. Existing student IDs were updated when matched.';
                            $upload_message_class = 'success';
                        } else {
                            $upload_message = 'No student rows were imported. Please check the CSV column order.';
                        }
                    }
                }
            }
        }
    }
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
                <div class="registrar-page-header">
                    <span class="registrar-page-eyebrow">Student Register</span>
                    <h1 class="registrar-page-title">Register Student Data</h1>
                    <p class="registrar-page-copy">Upload a CSV file to import student records in one step and keep registrar records up to date.</p>
                </div>
                <?php if ($upload_message !== ''): ?>
                    <div class="registrar-status <?php echo registrarH($upload_message_class); ?>"><?php echo registrarH($upload_message); ?></div>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data" class="registrar-form-grid">
                    <div class="registrar-form-field full">
                        <label class="registrar-label" for="studentCsv">Student CSV File</label>
                        <input type="file" name="file" id="studentCsv" class="registrar-file-input" accept=".csv" required>
                        <div class="registrar-form-note">Required CSV column order: student ID, first name, middle name, last name, sex, email, phone, college, department, year, semester, program, date. Optional extra columns after that: section, location, education level, unread, status.</div>
                    </div>
                    <div class="registrar-form-field full">
                        <div class="registrar-actions">
                            <button type="submit" name="submit" class="registrar-btn">Register Students</button>
                            <button type="reset" name="reset" class="registrar-btn-secondary">Clear File</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="sidebar"><?php registrarRenderSidebar($photo_path); ?></div>
</div>
<div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php registrarRenderIconScripts(); ?>
</body>
</html>
