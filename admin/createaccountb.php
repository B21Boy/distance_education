<?php
include_once(__DIR__ . '/ps_pagination.php');
include_once(__DIR__ . '/../connection.php');

if (!($conn instanceof mysqli)) {
    die('Database connection failed or not available.');
}

function admin_block_account_h($value)
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
$whereSql = '';
if ($searchFile !== '') {
    $escapedSearch = mysqli_real_escape_string($conn, $searchFile);
    $whereSql = " WHERE UID LIKE '%{$escapedSearch}%' OR UserName LIKE '%{$escapedSearch}%' OR Role LIKE '%{$escapedSearch}%' OR status LIKE '%{$escapedSearch}%'";
}

$sql = 'SELECT UID, UserName, Role, status FROM account' . $whereSql . ' ORDER BY UID ASC';
$pager = new PS_Pagination($conn, $sql, 10, 5);
$resultSet = $pager->paginate();
if ($resultSet instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($resultSet)) {
        $rows[] = $row;
    }
    mysqli_free_result($resultSet);
}
?>
<style>
.block-account-toolbar-note {
    color: #4d6882;
    font-size: 14px;
}
.block-account-status,
.block-account-role {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 28px;
    padding: 0 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.block-account-role {
    background: #e8f1fb;
    color: #1a5589;
}
.block-account-status.is-active {
    background: #e6f7eb;
    color: #1b6f35;
}
.block-account-status.is-inactive {
    background: #fdeaea;
    color: #a12c2c;
}
.block-account-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 38px;
    border-radius: 10px;
    padding: 0 16px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
}
.block-account-action.is-block {
    background: #1f6fb2;
}
.block-account-action.is-unblock {
    background: #b64242;
}
</style>
<div class="admin-page-panel">
<form method="post" action="" class="admin-page-toolbar">
    <div class="admin-page-form-row">
        <label for="search_file"><strong>Filter accounts</strong></label>
        <input type="text" name="search_file" id="search_file" class="admin-page-input" placeholder="Search by UID, username, role, or status" value="<?php echo admin_block_account_h($searchFile); ?>">
        <button type="submit" name="submit" class="admin-page-btn">Filter</button>
        <?php if ($searchFile !== '') { ?>
        <a href="addaccountb.php" class="admin-page-btn-secondary">Clear</a>
        <?php } ?>
    </div>
    <div class="block-account-toolbar-note">Total accounts: <strong><?php echo $accountCount; ?></strong></div>
</form>
<?php if (!empty($rows)) { ?>
<div class="admin-page-table-wrap">
<table class="admin-page-table" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th>UID</th>
<th>UserName</th>
<th>Role</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows as $row) {
    $isActive = (($row['status'] ?? '') === 'yes');
    $actionLabel = $isActive ? 'Block' : 'Unblock';
    $actionClass = $isActive ? 'is-block' : 'is-unblock';
?>
<tr>
<td><?php echo admin_block_account_h($row['UID']); ?></td>
<td><?php echo admin_block_account_h($row['UserName']); ?></td>
<td><span class="block-account-role"><?php echo admin_block_account_h($row['Role']); ?></span></td>
<td><span class="block-account-status <?php echo $isActive ? 'is-active' : 'is-inactive'; ?>"><?php echo admin_block_account_h($row['status']); ?></span></td>
<td>
    <a class="block-account-action <?php echo $actionClass; ?>" href="ACTION.php?status=<?php echo urlencode((string) $row['UID']); ?>" onclick="return confirm('Are you sure you want to <?php echo strtolower($actionLabel); ?> <?php echo admin_block_account_h($row['UID']); ?>?');">
        <?php echo $actionLabel; ?>
    </a>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<?php if ($pager !== null) { ?>
<div class="admin-page-pagination"><?php echo $pager->renderFullNav(); ?></div>
<?php } ?>
<?php } else { ?>
<div class="admin-page-empty">No account records found<?php echo $searchFile !== '' ? ' for <strong>' . admin_block_account_h($searchFile) . '</strong>' : ''; ?>.</div>
<?php } ?>
</div>
