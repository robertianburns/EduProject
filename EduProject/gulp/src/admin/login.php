<?php
session_start();

/*
  Check if the admin is already logged in. If they are, they are redirected to the home page. */
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: home.php");
    exit;
}

/*
  Get the database credentials from the database file. If the file was already included, it will not include it again. */
require_once "functions/database.php";

/*
  Define username and password and give them empty values. */
$username = $password = $usernameError = $passwordError = $loginError = "";

/*
  This processes the data from the form when it is submitted.

    - First, the username and password fields are checked to see if they are empty. If they are, an error is shown. If not,
      they are POSTed.

    - If there are no errors, then the SQL query is prepared. The variables are binded to the prepared statement as
      parameters, and it is then executed. This prevents any possibility of an SQL injection.
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if the admin has entered a username
    if (empty(trim($_POST["username"]))) {
        $usernameError = "This cannot be empty. Please enter your username!";
    } else {
        $username = trim($_POST["username"]);
    }

    //  Check if the admin has entered a password
    if (empty(trim($_POST["password"]))) {
        $passwordError = "This cannot be empty. Please enter your password!";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check if there are any errors and proceed with logging in if not.
    if (empty($usernameError) && empty($passwordError)) {
        if ($query = $connection->prepare("SELECT id, username, password FROM admin_details WHERE username = ?")) {
            $enteredUsername = $username;
            $query->bind_param("s", $enteredUsername);

            // Attempt to execute the prepared statement.
            if ($query->execute()) {
                $query->store_result();

                // Check if the username exists in the database. If it does, then the password is attempted to be verified.
                if ($query->num_rows == 1) {
                    $query->bind_result($id, $username, $hashedPassword);
                    if ($query->fetch()) {
                        if (password_verify($password, $hashedPassword)) {
                            session_start();
                            // Store username into a session variable to use later.
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            header("Location: home.php"); // Redirect the admin to home page as they have logged in.
                        } else { // The password is not valid.
                            $loginError = "That password is not valid!";
                        }
                    }
                } else { // The username doesn't exist.
                    $loginError = "That username doesn't exist!";
                }
            } else { // The SQL query couldn't be executed for some reason...
                echo "ERROR CODE DRAGON (ADMIN): That login request couldn't be performed. Please try again!";
            }
            $query->close();
        } else { // The SQL query couldn't be executed for some reason...
            echo "ERROR CODE TITAN (ADMIN): That login request couldn't be prepared. Please try again!";
        }
    }
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../manifest.json" rel="manifest">
    <link rel="shortcut icon" href="images/icon_x48.png" />
    <title>Login (Admin) - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css" />
    <link rel="stylesheet" href="css/form.css" />
</head>

<body class="adminbody">
    <div class="formContainer">
        <div class="login">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="textContainer">
                    <label>Admin login</label>
                </div>
                <input type="text" name="username" placeholder="Username" class=" <?php echo (!empty($usernameError)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $usernameError; ?></span>
                <input type="password" name="password" placeholder="Password" class="<?php echo (!empty($passwordError)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $passwordError; ?></span>
                <button type="submit">Login</button>
                <a href="register.php">Register an admin account here</a>
            </form>
        </div>
    </div>
</body>

</html>