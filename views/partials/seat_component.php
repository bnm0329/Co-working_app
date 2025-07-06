<?php
function dynamicSeat($class, $seatNumber, $seats) {
    if (!isset($seats[$seatNumber])) return "";
    $seat = $seats[$seatNumber];
    $statusClass = ($seat['status'] === 'available') ? 'available' : 'occupied';
    return "<div class='{$class} seat {$statusClass}' data-seat-number='{$seat['seat_number']}' onclick='selectSeat({$seat['seat_id']}, \"{$seat['status']}\")'><span>{$seat['seat_number']}</span></div>";
}
?>
