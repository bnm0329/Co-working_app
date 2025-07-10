// JavaScript for admin_service_view.php extracted from inline <script> blocks
function processRequest(request_id, action) {
    let actionText = (action === 'approve') ? 'approuver' : 'rejeter';
    if (confirm("Êtes-vous sûr de vouloir " + actionText + " cette demande ?")) {
        fetch(action + "_request.php", {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: "request_id=" + request_id
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('ajax-message').innerHTML = data;
            setTimeout(function() {
                location.reload();
            }, 2000);
        })
        .catch(error => {
            document.getElementById('ajax-message').innerHTML = "Erreur : " + error;
        });
    }
}
