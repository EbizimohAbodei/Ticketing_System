<?php
include 'includes/sessions.php';
require_login($logged_in); 
include "./includes/db.php";
if (isset($_POST["createTicket"])) {
    // Creating a variable for our ticket ID - a random number with hash-tag and zero additions
    $rand1 = rand(10, 100); 
    $rand2 = rand(10, 100); 
    $rand3 = rand(100, 1000); 
    $id = 'C'.$rand1 . $rand2 . $rand3;

    // Setting default time-zone and creating a variable for the current date and time
    date_default_timezone_set('Europe/Helsinki');
    $createDate = date('Y-m-d H:i:s');

    // Assigining sanitized user inputS to created variables
    $subject = sanitazeInputs($_POST["title"]);
    $subject = mysqli_real_escape_string($connection, $_POST['title']);

    $description = sanitazeInputs($_POST["description"]);
    $description = mysqli_real_escape_string($connection, $_POST['description']);

    $userName = $_COOKIE['fst'];

    // Sending user data to database
    $dataQuery = "INSERT INTO activeTickets(ticketId,subject,description,dateCreated, createdBy) VALUES ('$id', '$subject', '$description', '$createDate', '$userName')";

    $result = mysqli_query($connection, $dataQuery);

    // Making a database query to return updated data
    $dataquery = "SELECT * FROM activeTickets order by dateCreated";
    $dbdata = mysqli_query($connection, $dataquery);

    $connection->close();
}
    // Redirecting the user to tickets page once ticket is created successfully

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        ?> <script>
        window.location = "tickets.php"
        </script> <?
    }

?>
<?php include '../Ticket_system/includes/header.php'; ?>

    <div class="formContainer">
        <h1>Create a new ticket</h1>
        <form class="ticketForm" action="create.php" method="POST">
            <div>
            <label for="title" class="createLabel">Ticket Title/Subject:</label><br>
            <input type="text" id="title" name="title" class="createInput" required><br>
            </div>
            <div>
            <label for="description" class="createLabel">Ticket Description:</label><br>
            <textarea type="text" rows="17" cols="15" id="description" name="description" class="createTextarea" required></textarea><br>
            </div>
            <input class="createButton" name="createTicket" type="submit" value="Create Ticket">
        </form>
    </div>
   
<?php include 'includes/footer.php'; ?>