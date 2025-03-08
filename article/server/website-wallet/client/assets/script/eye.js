function togglePassword() {
    var passwordField = document.getElementById("password");
    var eyeIcon = document.getElementById("eye-icon");

    console.log("Password visibility toggled");

    if (passwordField.type === "password") {
        passwordField.type = "text"; // Change to visible text
        eyeIcon.classList.remove("far", "fa-eye"); // Change eye icon to open
        eyeIcon.classList.add("fas", "fa-eye-slash");
    } else {
        passwordField.type = "password"; // Hide password
        eyeIcon.classList.remove("fas", "fa-eye-slash"); // Change eye icon to closed
        eyeIcon.classList.add("far", "fa-eye");
    }
}
