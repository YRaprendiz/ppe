<form method="POST" action="/ppe/Controller/UserController.php">
        <input type="hidden" name="action" value="logout">
        <button type="submit" class="btn btn-primary btn-block">Logout</button>
</form>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session data
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to login page
header("Location: /ppe/index.php?page=authLogin");
exit();
?>
