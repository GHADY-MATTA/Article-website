const apiKey = 'AIzaSyBFPuDdh6NpA7LSzmrZTfxWMUzPulkLjaM'; // Replace with your Gemini API key
        const apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" + apiKey;

        async function sendToGemini() {
            const inputText = document.getElementById('inputText').value;
            const responseTextElement = document.getElementById('responseText');

            if (!inputText) {
                alert('Please enter some text!');
                return;
            }

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "contents": [
                            {
                                "parts": [
                                    {
                                        "text": inputText
                                    }
                                ]
                            }
                        ]
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                responseTextElement.innerText = data.candidates[0].content.parts[0].text;
            } catch (error) {
                console.error('Error:', error);
                responseTextElement.innerText = 'An error occurred. Please try again.';
            }
        }