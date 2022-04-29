<?php
session_start();

/*
  Check if the end user is already logged in. If not, redirect to login page. */
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

/*
  Get the database credentials from the database file. If the file was already included, it will not include it again. */
require_once "functions/database.php";

/*
  Content */
$contentQuery = "SELECT * FROM content";
$contentResult = $connection->query($contentQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../manifest.json" rel="manifest">
    <link rel="shortcut icon" href="images/icon_x48.png" />
    <title>Edit content (admin) - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css" />
    <link rel="stylesheet" href="css/admin.css" />
</head>

<body>

    <div class="margin">

        <div class="white-box">
            <h1>Add or edit the content of EduProject</h1>
            <a href="home.php" class="button blue-button"> Back to admin home </a>
        </div>

        <div class="white-box">
            <div class="tableContainer">
                <h2>Add content</h2>
                <table>
                    <tr>
                        <th>Module</th>
                        <th>Paragraph number</th>
                        <th>Section text</th>
                    </tr>

                    <tr><form action="functions/addcontent.php" method="post">
                        <td><input type="text" size="5" name="addModule"></td>
                        <td><input type="number" name="addSectionNumber"></td>
                        <td><textarea type="text" rows="13" cols="50" name="addSectionText" placeholder="Enter the content text here"></textarea></td>
                        <td><input type="submit" name="form" value="Submit new content"><td>
                        </form></tr>
                </table>
            </div>
        </div>


        <div class="white-box">
            <div class="tableContainer">
                <h2>Edit content</h2>
                <table>
                    <tr>
                        <th>Module</th>
                        <th>Paragraph number</th>
                        <th>Section text</th>
                    </tr>

                    <?php
                    while ($row = mysqli_fetch_array($contentResult)) {
                        echo '<tr><form action="functions/updatecontent.php" method="post">';
                        echo '<td><input type="text" size="5" name="updatedModule" value="' . $row['module'] . '"></td>';
                        echo '<td><input type="number" name="updatedSectionNumber" value="' . $row['section_number'] . '"></td>';
                        echo '<td><textarea type="text" rows="13" cols="50" name="updatedSectionText">' . htmlspecialchars($row['section_text']) . '</textarea></td>';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<td><input type="submit" name="form" value="Submit content edit"><td>';
                        echo '</form></tr>';
                    }
                    ?>
                </table>
            </div>
        </div>

    </div>

</body>

</html>