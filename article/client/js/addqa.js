document.addEventListener("DOMContentLoaded", function() {
    // Select the form element
    const form = document.querySelector("form");

    // Event listener for form submission
    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Gather form data
        const addqa = {
            username: document.getElementById("username").value,
            lastname: document.getElementById("lastname").value,
            email: document.getElementById("email").value,
            questions: document.getElementById("questions").value,
            answers: document.getElementById("answers").value
        };

        // Log the data (for debugging)
        console.log("Form data:", addqa);

        // Send data to the backend using Axios
        axios.post('/article/server/database/addtoqa.php', addqa)
            .then(response => {
                // Handle successful response
                console.log("Data sent successfully:", response);
                alert("Your data has been submitted successfully.");
            })
            .catch(error => {
                // Handle error
                console.error("There was an error submitting the form:", error);
                alert("There was an error submitting the form. Please try again.");
            });
    });
});
