function showTab(tabName) {
    var tabs = document.getElementsByClassName("tab-content");
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = "none";
    }
    document.getElementById(tabName).style.display = "block";
    var buttons = document.querySelectorAll(".tabs button");
    buttons.forEach(function(btn) {
        btn.classList.remove("active");
    });
    document.getElementById(tabName + "-btn").classList.add("active");
}
window.onload = function() {
    showTab("subscribers");
}

document.addEventListener('DOMContentLoaded', function() {
    // For disabling fields if user is selected
    const userSelect = document.getElementById('userSelect');
    const inputsToToggle = document.querySelectorAll('.disable-if-user-selected');
    if (userSelect) {
        function toggleInputs() {
            const isUserSelected = userSelect.value !== '';
            inputsToToggle.forEach(input => {
                input.disabled = isUserSelected;
            });
        }
        toggleInputs();
        userSelect.addEventListener('change', toggleInputs);
    }
});

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
