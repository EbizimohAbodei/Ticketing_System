<?php
include 'includes/sessions.php';
require_login($logged_in); 
include './includes/db.php'; 
// Making datatbase calls to retrieve data from database
$dataquery = "SELECT * FROM activeTickets ORDER BY dateCreated";
$dbdata = mysqli_query($connection, $dataquery);

$SSQuery = "SELECT * FROM completed ORDER BY completeDate desc LIMIT 7";
$completeData = mysqli_query($connection, $SSQuery);

if (isset($_POST["submit"])) {
   
    // Assigining sanitized user inputs to created variables
    $id = sanitazeInputs($_POST["id"]);
    $id = mysqli_real_escape_string($connection, $_POST['id']);

    $subject = sanitazeInputs($_POST["subject"]);
    $subject = mysqli_real_escape_string($connection, $_POST['subject']);

    $description = sanitazeInputs($_POST["description"]);
    $description = mysqli_real_escape_string($connection, $_POST['description']);


    //SQL statements to update database with new data
    $dataQuery = "UPDATE activeTickets SET ";
    $dataQuery .="subject = '$subject', ";
    $dataQuery .="description = '$description' ";
    $dataQuery .="WHERE ticketId = '$id'";

    $result = mysqli_query($connection, $dataQuery);

    $dataquery = "SELECT * FROM activeTickets ORDER BY dateCreated";
    $dbdata = mysqli_query($connection, $dataquery);

}

// Checking is the ticketId is parsed in URL
if (isset($_GET['compId'])) {
    // Assigning the ticket-Id and subjects from URL to variables
    $id = $_GET['compId'];
    $subject = $_GET['subject'];

    // Deleting the data from activeTickets database
    $dataQuery = "DELETE FROM activeTickets WHERE ticketId = '$id'";
    $results = mysqli_query($connection, $dataQuery);

    $dataquery = "SELECT * FROM activeTickets ORDER BY dateCreated";
    $dbdata = mysqli_query($connection, $dataquery);

    date_default_timezone_set('Europe/Helsinki');
    $completeDate = date('Y-m-d H:i:s');

    // Inserting the same dataset to completed database
    $completedQuery = "INSERT INTO completed(ticketId,subject,completeDate) VALUES ('$id', '$subject', '$completeDate')";

    $completeData = mysqli_query($connection, $completedQuery);

    // Making an SQL query to return seven(7) recent completed tickets
    $SSQuery = "SELECT * FROM completed ORDER BY completeDate desc LIMIT 7";
    $completeData = mysqli_query($connection, $SSQuery);
    
}

// Getting the user's firstname set in the cookie after login
$firstname = $_COOKIE['PHPCookie'];

?>
<?php include '../Ticket_system/includes/header.php'; ?>

<div>
    <h1 class="welcomeText"><?= 'Welcome' . ' ' . $firstname ?></h1>
    <form class="ticketForm" action="tickets.php" method="POST">
        <input type="text" class="inputUpdate" name="id" placeholder="enter existing ticket-id" required>
        <input type="text" class="inputUpdate" name="subject" placeholder="new ticket subject" required>
        <input type="text" class="inputUpdate" name="description" placeholder="new ticket description" required>
        <input class="updateButton" name="submit" type="submit" value="Update Ticket">
    </form>
</div>
<div class="ticketsContainer">
    <div class="activeTicketsContainer">
        <h3 class="activeTickets">Active Tickets</h3>
        <table>
        <tr class="tableHead">
        <th>ID</th>
        <th>Subject</th>
        <th>Description</th>
        <th>Created</th>
        <th>Created-by</th>
        <th>Mark Done</th>
        </tr>
        <tr>
        <?php
        while ($ticket = mysqli_fetch_assoc($dbdata)) { ?>
        <td class="id"><?= $ticket['ticketId']?></td>
        <td class="subject"><?= $ticket['subject']?></td>
        <td class="description"><?= $ticket['description']?></td>
        <td class="created"><?= $ticket['dateCreated']?></td>
        <td class="Created-by"><?=$firstname?></td>
        <td><a class="completeButton" href="tickets.php?compId=<?=$ticket['ticketId']?>&&subject=<?=$ticket['subject']?>"><i class="material-icons" title="Click icon to mark ticket resolved">done_all</i></a></td>
        </tr>
        <?php
        } ?>
        </table>
    </div>
    <aside class="completedTicketsContainer">
        <h3 class="completedTickets">Recently Completed Tickets</h3>
    <table>
        <tr class="tableHead">
        <th>Ticket_ID</th>
        <th>Subject</th>
        <th>Completed</th>
        </tr>
        <tr>
        <?php
        while ($tickets = mysqli_fetch_assoc($completeData)) { ?>
        <td><?= $tickets['ticketId']?></td>
        <td><?= $tickets['subject']?></td>
        <td><?= $tickets['completeDate']?></td>
        </tr>
        <?php
        } ?>
    </table>
    </aside>
</div>
    <h4 class="closeText">Make sure nothing falls through the cracks!
    </h4>


<?php include 'includes/footer.php'; ?>