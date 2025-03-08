// Define the API URL where the PHP script is located
const API_URL = "/article/server/database/getaq.php";
console.log(API_URL);

// Fetch data from the PHP script
fetch(API_URL)
    .then(res => {
        // Check if the response is successful (status 200)
        if (!res.ok) {
            throw new Error(`HTTP error! Status: ${res.status}`);
        }
        return res.json(); // Parse the response as JSON
    })
    .then(data => {
        const userContainer = document.getElementById("searchResults");
        let markup = ""; // Variable to hold HTML markup for user data

        // Check if the data has results
        if (data && data.length > 0) {
            // Loop through the data and create user cards
            data.forEach(user => {
                // Destructure the fields from the data
                const { username, lastname, questions, answers, created_at } = user;

                // Create HTML structure for each user entry
                const cardMarkup = `
                    <div class="user-card">
                        <h3>${username} ${lastname}</h3>
                        <p><strong>Question:</strong> ${questions}</p>
                        <p><strong>Answer:</strong> ${answers}</p>
                    </div>
                `;
                markup += cardMarkup; // Append the card markup
            });

            // Insert the generated markup into the searchResults
            userContainer.innerHTML = markup;
        } else {
            // If no data found, display a message
            userContainer.innerHTML = "<p>No results found.</p>";
        }
    })
    .catch(error => {
        // Handle any errors that occur during the fetch
        console.error("Error fetching user data:", error);
        document.getElementById("searchResults").innerHTML = "<p>Error fetching data.</p>";
    });
