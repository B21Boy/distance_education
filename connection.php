<?php
// Shared MySQL connection using mysqli.
$domain = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "cde";

$conn = new mysqli($domain, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

if (!defined('MYSQL_ASSOC')) {
    define('MYSQL_ASSOC', MYSQLI_ASSOC);
}
if (!defined('MYSQL_NUM')) {
    define('MYSQL_NUM', MYSQLI_NUM);
}
if (!defined('MYSQL_BOTH')) {
    define('MYSQL_BOTH', MYSQLI_BOTH);
}

if (!function_exists('mysql_connect')) {
    function mysql_connect($server = null, $username = null, $password = null, $new_link = false, $client_flags = 0)
    {
        global $conn, $domain, $dbuser, $dbpass, $dbname;

        $server = $server ?: $domain;
        $username = $username ?? $dbuser;
        $password = $password ?? $dbpass;

        if ($conn instanceof mysqli) {
            $isSameTarget = $server === $domain && $username === $dbuser && $password === $dbpass;
            if ($isSameTarget && @$conn->ping()) {
                return $conn;
            }
        }

        $link = new mysqli($server, $username, $password, $dbname);
        if ($link->connect_error) {
            return false;
        }
        $link->set_charset('utf8mb4');
        $conn = $link;
        return $conn;
    }
}

if (!function_exists('mysql_select_db')) {
    function mysql_select_db($database_name, $link_identifier = null)
    {
        global $conn;
        $link = $link_identifier instanceof mysqli ? $link_identifier : $conn;
        if (!$link instanceof mysqli) {
            return false;
        }
        return mysqli_select_db($link, $database_name);
    }
}

if (!function_exists('mysql_query')) {
    function mysql_query($query, $link_identifier = null)
    {
        global $conn;
        $link = $link_identifier instanceof mysqli ? $link_identifier : $conn;
        if (!$link instanceof mysqli) {
            return false;
        }
        return mysqli_query($link, $query);
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($result, $result_type = MYSQL_BOTH)
    {
        return $result instanceof mysqli_result ? mysqli_fetch_array($result, $result_type) : false;
    }
}

if (!function_exists('mysql_fetch_assoc')) {
    function mysql_fetch_assoc($result)
    {
        return $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : false;
    }
}

if (!function_exists('mysql_fetch_row')) {
    function mysql_fetch_row($result)
    {
        return $result instanceof mysqli_result ? mysqli_fetch_row($result) : false;
    }
}

if (!function_exists('mysql_fetch_field')) {
    function mysql_fetch_field($result, $field_offset = 0)
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }
        if ($field_offset > 0) {
            mysqli_field_seek($result, $field_offset);
        }
        return mysqli_fetch_field($result);
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($result)
    {
        return $result instanceof mysqli_result ? mysqli_num_rows($result) : 0;
    }
}

if (!function_exists('mysql_num_fields')) {
    function mysql_num_fields($result)
    {
        return $result instanceof mysqli_result ? mysqli_num_fields($result) : 0;
    }
}

if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($unescaped_string, $link_identifier = null)
    {
        global $conn;
        $link = $link_identifier instanceof mysqli ? $link_identifier : $conn;
        if (!$link instanceof mysqli) {
            return addslashes((string) $unescaped_string);
        }
        return mysqli_real_escape_string($link, (string) $unescaped_string);
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id($link_identifier = null)
    {
        global $conn;
        $link = $link_identifier instanceof mysqli ? $link_identifier : $conn;
        return $link instanceof mysqli ? mysqli_insert_id($link) : 0;
    }
}

if (!function_exists('mysql_affected_rows')) {
    function mysql_affected_rows($link_identifier = null)
    {
        global $conn;
        $link = $link_identifier instanceof mysqli ? $link_identifier : $conn;
        return $link instanceof mysqli ? mysqli_affected_rows($link) : -1;
    }
}

if (!function_exists('mysql_error')) {
    function mysql_error($link_identifier = null)
    {
        global $conn;
        $link = $link_identifier instanceof mysqli ? $link_identifier : $conn;
        return $link instanceof mysqli ? mysqli_error($link) : 'No database connection available';
    }
}

if (!function_exists('mysql_close')) {
    function mysql_close($link_identifier = null)
    {
        global $conn;

        if ($link_identifier instanceof mysqli_result) {
            mysqli_free_result($link_identifier);
            return true;
        }

        $link = $link_identifier instanceof mysqli ? $link_identifier : $conn;
        if (!$link instanceof mysqli) {
            return true;
        }

        if ($link === $conn) {
            return true;
        }

        return mysqli_close($link);
    }
}
?>
