function showAnimatedAlert(message) {
    const alertDiv = document.getElementById("customAlert");
    alertDiv.innerHTML = message;
    alertDiv.style.display = "block";
    let opacity = 0;
    alertDiv.style.opacity = opacity;
    const fadeIn = setInterval(() => {
        opacity += 0.05;
        alertDiv.style.opacity = opacity;
        if (opacity >= 1) {
            clearInterval(fadeIn);
            setTimeout(() => {
                const fadeOut = setInterval(() => {
                    opacity -= 0.05;
                    alertDiv.style.opacity = opacity;
                    if (opacity <= 0) {
                        clearInterval(fadeOut);
                        alertDiv.style.display = "none";
                    }
                }, 50);
            }, 3500);
        }
    }, 50);
}
function selectSeat(seatId, status) {
    if (status === 'occupied') {
        showAnimatedAlert("Cette place est déjà occupée. Veuillez sélectionner une autre place.");
        return;
    }
    document.getElementById('seat_id').value = seatId;
    document.getElementById('seatForm').submit();
}
setInterval(() => history.go(0), 25000); // silent refresh every 25s
