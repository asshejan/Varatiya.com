<?php

include '../config.php';
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/admin.css">
    <!-- loading bar -->
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="../css/flash.css">
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Varatiya Admin</title>
</head>

<body>
    <!-- mobile view -->
    <div id="mobileview">
        <h5>Admin panel doesn't show in mobile view</h4>
    </div>
  
    <!-- nav bar -->
    <nav class="uppernav">
        <div class="logo">
            <p>Varatiya<h6>com</h6></p>
        </div>
        <div class="logout">
        <a href="../admin/index.php"><button class="btn btn-primary">Logout</button></a>
        </div>
    </nav>
    <nav class="sidenav">
        <ul>
            <li class="pagebtn active"><img src="#">&nbsp&nbsp&nbsp Dashboard</li>
            <li class="pagebtn"><img src="#">&nbsp&nbsp&nbsp Post Removal</li>
            <li class="pagebtn"><img src="#">&nbsp&nbsp&nbsp Accounts</li>            

        </ul>
    </nav>

    <!-- main section -->
    <div class="mainscreen">
        <iframe class="frames frame1 active" src="./dashboard.php" frameborder="0"></iframe>
        <iframe class="frames frame2" src="./post_approval.php" frameborder="0"></iframe>
        <iframe class="frames frame3" src="./account.php" frameborder="0"></iframe>
    </div>
</body>

<script>
    // Select all page buttons and iframe elements
    const pageButtons = document.querySelectorAll('.pagebtn');
    const frames = document.querySelectorAll('.frames');

    // Add click event to each button
    pageButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and frames
            pageButtons.forEach(btn => btn.classList.remove('active'));
            frames.forEach(frame => frame.classList.remove('active'));

            button.classList.add('active');
            frames[index].classList.add('active');
        });
    });
</script>


</html>
