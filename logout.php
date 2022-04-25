<?php
include 'includes/sessions.php';
logout(); // Call logout() to terminate session
header('Location: login.php');// Redirect to home page