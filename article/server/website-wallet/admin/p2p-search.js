document.getElementById("p2pSearchForm").addEventListener("submit", function(e) {
    e.preventDefault(); // Prevent form submission

    const keyword = document.getElementById("p2pSearchKeyword").value.trim();

    if (keyword !== "") {
        fetch(`/website-wallet/server(api)/php/p2p-admin-search.php?p2pKeyword=${encodeURIComponent(keyword)}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById("p2pSearchResults").innerHTML = data;
            })
            .catch(error => {
                console.error("Error fetching search results:", error);
            });
    } else {
        document.getElementById("p2pSearchResults").innerHTML = "Please enter a keyword to search.";
    }
});
