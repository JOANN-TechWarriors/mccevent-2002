<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example credentials, replace with database checks
    $valid_users = [
        'organizer' => ['username' => 'organizer', 'password' => 'organizerpass'],
        'tabulator' => ['username' => 'tabulator', 'password' => 'tabulatorpass'],
        'audience' => ['username' => 'audience', 'password' => 'audiencepass'],
        'judge' => ['username' => 'judge', 'password' => 'judgepass']
    ];

    $login_category = $_GET['login'];

    if (isset($valid_users[$login_category]) &&
        $username == $valid_users[$login_category]['username'] &&
        $password == $valid_users[$login_category]['password']) {
        echo "<p>Login successful as " . ucfirst(htmlspecialchars($login_category)) . "!</p>";
    } else {
        echo "<p>Invalid username or password for " . ucfirst(htmlspecialchars($login_category)) . ".</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
