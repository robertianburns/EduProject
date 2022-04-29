<?php
session_start();

/*
  Check if the admin is already logged in. If not, redirect to login page. */
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

/*
  Get the database credentials from the database file. If the file was already included, it will not include it again. */
require_once "functions/database.php";

/*
  Define numerous variables and give them empty values. */
$updatedPassword = $confirmPassword = $updatedPasswordError = $confirmPasswordError = "";

/*
  This processes the data from the form when it is submitted.

    - First, the new password is validated. If it isn't empty and is more than nine characters, then POST it.
 
    - If there are no errors, then the SQL query is prepared. The variables are binded to the prepared statement as
      parameters, and it is then executed. This prevents any possibility of an SQL injection.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate the new password.
    if (empty(trim($_POST["updatedPassword"]))) {
        $updatedPasswordError = "Please enter your new password!";
    } elseif (strlen(trim($_POST["updatedPassword"])) < 8) {
        $updatedPasswordError = "Your password must have at least ten characters!";
    } else {
        $updatedPassword = trim($_POST["updatedPassword"]);
    }

    // Confirm the admin's new password.
    if (empty(trim($_POST["confirmPassword"]))) {
        $confirmPasswordError = "Please confirm your new password!";
    } else {
        $confirmPassword = trim($_POST["confirmPassword"]);
        if (empty($updatedPasswordError) && ($updatedPassword != $confirmPassword)) {
            $confirmPasswordError = "Those passwords did not match!";
        }
    }

    // Check for any errors before preparing the SQL query.
    if (empty($updatedPasswordError) && empty($confirmPasswordError)) {
        if ($query = $connection->prepare("UPDATE admin_details SET password = ? WHERE id = ?")) {
            $updatedPassword = password_hash($updatedPassword, PASSWORD_DEFAULT); // Hash the updated password.
            $param_id = $_SESSION["id"];
            $query->bind_param("si", $updatedPassword, $param_id);

            if ($query->execute()) { // As the password has successfully been updated, destroy the session and redirect the admin to the login page.
                session_destroy();
                header("Location: login.php");
                exit();
            } else {
                echo "ERROR CODE BOOM (ADMIN): That password change request couldn't be performed. Please try again!";
            }
            $query->close();
        } else {
            echo "ERROR CODE RAIN (ADMIN): That password change request couldn't be prepared. Please try again!";
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
    <title>Reset Password (Admin) - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css" />
    <link rel="stylesheet" href="css/form.css" />
</head>

<body class="adminbody">
    <div class="formContainer">
        <div class="login">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="textContainer">
                    <label>Reset Password</label>
                </div>
                <input type="password" name="updatedPassword" placeholder="New password" class="<?php echo (!empty($updatedPasswordError)) ? 'is-invalid' : ''; ?>" value="<?php echo $updatedPassword; ?>">
                <span class="invalid-feedback"><?php echo $updatedPasswordError; ?></span>
                <input type="password" name="confirmPassword" placeholder="Confirm new password" class="<?php echo (!empty($confirmPasswordError)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirmPasswordError; ?></span>
                <button type="submit">Change password</button>
                <a href="home.php">I don't want to change it!</a>
            </form>
        </div>
    </div>
</body>

</html>