<?php
/**
 * Admin Logout
 * Kre8 Luxury Barbershop
 */
session_start();
session_unset();
session_destroy();
header('Location: login.php');
exit;
