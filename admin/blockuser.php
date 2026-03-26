<?php
include_once(__DIR__ . '/ps_pagination.php');
include_once(__DIR__ . '/../connection.php');

if (!($conn instanceof mysqli)) {
    die('Database connection failed or not available.');
}

function admin_users_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$searchFile = trim((string) ($_POST['search_file'] ?? ''));
$userCount = 0;
$countResult = mysqli_query($conn, 'SELECT COUNT(*) AS total FROM user');
if ($countResult instanceof mysqli_result) {
    $countRow = mysqli_fetch_assoc($countResult);
    $userCount = (int) ($countRow['total'] ?? 0);
    mysqli_free_result($countResult);
}

$pager = null;
$rows = array();

if ($searchFile !== '') {
    $escapedSearch = mysqli_real_escape_string($conn, $searchFile);
    $sql = "SELECT * FROM user WHERE UID LIKE '%{$escapedSearch}%' ORDER BY UID ASC";
    $checkResult = mysqli_query($conn, $sql);

    if ($checkResult instanceof mysqli_result && mysqli_num_rows($checkResult) > 0) {
        mysqli_free_result($checkResult);
        $pager = new PS_Pagination($conn, $sql, 8, 5);
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
    $sql = 'SELECT * FROM user ORDER BY UID ASC';
    $pager = new PS_Pagination($conn, $sql, 8, 5);
    $resultSet = $pager->paginate();
    if ($resultSet instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($resultSet)) {
            $rows[] = $row;
        }
        mysqli_free_result($resultSet);
    }
}
?>
<div class="admin-users-panel">
<form method="post" action="" name="form1" id="form1" class="admin-toolbar">
<div class="admin-search-form">
<label class="admin-search-label" for="search_file">Search user</label>
<input
    type="text"
    autofocus="autofocus"
    name="search_file"
    id="search_file"
    class="admin-search-input"
    placeholder="Search by user ID"
    value="<?php echo admin_users_h($searchFile); ?>"
>
<button type="submit" name="submit" class="admin-primary-btn">Filter</button>
<?php if ($searchFile !== '') { ?>
<a href="adduser.php" class="admin-secondary-btn">Clear Search</a>
<?php } ?>
</div>
<a rel="facebox" href="addnewuser.php" class="admin-add-user-link">Add New User</a>
</form>

<div class="admin-users-meta">
<div class="admin-users-count">Number of users: <strong><?php echo $userCount; ?></strong></div>
<?php if ($searchFile !== '') { ?>
<div class="admin-users-search-state">Showing results for <strong><?php echo admin_users_h($searchFile); ?></strong></div>
<?php } ?>
</div>

<?php if (!empty($rows)) { ?>
<div class="admin-users-table-wrap">
<table cellpadding="0" cellspacing="0" class="admin-users-table">
<thead>
<tr>
<th>UID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Sex</th>
<th>Email</th>
<th>Phone</th>
<th>Location</th>
<th>Photo</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows as $row) {
    $photo = !empty($row['photo']) ? $row['photo'] : 'userphoto/img1.jpg';
?>
<tr>
<td><?php echo admin_users_h($row['UID']); ?></td>
<td><?php echo admin_users_h($row['fname']); ?></td>
<td><?php echo admin_users_h($row['lname']); ?></td>
<td><?php echo admin_users_h($row['sex']); ?></td>
<td><?php echo admin_users_h($row['Email']); ?></td>
<td><?php echo admin_users_h($row['phone_No']); ?></td>
<td><?php echo admin_users_h($row['location']); ?></td>
<td><img src="<?php echo admin_users_h($photo); ?>" alt="User Photo" class="admin-photo-thumb"></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<?php if ($pager !== null) { ?>
<div class="admin-pagination"><?php echo $pager->renderFullNav(); ?></div>
<?php } ?>
<?php } else { ?>
<div class="admin-empty-state">
No users found<?php echo $searchFile !== '' ? ' for <strong>' . admin_users_h($searchFile) . '</strong>' : ''; ?>.
</div>
<?php } ?>
</div>
