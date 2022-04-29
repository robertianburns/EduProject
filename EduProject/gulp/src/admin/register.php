<?php
require_once "functions/database.php";

/*
  Check if the admin is already logged in. If they are, they are redirected to the home page. */
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: home.php");
    exit;
}

/*
  Define numerous variables and give them empty values. */
$username = $usernameError = $password = $passwordConfirmation = $passwordError = $passwordConfirmationError = "";

/*
  This processes the data from the form when it is submitted.

    - First, the username field is checked to make sure it isn't empty nor has characters it shouldn't. If there are no errors
      and it doesn't already exist, then the username gets POSTed.

    - If there are no errors, then the SQL query is prepared. The variables are binded to the prepared statement as
      parameters, and it is then executed. This prevents any possibility of an SQL injection.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate the entered username.
    if (empty(trim($_POST["username"]))) {
        $usernameError = "This cannot be empty. Please enter a username!";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $usernameError = "Your username can only contain letters, numbers, and underscores!";
    } else {
        // Prepare a select statement.
        if ($query = $connection->prepare("SELECT id FROM admin_details WHERE username = ?")) {
            $enteredUsername = trim($_POST["username"]);
            $query->bind_param("s", $enteredUsername);

            if ($query->execute()) {
                $query->store_result();

                // Check if the entered username exists.
                if ($query->num_rows == 1) {
                    $usernameError = "This username is already taken!";
                } else { // If not, POST it!
                    $username = trim($_POST["username"]);
                }
            } else { // The SQL query couldn't be executed for some reason...
                echo "ERROR CODE GOAT (ADMIN): That register request couldn't be performed. Please try again!";
            }
            $query->close();
        } else {
            echo "ERROR CODE WATER (ADMIN): That register request couldn't be prepared. Please try again!";
        }
    }

    // Validate the entered password.
    if (empty(trim($_POST["password"]))) {
        $passwordError = "Please enter a password!";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $passwordError = "Your password must have at least eight characters!";
    } else {
        $password = trim($_POST["password"]);
    }

    // Make sure the admin confirms their password.
    if (empty(trim($_POST["passwordConfirmation"]))) {
        $passwordConfirmationError = "Please confirm your password!";
    } else {
        $passwordConfirmation = trim($_POST["passwordConfirmation"]);
        if (empty($passwordError) && ($password != $passwordConfirmation)) {
            $passwordConfirmationError = "Those passwords did not match. Please try again!";
        }
    }

    // Check for any input errors before inserting values into the database.
    if (empty($usernameError) && empty($passwordError) && empty($passwordConfirmationError)) {

        // Add the admin's details into the admin_details table.
        $detailsQuery = $connection->prepare("INSERT INTO admin_details (username, password) VALUES (?, ?)");
        $enteredUsername = $username;
        $enteredPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password using a strong one-way hashing algorithm.
        $detailsQuery->bind_param("ss", $enteredUsername, $enteredPassword);

        // If registration is successful, then...
        if ($detailsQuery->execute()) {
            // ...redirect to the login page.
            header("Location: login.php");
        }
        // The SQL query couldn't be executed for some reason...
        else {
            echo "ERROR CODE JUMP (ADMIN): That register request couldn't be processed. Please try again!";
        }
        $detailsQuery->close();
        $connection->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../manifest.json" rel="manifest">
    <link rel="shortcut icon" href="images/icon_x48.png" />
    <title>Register (Admin) - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css" />
    <link rel="stylesheet" href="css/form.css" />
</head>

<body class="adminbody">
    <div class="formContainer">
        <div class="signup">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="textContainer">
                    <label>Create an EduProject admin account</label>
                </div>
                <input type="text" name="username" placeholder="Username" class="<?php echo (!empty($usernameError)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $usernameError; ?></span>
                <input type="password" name="password" placeholder="Password" class="<?php echo (!empty($passwordError)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $passwordError; ?></span>
                <input type="password" name="passwordConfirmation" placeholder="Confirm Password" class="<?php echo (!empty($passwordConfirmationError)) ? 'is-invalid' : ''; ?>" value="<?php echo $passwordConfirmation; ?>">
                <span class="invalid-feedback"><?php echo $passwordConfirmationError; ?></span> <button type="submit">Create</button>
                <a href="login.php">Have an admin account? Sign in here.</a>
            </form>
        </div>
    </div>
</body>

</html>