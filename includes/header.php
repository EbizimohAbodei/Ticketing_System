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
        <ul>
            <li><a href="index.php">Account</a></li>
            <li><a href="create.php">Create-Ticket</a></li>
            <li><?= $logged_in ? '<a href="logout.php">Log-Out</a>' : '<a href="login.php">Log-In</a>'; ?></li>
            <li><a href="tickets.php">Tickets</a></li>
            <li> <a href="contact.php">Contact</a></li>
        </ul>
    </nav>
    </header>