#!/usr/bin/env php
<?php

function printCalendar($year, $month) {
    // Get the first and last days of the month
    $firstDayOfMonth = new DateTime("$year-$month-01");
    $lastDayOfMonth = (clone $firstDayOfMonth)->modify('last day of this month');
    $today = new DateTime();

    // Print the month and year header
    echo $firstDayOfMonth->format('F Y') . PHP_EOL;
    echo "Mo Tu We Th Fr Sa Su" . PHP_EOL;

    // Calculate the day of the week for the first day of the month (1=Monday, 7=Sunday)
    $firstDayOfWeek = (int)$firstDayOfMonth->format('N');
    
    // Print leading spaces for the first week
    for ($i = 1; $i < $firstDayOfWeek; $i++) {
        echo "   ";
    }

    // Print the days of the month
    $currentDay = clone $firstDayOfMonth;
    while ($currentDay <= $lastDayOfMonth) {
        $day = $currentDay->format('j');

        // Highlight today if it falls within the displayed month
        if ($currentDay->format('Y-m-d') == $today->format('Y-m-d')) {
            printf("[%2d] ", $day);  // Brackets around today's date
        } else {
            printf("%2d ", $day);
        }

        // Move to the next line after Sunday
        if ((int)$currentDay->format('N') == 7) {
            echo PHP_EOL;
        }

        // Move to the next day
        $currentDay->modify('+1 day');
    }

    // Print trailing new line if the last day of the month is not Sunday
    if ((int)$lastDayOfMonth->format('N') != 7) {
        echo PHP_EOL;
    }
}

// Get the current year and month
$year = (int)date('Y');
$month = (int)date('m');

// Parse command line arguments for month and year adjustment
$options = getopt('y:m:');
if (isset($options['y'])) {
    $year = (int)$options['y'];
}
if (isset($options['m'])) {
    $month = (int)$options['m'];
}

// Print the calendar
printCalendar($year, $month);

?>
