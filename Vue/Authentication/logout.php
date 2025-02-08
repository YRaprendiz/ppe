<?php
require_once './Controller/AuthUserController.php';

$authController = new AuthUserController();
$authController->logout();