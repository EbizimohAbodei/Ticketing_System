<?php
include 'includes/sessions.php';
include './includes/db.php';
require_login($logged_in); 
if (isset($_POST["sendMessage"])) {

    // Setting default time-zone and creating a variable for the current date and time
    date_default_timezone_set('Europe/Helsinki');
    $createDate = date('Y-m-d H:i:s');

    // Email receiver's address
    $to = 'ebizimohabodei@gmail.com';

    // Assigining sanitized user inputS to created variables
    $fullName = sanitazeInputs($_POST["fullname"]);
    $fullName = mysqli_real_escape_string($connection, $_POST['fullname']);

    $email = sanitazeInputs($_POST["email"]);
    $email = mysqli_real_escape_string($connection, $_POST['email']);

    $subject = sanitazeInputs($_POST["subject"]);
    $subject = mysqli_real_escape_string($connection, $_POST['subject']);

    $message = sanitazeInputs($_POST["message"]);
    $message = mysqli_real_escape_string($connection, $_POST['message']);

    $headers = 'From: '. $fullName . ', ' . $email . "\r\n" . 'Reply-To: webmaster@example.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    // Sending data using PHP mail function
    // mail($to, $subject, $message, $headers);

    if (isset($fullName) && isset($email) && isset($subject) && isset($message) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        mail($to, $subject, $message, $headers);
        $sent = true;
    } 

}
    

?>

<?php include '../Ticket_system/includes/header.php'; ?>

    <div class="contactContainer">
        <? if (isset($sent)){echo '<h3> Message sent</h3>';}  ?>
        <h1>Contact Support</h1>
        <form class="contactForm" action="contact.php" method="POST">
            <div>
            <label for="fullname" class="contactLabel">First and Last name:</label><br>
            <input type="text" name="fullname" class="contactInput" required><br>
            </div>
            <div>
            <label for="email" class="contactLabel">Email Address:</label><br>
            <input type="email" name="email" class="contactInput" required><br>
            </div>
            <div>
            <label for="subject" class="contactLabel">Subject:</label><br>
            <input type="text" name="subject" class="contactInput" required><br>
            </div>
            <div>
            <label for="message" class="contactLabel">Message:</label><br>
            <textarea type="text" rows="17" cols="15" name="message" class="contactTextarea" required></textarea><br>
            </div>
            <input class="contactButton" name="sendMessage" type="submit" value="Send Messsage">
        </form>
    </div>
   
<?php include 'includes/footer.php'; ?>