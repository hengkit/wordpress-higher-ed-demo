<?php

// Get the total number of commits in the git repo and redirect to a favicon that shows the last digit.

$count = exec('git rev-list --all --count');
$last_digit = substr($count, -1);

$zero_nine = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

// Assume that the counting git command will fail and set an error icon.
$icon = 'x';
// Change the icon to a number if it succeeded.
if (in_array($last_digit, $zero_nine)) {
    $icon = $last_digit;
}

header("Location: /wp-content/themes/understrap-child/favicon/".$last_digit.".ico",TRUE,307);
