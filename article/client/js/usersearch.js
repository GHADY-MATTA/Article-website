document.getElementById("searchForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form from submitting traditionally

    let keyword = document.getElementById("searchKeyword").value.toLowerCase();
    let resultsContainer = document.getElementById("searchResults");
    resultsContainer.innerHTML = ""; // Clear previous results

    // Fetch data from the PHP script
    fetch("/article/server/database/getaq.php") // Adjust the path as needed
        .then(response => response.json())
        .then(data => {
            let filteredResults = data.filter(item => 
                item.username.toLowerCase().includes(keyword) || 
                item.userlastname.toLowerCase().includes(keyword)||
                item.userques.toLowerCase().includes(keyword) ||
                item.useranswer.toLowerCase().includes(keyword) ||
                item.created_at.toLowerCase().includes(keyword)
            );

            if (filteredResults.length > 0) {
                filteredResults.forEach(item => {
                    let div = document.createElement("div");
                    div.classList.add("result-item");
                    div.innerHTML = `
                        <p><strong>${item.username} ${item.userlastname}</strong></p>
                        <p><strong>Question:</strong> ${item.userques}</p>
                        <p><strong>Answer:</strong> ${item.useranswer}</p>
                        <p><small>Posted on: ${item.created_at}</small></p>
                        <hr>
                    `;
                    resultsContainer.appendChild(div);
                });
            } else {
                resultsContainer.innerHTML = "<p>No results found.</p>";
            }
        })
        .catch(error => console.error("Error fetching data:", error));
});
