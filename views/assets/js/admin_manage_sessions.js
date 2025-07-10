// JavaScript for admin_manage_sessions_view.php extracted from inline <script> blocks
function stopSession(sessionId, seatId) {
    if (confirm("Êtes-vous sûr de vouloir arrêter cette session ?")) {
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "stop_timer.php";
        var inputSession = document.createElement("input");
        inputSession.type = "hidden";
        inputSession.name = "session_id";
        inputSession.value = sessionId;
        form.appendChild(inputSession);
        var inputSeat = document.createElement("input");
        inputSeat.type = "hidden";
        inputSeat.name = "seat_id";
        inputSeat.value = seatId;
        form.appendChild(inputSeat);
        document.body.appendChild(form);
        form.submit();
    }
}

function downloadCSV(csv, filename) {
    const csvFile = new Blob([csv], { type: "text/csv" });
    const downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

function exportTableToCSV(filename) {
    const rows = document.querySelectorAll("table tr");
    let csv = [];
    rows.forEach(row => {
        const cols = row.querySelectorAll("td, th");
        const rowData = [];
        cols.forEach(col => {
            // Échapper les guillemets doubles
            const data = col.innerText.replace(/"/g, '""');
            rowData.push(`"${data}"`);
        });
        csv.push(rowData.join(","));
    });
    downloadCSV(csv.join("\n"), filename);
}

function updateSeat(sessionId) {
    const select = document.getElementById("seatSelect_" + sessionId);
    const newSeatId = select.value;
    fetch("../controllers/update_seat.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `session_id=${sessionId}&seat_id=${newSeatId}`
    })
    .then(response => response.text())
    .then(result => {
        alert(result.trim());
        location.reload();
    })
    .catch(error => {
        console.error("Erreur lors de la mise à jour du siège:", error);
        alert("Une erreur s'est produite.");
    });
}
