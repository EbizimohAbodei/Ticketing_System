<?php
include 'includes/sessions.php';
include './includes/db.php';
if (isset($_POST["createUser"])) {
    // Creating a variable for our ticket ID - a random number with hash-tag and zero additions
    $rand1 = rand(100, 1000); 
    $rand2 = rand(1000, 100000); 
    $userId = 'U'.$rand1 . $rand2;

    // Assigining sanitized user inputS to created variables
    $firstname = sanitazeInputs($_POST["firstName"]);
    $firstname = mysqli_real_escape_string($connection, $_POST['firstName']);

    $lastname = sanitazeInputs($_POST["lastName"]);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastName']);

    $email = sanitazeInputs($_POST["email"]);
    $email = mysqli_real_escape_string($connection, $_POST['email']);

    $pass1 = sanitazeInputs($_POST["password"]);
    $pass1 = mysqli_real_escape_string($connection, $_POST['password']);

    $pass2 = sanitazeInputs($_POST["confirmPassword"]);
    $pass2 = mysqli_real_escape_string($connection, $_POST['confirmPassword']);

    // Encrypting the user password
    $hashFormat = "_J9..rasm"; //Standard DES
    $salt = 'whateversaltisokaytoouthere$'; 
    $hashFormatAndSalt = $hashFormat . $salt;
    $password = crypt($pass1, $hashFormatAndSalt);


    // Validating password length and ensuring password match
    if (strlen($pass1) < 7) {
        $message = "Password must be longer than 7";
    } else if ($pass1 !== $pass2) {
        $message = "Passwords must match";
    } else {

        // Data insertion to database
        $dataQuery = "INSERT INTO users(id,firstname,lastname,email,password) VALUES ('$userId', '$firstname', '$lastname', '$email', '$password')";

        $result = mysqli_query($connection, $dataQuery);
        $connection->close();
    }
    
}

?>

<?php include '../Ticket_system/includes/header.php'; ?>

<main>
    <div class="createContainer">
        <h5 class="errorMessage"><? if (isset($message)){echo $message;} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){echo 'Your account has been created';} ?> </h5>
        <h1 class="indexHeader">Create Account</h1>
        <form class="accountForm" action="index.php" method="POST">
            <label class="createLabels">First-Name: </label>
            <input class="createInputs" type="text" id="firstName" name="firstName" required>
            <label class="createLabels">Last-Name: </label>
            <input class="createInputs" type="text" id="lastName" name="lastName" required>
            <label class="createLabels">Company Email Address: </label>
            <input class="createInputs" type="email" id="email" name="email" required>
            <label class="createLabels">Password: </label>
            <input class="createInputs" type="password" name="password" required>
            <label class="createLabels">Confirm Password: </label>
            <input class="createInputs" type="password"  name="confirmPassword" required>
            <input class="createUserBtn" name="createUser" type="submit" value="Create Account">
        </form>
    
        <div class="paraContainer">
            <p>
            By clicking the "Create Account" button, you agree to our 
            <a href="#">Terms & Conditions</a> and
            <a href="#">Privacy Policy</a>
            </p>
        </div>
        <div class="loginMessage">
            <p>Already have an account? <a href="login.php">Login Here</a></p>
        </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>