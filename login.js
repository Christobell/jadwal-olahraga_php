console.log('')

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const emailInput = document.getElementById("email-phone");
    const passwordInput = document.getElementById("password");
    const snackbar = document.getElementById("snackbar");
    const confirmModal = document.getElementById("confirmModal");
    const loginSubmit = document.getElementById("loginSubmit");
    let isButtonClicked = false;

    loginSubmit.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent form submission to show confirmation modal
        isButtonClicked = true;
        confirmModal.style.display = "flex"; // Show confirmation modal
    });

    document.getElementById("confirmYes").onclick = function () {
        if (isButtonClicked) {
            confirmModal.style.display = "none"; // Hide confirmation modal
            isButtonClicked = false;

            const email = emailInput.value.trim();
            const password = passwordInput.value.trim();

            // Simulate login with the stored session (or perform the actual backend login check)
            if (email && password) {
                // Simulating a successful login (Normally this will happen after checking in the database)
                localStorage.setItem("userEmail", email); // Store user email in localStorage
                localStorage.setItem("userPassword", password); // Store password in localStorage

                snackbar.className = "snackbar show"; // Show snackbar message
                setTimeout(() => {
                    snackbar.className = snackbar.className.replace("show", "");
                    window.location.href = "Admin.php"; // Redirect to Admin page
                }, 3000);
            } else {
                snackbar.className = "snackbar show"; // Show error snackbar if login fails
                setTimeout(() => {
                    snackbar.className = snackbar.className.replace("show", "");
                }, 3000);
            }
        }
    };

    document.getElementById("confirmNo").onclick = function () {
        confirmModal.style.display = "none"; // Close modal if user clicks "No"
        isButtonClicked = false;
    };

    window.onclick = function (event) {
        if (event.target == confirmModal) {
            confirmModal.style.display = "none"; // Close modal if click outside
            isButtonClicked = false;
        }
    };
});
