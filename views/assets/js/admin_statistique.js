// JavaScript for admin_statistique_view.php extracted from inline <script> blocks
function switchRevenue(type) {
  document.querySelectorAll('.tab-button').forEach(btn => {
    btn.classList.remove('active');
  });
  const indexMap = {
    'combined': 1,
    'sessions': 2,
    'services': 3,
    'subscriptions': 4
  };
  document.querySelector(`.tab-button:nth-child(${indexMap[type]})`).classList.add('active');
  document.querySelectorAll('.rev-tab').forEach(tab => {
    tab.style.display = 'none';
  });
  document.getElementById('rev_' + type).style.display = 'block';
}
function showSection(id) {
  document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
  document.getElementById(id).classList.add('active');
}
function exportRevenueTableToCSV(button) {
    const tab = button.closest('.rev-tab');
    const table = tab.querySelector('table');
    if (!table) return;
    let csv = [];
    const rows = table.querySelectorAll('tr');
    rows.forEach(row => {
        const cols = row.querySelectorAll('th, td');
        let rowData = [];
        cols.forEach(col => {
            const text = col.innerText.replace(/"/g, '""');
            rowData.push(`"${text}"`);
        });
        csv.push(rowData.join(","));
    });
    const csvBlob = new Blob([csv.join("\n")], { type: "text/csv" });
    const url = URL.createObjectURL(csvBlob);
    const filename = tab.querySelector('h2').innerText.replace(/[^a-z0-9]/gi, '_').toLowerCase() + "_" + new Date().toISOString().slice(0, 10) + ".csv";
    const a = document.createElement("a");
    a.setAttribute("href", url);
    a.setAttribute("download", filename);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
