<head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
    <h3>Online-creator of interactive stories</h3>
    <h3>Coursework - Alice Hil, IS-11</h3>
</div>
<div style="text-align: center">
    <h1>Welcome to Library!</h1>
    <h3>Choose the story to play or edit</h3>
</div>

<?php
$message = "There is no Episode with this ID";
echo "<script type='text/javascript'>alert('$message');</script>";

include_once 'allConnections.php';

$lib = Library::getStories();
echo getStoriesList($lib);