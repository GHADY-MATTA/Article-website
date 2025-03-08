// Use const by default
const API_URL = "/website-wallet/admin/generals/api-taha.php";

fetch(API_URL)
  .then((res) => {
    // Check if the response is okay (status 200)
    if (!res.ok) {
      throw new Error(`HTTP error! Status: ${res.status}`);
    }
    return res.json();
  })
  .then(data => {
    const userContainer = document.getElementById("userContainer");

    data.forEach(user => {
      const { username, email } = user;
      // Example condition: if username starts with "A", add a star.
      const condition = username.startsWith("A");
      const cardMarkup = `
        <div class="user-card">
          <h3>${username} ${condition ? "★" : ""}</h3>
          <p>${email}</p>
        </div>
      `;
      
      userContainer.innerHTML += cardMarkup;
    });
  })
  .catch(error => console.error("Error fetching user data:", error));
