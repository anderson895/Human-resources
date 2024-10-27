<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot UI</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

      
        .chat-box {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .chat-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            border-bottom: 1px solid #ddd;
            background-color: #f1f3f5;
        }

        .chat-input {
            display: flex;
            border-top: 1px solid #ddd;
            padding: 10px;
            background-color: #fff;
            align-items: center;
        }

        .chat-input input {
            flex: 1;
            border: 1px solid #ddd;
            padding: 12px;
            font-size: 16px;
            border-radius: 20px;
            margin-right: 10px;
            outline: none;
        }

        .chat-input input::placeholder {
            color: #888;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .chat-input input:focus::placeholder {
            opacity: 0.6;
        }

        .chat-input button {
            border: none;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 20px;
            font-size: 16px;
        }

        .chat-input button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-bottom: 12px;
        }

        .message.user {
            text-align: right;
        }

        .message.bot {
            text-align: left;
        }

        .message .text {
            display: inline-block;
            padding: 12px;
            border-radius: 20px;
            max-width: 80%;
            word-wrap: break-word;
        }

        .message.user .text {
            background-color: #007bff;
            color: white;
            margin-left: auto;
        }

        .message.bot .text {
            background-color: #e9ecef;
        }

        .suggestions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 10px;
            display: none; /* Hide suggestions by default */
        }

        .suggestions button {
            margin: 3px;
            border: none;
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
        }

        .suggestions button:hover {
            background-color: #0056b3;
        }

        .toggle-suggestions {
            text-align: center;
            padding: 10px;
            cursor: pointer;
            color: #007bff;
            user-select: none;
            font-weight: bold;
        }

        .toggle-suggestions:hover {
            text-decoration: underline;
        }

        /* Clear button inside input */
        .chat-input .clear-btn {
            background: transparent;
            border: none;
            font-size: 16px;
            color: #aaa;
            cursor: pointer;
            margin-right: 10px;
        }

        .chat-input .clear-btn:hover {
            color: #888;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-box">
            <div class="chat-messages" id="chatMessages">
                <!-- Messages will appear here -->
            </div>
            <div class="toggle-suggestions" id="toggleSuggestions">Show Suggestions</div>
            <div class="suggestions">
                <!-- Keyword suggestions will appear here -->
            </div>
            <div class="chat-input">
                <input type="text" id="userInput" placeholder="Type a message..." class="form-control" />
                <button id="sendBtn" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        // Fetch keyword suggestions and responses from the server
        $.ajax({
            url: 'chatbot_data.php', // Replace with the correct path to your PHP file
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var keywords = data.keywords;
                var responses = data.responses;

                // Display keyword suggestions
                keywords.forEach(function(keyword) {
                    var button = $('<button>').text(keyword)
                        .on('click', function() {
                            $('#userInput').val(keyword);
                        });
                    $('.suggestions').append(button);
                });

                // Add initial bot message
                addMessage('bot', 'Welcome to the chat! How can I assist you today?');

                // Handle sending messages
                $('#sendBtn').click(function() {
                    sendMessage(responses);
                });
                $('#userInput').keypress(function(event) {
                    if (event.which == 13) {
                        sendMessage(responses);
                    }
                });

                // Toggle suggestions visibility
                $('#toggleSuggestions').click(function() {
                    $('.suggestions').toggle();
                    var toggleText = $('.suggestions').is(':visible') ? 'Hide Suggestions' : 'Show Suggestions';
                    $('#toggleSuggestions').text(toggleText);
                });

            },
            error: function(xhr, status, error) {
                addMessage('bot', 'Sorry, I am having trouble retrieving my data. Please try again later.');
            }
        });

        function sendMessage(responses) {
            var userInput = $('#userInput').val();
            if ($.trim(userInput) !== '') {
                addMessage('user', userInput);
                $('#userInput').val('');

                // Simulate bot response based on keywords
                setTimeout(function() {
                    addMessage('bot', getBotResponse(userInput, responses));
                }, 1000);
            }
        }

        function addMessage(sender, text) {
            var message = $('<div>').addClass('message ' + sender)
                .html('<div class="text">' + text + '</div>');
            $('#chatMessages').append(message);
            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
        }

        function getBotResponse(userInput, responses) {
            var lowerCaseInput = userInput.toLowerCase();

            for (var keyword in responses) {
                if (lowerCaseInput.includes(keyword)) {
                    return responses[keyword];
                }
            }

            return 'I am not sure how to respond to that. Can you please provide more details?';
        }
    });
</script>

</body>
</html>
