<?php
include("functions.php");

$folders = getFolders("../");
$zip = getFiles("../src/");
$nb_folder = count($folders);
$nb_zip = count($zip);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comm</title>
    <link rel="stylesheet" href="assets/style.css">
    <script type="module" src="script.js" defer></script>
</head>

<body>

    <div id="loading">
        <!-- /* From Uiverse.io by abrahamcalsin */ -->
        <div class="dot-spinner">
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
        </div>
        <!-- /*  */ -->
    </div>

    <button id="back"></button>
    <div id="folders"></div>

    <div id="file-reader-space">

        <button id="close-file-reader">
            X
        </button>

        <div id="file-reader"></div>

    </div>



</body>

</html>