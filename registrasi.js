document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const fullnameInput = document.getElementById("fullname");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm-password");
    const popup = document.getElementById("popup");
    const popupMessage = document.getElementById("popup-message");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form from submitting

        const fullname = fullnameInput.value.trim();
        const email = emailInput.value.trim();
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (!fullname || !email || !password || !confirmPassword) {
            showPopup("Semua kolom harus diisi.");
            return;
        }

        if (password !== confirmPassword) {
            showPopup("Password tidak cocok, coba lagi.");
            return;
        }

        showPopup("Registrasi berhasil! Data Anda valid.");
    });

    function showPopup(message) {
        popupMessage.textContent = message;
        popup.classList.remove("hidden");
    }

    window.closePopup = function () {
        popup.classList.add("hidden");
    };
});
