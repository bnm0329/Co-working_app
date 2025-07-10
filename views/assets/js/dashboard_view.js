function showForm(formId) {
    const h1 = document.querySelector('h1');
    const newUserForm = document.getElementById("newUserForm");
    const returningUserForm = document.getElementById("returningUserForm");
    const selectedForm = document.getElementById(formId);
    if (selectedForm.style.display === "block") {
        selectedForm.style.display = "none";
        h1.style.display = "block";
    } else {
        newUserForm.style.display = "none";
        returningUserForm.style.display = "none";
        h1.style.display = "none";
        selectedForm.style.display = "block";
    }
}
window.onload = function () {
    const msg = document.getElementById("successMessage");
    if (msg) {
        setTimeout(() => msg.style.opacity = "0", 5000);
    }
};
