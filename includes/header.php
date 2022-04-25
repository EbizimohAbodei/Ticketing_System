<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Management System</title>
    <link href="css/styling.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
</head>
<body>
    <header>
    <h1 class="pageHeader">Ticket Management System</h1>
    <nav>
        <a href="index.php">Account</a>
        <a href="create.php">Create-Ticket</a>
        <?= $logged_in ? '<a href="logout.php">Log-Out</a>' : '<a href="login.php">Log-In</a>'; ?>
        <a href="tickets.php">Tickets</a>
    </nav>
    </header>