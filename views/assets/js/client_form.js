window.onload = function() {
    const message = document.getElementById("errorMessage");
    if (message) {
        setTimeout(() => { message.style.opacity = "0"; }, 2500);
    }
};
document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const responseBox = document.getElementById("formResponse");
    responseBox.innerHTML = "";
    fetch("../controllers/MySpaceController.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        responseBox.innerHTML = data;
    });
});
