(function ($) {
    'use strict';

    // Function to append a new message to the chat container
    function addMessage(message, sender) {
        var messageElement = $('<div class="jchat-message"></div>');
        var senderElement = $('<span></span>');
        senderElement.addClass(sender === 'user' ? 'jchat-message-user' : 'jchat-message-bot');
        senderElement.text(sender === 'user' ? 'You: ' : 'Bot: ');

        messageElement.append(senderElement);
        messageElement.append(document.createTextNode(message));
        $('.jchat-messages').append(messageElement);
        $('.jchat-messages').scrollTop($('.jchat-messages')[0].scrollHeight);
    }

    // Function to handle user input and process the chatbot response
    function processInput() {
        var input = $('.jchat-input');
        var userInput = input.val().trim();

        if (userInput === '') {
            return;
        }

        addMessage(userInput, 'user');
        input.val('');

        // TODO: Implement chatbot response logic here
        // For now, we'll just simulate a response after a short delay
        setTimeout(function () {
            var botResponse = 'This is a sample response from the chatbot.';
            addMessage(botResponse, 'bot');
        }, 1000);
    }

    $(function () {
        // Initialize the chatbot UI
        var chatHtml = `
            <div class="jchat-container">
                <div class="jchat-header">Chatbot</div>
                <div class="jchat-messages"></div>
                <div class="jchat-input-container">
                    <input type="text" class="jchat-input" placeholder="Type your message...">
                    <button class="jchat-send-btn">Send</button>
                </div>
            </div>
        `;
        $('body').append(chatHtml);

        // Attach event handlers
        $('.jchat-send-btn').on('click', processInput);
        $('.jchat-input').on('keypress', function (event) {
            if (event.which === 13) {
                processInput();
            }
        });
    });
})(jQuery);
