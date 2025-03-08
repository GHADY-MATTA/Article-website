
      
document.addEventListener("DOMContentLoaded", async () => {
    // console.log("hello my friend");
    try {
        // website-wallet\server(api)\php\profileData.php
        const response = await fetch("/website-wallet/server(api)/php/profileData.php");
        const data = await response.json();
        console.log(data);
        
// \website-wallet\client\assets\front\login.html
        if (data.error) {
            window.location.href = "/website-wallet/client/assets/front/login.html"; // Redirect if not logged in
            return;
        }

        // Update profile details
        document.getElementById("username").textContent = data.username;
        document.getElementById("email").textContent = data.email;
        document.getElementById("phone").textContent = data.phone || "Not Provided";
        document.getElementById("address").textContent = data.address || "Not Provided";

 // Update balance
        // Update balance
document.getElementById("balance").textContent = data.balance ? `$${data.balance}` : "$1";  // Show balance or default to $1
  // Default to $1 if no balance found

        // Update greeting message
        document.getElementById("greeting").textContent = "Welcome, " + data.username;
    } catch (error) {
        console.error("Error fetching profile data:", error);
        document.querySelector(".profile-body").innerHTML = `<p style="color:red;">Failed to load profile.</p>`;
    }
});

// Logout functionality
document.getElementById("logout").addEventListener("click", async () => {
    await fetch("/website-wallet/server(api)/php/logout.php");
    window.location.href = "/website-wallet/client/assets/front/login.html"; // Redirect to login page
});
//website-wallet\server(api)\php\logout.php
// website-wallet\client\assets\front\login.html