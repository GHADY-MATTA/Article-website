function updateProfile() {
            // Get form data
            var formData = new FormData(document.getElementById("editProfileForm"));

            // Use Axios to send the data to the PHP file
            axios.post('/website-wallet/server(api)/php/models/update_profile.php', formData)
                .then(function (response) {
                    // Handle success, show response message
                    document.getElementById("response").innerHTML = response.data;
                })
                .catch(function (error) {
                    // Handle error
                    console.error('There was an error!', error);
                    document.getElementById("response").innerHTML = 'There was an error updating your profile.';
                });
        }