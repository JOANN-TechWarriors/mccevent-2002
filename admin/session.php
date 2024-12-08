<?php

// Set security headers
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Content-Security-Policy: default-src 'self'");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: geolocation=()");

include('dbcon.php');
// Start session
session_start();
// Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['id']) || ($_SESSION['id'] == '')) { ?>
    <script>
        window.location = 'index2';
    </script>
<?php
    exit();
}

$session_id = $_SESSION['id'];
$session_access = $_SESSION['useraccess'];
$tabname = "";

if ($session_access == "Organizer") {
    $user_query = $conn->query("SELECT * FROM organizer WHERE organizer_id = '$session_id'");
    $user_row = $user_query->fetch();
} else {
    $session_userid = $_SESSION['userid'];
    $user_query = $conn->query("SELECT * FROM organizer WHERE organizer_id = '$session_id'");
    $user_row = $user_query->fetch();

    $tab_query = $conn->query("SELECT * FROM organizer WHERE organizer_id = '$session_userid'");
    $tab_row = $tab_query->fetch();
    if ($tab_row) {
        $tabname = $tab_row['fname'] . " " . $tab_row['mname'] . " " . $tab_row['lname'];
    }
}

if ($user_row) {
    $name = $user_row['fname'] . " " . $user_row['mname'] . " " . $user_row['lname'];
    $check_pass = $user_row['password'];
    $pnum = $user_row['pnum'];
    $txt_poll_num = $user_row['txt_poll_num'];
    $email = $user_row['email'];
    $company_name = $user_row['company_name'];
    $company_address = $user_row['company_address'];
    $company_logo = $user_row['company_logo'];
    $company_telephone = $user_row['company_telephone'];
    $company_email = $user_row['company_email'];
    $company_website = $user_row['company_website'];
} else {
    // Handle the case where the user_row is false (query returned no result)
    // You can redirect to an error page or display an error message
    ?>
    <script>
        alert('User not found.');
        window.location = 'index2';
    </script>
    <?php
    exit();
}
?>
