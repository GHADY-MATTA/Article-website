document.getElementById("showP2PNumber").addEventListener("click", function() {
    const p2pDisplay = document.getElementById("p2pnumber_display");

    // Check if the P2P number is already visible
    if (p2pDisplay.style.display === "none" || p2pDisplay.style.display === "") {
        // Fetch and display the P2P number
        fetch("/website-wallet/server(api)/php/p2pnumber.php")
            .then(response => response.text())
            .then(data => {
                p2pDisplay.innerText = "P2P Number: " + data;
                p2pDisplay.style.display = "block";  // Make the P2P number visible
            })
            .catch(error => {
                console.error("Error fetching P2P number:", error);
            });
    } else {
        // Hide the P2P number
        p2pDisplay.style.display = "none";
    }
});
