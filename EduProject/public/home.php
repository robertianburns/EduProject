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
  Get the experience. This is got when the page is loaded so it is always up to date. If stored in a session variable, the experience number won't update during the session. */
$experienceQuery = $connection->query("SELECT experience FROM accounts_details WHERE username = '" . $_SESSION["username"] . "'");
$experienceResult = mysqli_fetch_array($experienceQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../manifest.json" rel="manifest">
    <link rel="shortcut icon" href="images/icon_x48.png" />
    <title>Home - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js" defer></script>
</head>

<body class="coloured-body">

    <div class="home-header">
        <?php
        include_once('components/navbar.php');
        ?>
    </div>
    <div class="title-box">
        <h1 class="responsive-h1">Hello, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</h1>
        <h2>You have <b><?php echo $experienceResult['experience']; ?></b> experience!</h2>
    </div>

    <section class="intro">
        <div class="intro-row">
            <div class="intro-column">
                <h1>What is this?</h1>
                <p>This is a mobile-optimised progressive web application to teach first-year University students, or
                    even
                    those who know nothing about Computer Science, the fundamentals of Web Development and Java
                    Programming.
                    This is not intended to replace
                    proper teaching modules at high-level educational institutions nor cover as much as one, but this is
                    rather an introductory web application to teach the core aspects in fun, engaging ways which you can
                    take into the proper modules
                    as a head start!</p>
                <p>The Web Development module will cover a variety of current web technologies, providing you a strong
                    knowledge foundation to create simple standards-compliant web pages. The objective is to learn about
                    the vitals of developing stuff for the Web, and dive into the
                    intricacies
                    HTML, CSS, and JavaScript!</p>
                <p>The Java Programming module will establish essential concepts and skills required to create simple
                    programs in the Java programming language. Learn the fundamentals of programming through Java, and
                    become
                    knowledgeable on variables, loops,
                    methods, and more!</p>
            </div>
            <div class="intro-column">
                <h1>The ultimate test!</h1>
                <p>The quizzes you will encounter will evaluate your knowledge of the entirety of the modules you
                    partake in! For Web Development, this will be comprised of HTML,
                    CSS, and JavaScript questions relating to the material we've covered in them! For Java Programming,
                    this will be about learning how to write code and create programmes, and skills will be taught that
                    are transferrable to other programming languages!</p>
                <p>The quizzes are composed of twenty-five random multiple-choice questions, and are great tools
                    for checking your understanding of the aforementioned topics as quizzes are accessible and enjoyable
                    to
                    partake in! The answer is in front of you – you just have to figure out which one to choose!</p>
            </div>
        </div>
    </section>

    <section class="aims">
        <div class="white-box">
            <h1>What's the purpose?</h1>
            <div class="aims-row">
                <div class="aims-column">
                    <h3>To learn!</h3>
                    <p>The goal is for you to learn and have fun while doing so! Technology and the internet has become
                        paramount in modern times, so become informed on the building blocks!</p>
                </div>
                <div class="aims-column">
                    <h3>To test yourself!</h3>
                    <p>Interact with EduProject and test yourself! Gain experience through quizzes and activities and
                        compare yourself against other accounts on the leader board!</p>
                </div>
                <div class="aims-column">
                    <h3>A university project!</h3>
                    <p>This is for my final-year project. I chose to create a mobile-optimised progressive web
                        application to teach first-year University students the fundamentals of Web Development and Java
                        Programming.</p>
                </div>
            </div>
        </div>
    </section>

    <?php
    include_once('components/footer.php');
    ?>

</body>

</html>