// JavaScript for admin_pricing_view.php extracted from inline <script> blocks
function editRow(id, type, label, duration, price) {
  document.querySelector('input[name="id"]').value = id;
  document.querySelector('select[name="type"]').value = type;
  document.querySelector('input[name="label"]').value = label;
  document.querySelector('input[name="duration_minutes"]').value = duration || '';
  document.querySelector('input[name="price"]').value = price;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}
