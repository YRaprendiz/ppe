<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])):
    foreach ($_SESSION['messages'] as $message):
?>
    <div class="alert alert-<?= htmlspecialchars($message['type']); ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message['text']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    endforeach;
    // Clear messages after displaying
    unset($_SESSION['messages']);
endif;
?>
