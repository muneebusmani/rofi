#!/bin/bash

# Get the current year and month
year=$(date '+%Y')
month=$(date '+%m')

# Parse command line arguments for month and year adjustment
while getopts "y:m:" opt; do
    case $opt in
        y) year=$OPTARG ;;
        m) month=$OPTARG ;;
        *) echo "Usage: $0 [-y year] [-m month]" >&2; exit 1 ;;
    esac
done

# Run the PHP script to generate the calendar
calendar_output=$($HOME/.config/rofi/launchers/calendar/calendar.php -y "$year" -m "$month")

# Determine the number of lines in the calendar output
line_count=$(echo "$calendar_output" | wc -l)

# Calculate the window height based on the number of lines
window_height=$((line_count * 50 + 50)) # 20 pixels per line + 50 pixels for padding

# Display the calendar using Rofi
echo "$calendar_output" | rofi -dmenu -i -p "Calendar" -theme-str "window {width: 17.5%; height: ${window_height}px;}"
