document.getElementById("searchForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent actual form submission
            document.querySelector(".display-qa").style.display = "none"; // Show the div
        });