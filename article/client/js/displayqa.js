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
        const userContainer = document.getElementById("userContainer");
        let markup = ""; // Variable to hold HTML markup for user data

        // Check if the data has results
        if (data && data.length > 0) {
            // Loop through the data and create user cards
            data.forEach(user => {
                const { username, userlastname, userques, useranswer, created_at } = user;

                // Format the date to a readable format
                const formattedDate = new Date(created_at).toLocaleString();

                // Create HTML structure for each user entry
                const cardMarkup = `
                    <div class="user-card">
                        <h3>${username} ${userlastname}</h3>
                        <p><strong>Question:</strong> ${userques}</p>
                        <p><strong>Answer:</strong> ${useranswer}</p>
                        <p><strong>Submitted On:</strong> ${formattedDate}</p>
                    </div>
                `;
                markup += cardMarkup; // Append the card markup
            });

            // Insert the generated markup into the userContainer
            userContainer.innerHTML = markup;
        } else {
            // If no data found, display a message
            userContainer.innerHTML = "<p>No results found.</p>";
        }
    })
    .catch(error => {
        // Handle any errors that occur during the fetch
        console.error("Error fetching user data:", error);
        document.getElementById("userContainer").innerHTML = "<p>Error fetching data.</p>";
    });
