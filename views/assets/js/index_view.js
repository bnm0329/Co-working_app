function showSection(id) {
  ['section2', 'pricingSection', 'section3'].forEach(s => document.getElementById(s).style.display = s === id ? 'block' : 'none');
}
window.onload = function() {
  showSection('section2');
  const status = document.getElementById("statusMessage");
  if (status) setTimeout(() => status.style.display = 'none', 5000);
};
document.addEventListener('DOMContentLoaded', function () {
    const alertBox = document.getElementById('statusAlert');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 10000);
    }
});
(function() {
  let clickCount = 0;
  const btn = document.getElementById('continueBtn');
  btn.addEventListener('click', function() {
    if (++clickCount >= 2) window.location.href = 'dashboard.php';
  });
})();
