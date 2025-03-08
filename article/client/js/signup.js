document.getElementById('signupForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const username = document.getElementById('username').value;
    const lastname = document.getElementById('lastname').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;

    // Debug: Check the form data
    console.log({
        username,
        lastname,
        email,
        password,
        passwordConfirmation
    });

    // Validate if passwords match
    if (password !== passwordConfirmation) {
        alert('Passwords do not match!');
        return;
    }

    // Prepare data to send
    const formData = {
        username,
        lastname,
        email,
        password
    };

    // Send data via Axios to the PHP backend
    axios.post('http://localhost/article/server/model/signup.php', formData)
        .then(function (response) {
            console.log('Response from PHP:', response.data);
            if (response.data.success) {
                alert('Sign up successful!');
                window.location.href = 'login.html'; // Redirect to login page
            } else {
                alert('Error: ' + response.data.message); // Show error message
            }
        })
        .catch(function (error) {
            console.error('Error during request:', error);
            alert('An error occurred. Please try again.');
        });
});
