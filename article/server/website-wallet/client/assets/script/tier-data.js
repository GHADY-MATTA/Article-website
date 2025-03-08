
function saveTier(tier) {
    var user_id = "123"; // This could be dynamically assigned, for example from a session
    var formData = new FormData();
    formData.append("user_id", user_id);
    formData.append("tier", tier);
    
    // Send data to save.sql.php using AJAX
    // FSW\website-wallet\server(api)\php\save-sql.php 
    fetch('/website-wallet/server(api)/php/save-sql.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);  // Show the success/error message
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// /website-wallet/server(api) / php / save - sql.php
// 'save.sql.php'