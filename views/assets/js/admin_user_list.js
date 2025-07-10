// JavaScript for admin_user_list.php extracted from inline <script> blocks
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
            // Escape double quotes
            const data = col.innerText.replace(/"/g, '""');
            rowData.push(`"${data}"`);
        });
        csv.push(rowData.join(","));
    });
    downloadCSV(csv.join("\n"), filename);
}
