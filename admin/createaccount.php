<?php
include_once(__DIR__ . '/ps_pagination.php');
include_once(__DIR__ . '/../connection.php');

if (!($conn instanceof mysqli)) {
    die('Database connection failed or not available.');
}

function admin_account_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$searchFile = trim((string) ($_POST['search_file'] ?? ''));
$accountCount = 0;
$countResult = mysqli_query($conn, 'SELECT COUNT(*) AS total FROM account');
if ($countResult instanceof mysqli_result) {
    $countRow = mysqli_fetch_assoc($countResult);
    $accountCount = (int) ($countRow['total'] ?? 0);
    mysqli_free_result($countResult);
}

$rows = array();
$pager = null;

if ($searchFile !== '') {
    $escapedSearch = mysqli_real_escape_string($conn, $searchFile);
    $sql = "SELECT * FROM account WHERE UID LIKE '%{$escapedSearch}%' OR UserName LIKE '%{$escapedSearch}%' OR Role LIKE '%{$escapedSearch}%' ORDER BY UID ASC";
    $checkResult = mysqli_query($conn, $sql);
    if ($checkResult instanceof mysqli_result && mysqli_num_rows($checkResult) > 0) {
        mysqli_free_result($checkResult);
        $pager = new PS_Pagination($conn, $sql, 10, 5);
        $resultSet = $pager->paginate();
        if ($resultSet instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($resultSet)) {
                $rows[] = $row;
            }
            mysqli_free_result($resultSet);
        }
    } else {
        if ($checkResult instanceof mysqli_result) {
            mysqli_free_result($checkResult);
        }
    }
} else {
    $sql = 'SELECT * FROM account ORDER BY UID ASC';
    $pager = new PS_Pagination($conn, $sql, 10, 5);
    $resultSet = $pager->paginate();
    if ($resultSet instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($resultSet)) {
            $rows[] = $row;
        }
        mysqli_free_result($resultSet);
    }
}
?>
<style>
.account-panel {
    background: #ffffff;
    border: 1px solid #dce6f2;
    border-radius: 16px;
    padding: 20px;
}
.account-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}
.account-search-form {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.account-search-label {
    font-size: 15px;
    font-weight: 600;
    color: #173a5e;
}
.account-search-input {
    width: 280px;
    max-width: 100%;
    height: 42px;
    border: 1px solid #bfd0e2;
    border-radius: 10px;
    padding: 0 14px;
    font-size: 15px;
    color: #173a5e;
    background: #f9fbfe;
}
.account-search-input:focus {
    outline: none;
    border-color: #2f77bd;
    box-shadow: 0 0 0 4px rgba(47, 119, 189, 0.12);
}
.account-btn,
.account-btn-secondary,
.account-create-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 42px;
    border: 0;
    border-radius: 10px;
    padding: 0 18px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: transform 0.18s ease;
}
.account-btn {
    background: #1f6fb2;
    color: #ffffff;
}
.account-btn-secondary {
    background: #edf4fb;
    color: #18466f;
}
.account-create-link {
    background: #12395f;
    color: #ffffff;
}
.account-btn:hover,
.account-btn-secondary:hover,
.account-create-link:hover {
    transform: translateY(-1px);
}
.account-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 16px;
    color: #45627f;
}
.account-table-wrap {
    overflow-x: auto;
    border: 1px solid #e3ebf3;
    border-radius: 14px;
}
.account-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 640px;
    background: #ffffff;
}
.account-table th {
    background: #eff5fb;
    color: #12395f;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.account-table th,
.account-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #e7edf5;
    text-align: left;
}
.account-table tr:last-child td {
    border-bottom: 0;
}
.account-role-badge,
.account-status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 28px;
    padding: 0 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.account-role-badge {
    background: #e8f1fb;
    color: #1a5589;
}
.account-status-badge.is-active {
    background: #e6f7eb;
    color: #1b6f35;
}
.account-status-badge.is-inactive {
    background: #fdeaea;
    color: #a12c2c;
}
.account-empty-state {
    padding: 34px 20px;
    border: 1px dashed #bfd0e2;
    border-radius: 14px;
    background: #f8fbff;
    text-align: center;
    color: #4d6882;
    font-size: 15px;
}
.account-pagination {
    margin-top: 18px;
    text-align: center;
}
@media (max-width: 720px) {
    .account-panel {
        padding: 16px;
    }
    .account-search-form,
    .account-search-input,
    .account-btn,
    .account-btn-secondary,
    .account-create-link {
        width: 100%;
    }
}
</style>
<div class="account-panel">
<form method="post" action="" name="form1" id="form1" class="account-toolbar">
    <div class="account-search-form">
        <label class="account-search-label" for="search_file">Search account</label>
        <input type="text" name="search_file" id="search_file" class="account-search-input" placeholder="Search by UID, username, or role" value="<?php echo admin_account_h($searchFile); ?>">
        <button type="submit" name="submit" class="account-btn">Filter</button>
        <?php if ($searchFile !== '') { ?>
        <a href="addaccount.php" class="account-btn-secondary">Clear Search</a>
        <?php } ?>
    </div>
    <a rel="facebox" href="addnewaccount.php" class="account-create-link">Create Account</a>
</form>
<div class="account-meta">
    <div>Number of accounts: <strong><?php echo $accountCount; ?></strong></div>
    <?php if ($searchFile !== '') { ?>
    <div>Showing results for <strong><?php echo admin_account_h($searchFile); ?></strong></div>
    <?php } ?>
</div>
<?php if (!empty($rows)) { ?>
<div class="account-table-wrap">
<table class="account-table" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th>UID</th>
<th>UserName</th>
<th>Role</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows as $row) { ?>
<tr>
<td><?php echo admin_account_h($row['UID']); ?></td>
<td><?php echo admin_account_h($row['UserName']); ?></td>
<td><span class="account-role-badge"><?php echo admin_account_h($row['Role']); ?></span></td>
<td><span class="account-status-badge <?php echo ($row['status'] === 'yes') ? 'is-active' : 'is-inactive'; ?>"><?php echo admin_account_h($row['status']); ?></span></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<?php if ($pager !== null) { ?>
<div class="account-pagination"><?php echo $pager->renderFullNav(); ?></div>
<?php } ?>
<?php } else { ?>
<div class="account-empty-state">No account records found<?php echo $searchFile !== '' ? ' for <strong>' . admin_account_h($searchFile) . '</strong>' : ''; ?>.</div>
<?php } ?>
</div>
