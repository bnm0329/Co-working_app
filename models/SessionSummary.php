<?php
function format_duration($seconds) {
    $days = floor($seconds / 86400);
    $hours = floor(($seconds % 86400) / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    if ($days > 0) {
        return sprintf("%d day%s, %02d:%02d:%02d", $days, $days > 1 ? 's' : '', $hours, $minutes, $seconds);
    } else {
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }
}
?>
