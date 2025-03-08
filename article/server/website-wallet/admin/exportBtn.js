document.getElementById('exportBtn').addEventListener('click', function() {
    // Show loading message or animation here if needed
    fetch('../server(api)/php/models/Export-Data.php')  // Adjusted relative path
        .then(response => response.json())
        .then(data => {
            // Convert the data to a JSON Blob
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'UserWalletSignUp_Export.json';  // File name
            a.click();  // Trigger download
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            alert('There was an error exporting the data.');
        });
});
