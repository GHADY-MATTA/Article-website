// Function to fetch the latest transactions
function fetchTransactions() {
    console.log("Fetching transactions...");
    
    fetch("live-transactions.php")
        .then(response => response.json())  // Parse JSON response
        .then(data => {
            console.log("Data received:", data);  // Check what data we get
            
            if (data.error) {
                console.error("Error fetching transactions:", data.error);
            } else if (data.message) {
                console.log(data.message); // No transactions message
                document.getElementById("liveTransactions").innerHTML = "<p>No transactions found.</p>";
            } else {
                // Clear previous content and display the new transactions
                let transactionsHtml = '';
                data.transactions.forEach(transaction => {
                    transactionsHtml += `
                        <tr>
                            <td>${transaction.transaction_id}</td>
                            <td>${transaction.sender_user_id}</td>
                            <td>${transaction.receiver_user_id}</td>
                            <td>${transaction.amount}</td>
                            <td>${transaction.status}</td>
                            <td>${transaction.created_at}</td>
                        </tr>
                    `;
                });
                document.getElementById("liveTransactions").innerHTML = transactionsHtml;
            }
        })
        .catch(error => {
            console.error("Error fetching transactions:", error);
        });
}

// Fetch transactions every 5 seconds
setInterval(fetchTransactions, 5000);  // Adjust the interval as needed
