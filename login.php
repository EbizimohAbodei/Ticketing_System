<?php include 'includes/sessions.php'; ?>
<?php include 'includes/db.php'; ?>
<?php 
if(isset($_POST["login"])) { 

    // Sanitizing user entry
    $email = sanitazeInputs($_POST["email"]);
    $email = mysqli_real_escape_string($connection, $_POST['email']);

    $pass = sanitazeInputs($_POST["password"]);
    $pass = mysqli_real_escape_string($connection, $_POST['password']);

    // Encrypting user password
    $hashFormat = "_J9..rasm"; //Standard DES
    $salt = 'whateversaltisokaytoouthere$'; 
    $hashFormatAndSalt = $hashFormat . $salt;
    $password = crypt($pass, $hashFormatAndSalt);

    // SQL sattement requesting data from the 'users' table
    $query = "SELECT * FROM users ";
    $query .= "WHERE email = '$email'";

    $dbdata = mysqli_query($connection, $query);
    $userProfile = mysqli_fetch_assoc($dbdata);

    // Checks if data returned from database is not empty
    if ($userProfile && $userProfile['email'] !== '') {
        $userEmail = $userProfile['email'];
        $userPassword = $userProfile['password'];
        $userFirstname = $userProfile['firstname'];
        
        if ($userEmail == $email && $userPassword == $password) { 
            // if email and password match data from database
            login();  // Call login function
            setcookie('PHPCookie', $userFirstname, time() + (60*60*24*7), '/');
            ?> <script>
            window.location = "tickets.php"
            </script> <?; // Redirect to tickets page
            exit; // Stop further code running
        } else {
            $loginError = true;
        }
    } else {
        $loginError = true;
    } 

    $connection->close();
}
?>
<?php include 'includes/header.php'; ?>

<main>
    <div class="loginContainer">
        <h5><? if (isset($loginError)){echo '<p class="loginError">Invalid email and/or password</p>';} ?></h5>
        <h4 class="loginHeader">Login</h4>
        <form class="loginForm" action="login.php" method="POST">
            <label class="loginLabels">Email Address: </label>
            <input class="createInputs" type="email" name="email" required>
            <label class="loginLabels">Password: </label>
            <input class="createInputs" type="password" name="password" required>
            <input class="loginBtn" name="login" type="submit" value="Login">
        </form>
    </div>
</main>
<?php include 'includes/footer.php'; ?>