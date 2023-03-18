(function($) {
  'use strict';

  $(document).ready(function() {
    // Cache DOM elements
    var $inputForm = $('.jchat-input-form');
    var $inputField = $inputForm.find('input[type="text"]');
    var $chatMessages = $('.jchat-messages');

    // Function to append message to the chat messages area
    function appendMessage(user, message) {
      $chatMessages.append(
        '<div class="jchat-message"><span class="jchat-user">' +
          user +
          ':</span><span class="jchat-text">' +
          message +
          '</span></div>'
      );
      $chatMessages.scrollTop($chatMessages[0].scrollHeight);
    }

    // Handle form submission
    $inputForm.on('submit', function(event) {
      event.preventDefault();
      var message = $inputField.val().trim();
      if (message.length > 0) {
        appendMessage('You', message);
        $inputField.val('');
        
        // Implement your chatbot logic here
        // For example, you can make an AJAX request to your server-side script
        // and append the chatbot response using the appendMessage function
      }
    });
  });
})(jQuery);
