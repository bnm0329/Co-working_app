// JavaScript for admin_user_sessions_view.php extracted from inline <script> blocks
function toggleDetails(sessionId) {
    var row = document.getElementById("details-" + sessionId);
    row.style.display = (row.style.display === "table-row") ? "none" : "table-row";
}
