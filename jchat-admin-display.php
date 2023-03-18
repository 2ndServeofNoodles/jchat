<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://jezweb.com.au
 * @since      1.0.0
 *
 * @package    Jchat
 * @subpackage Jchat/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="jchat-admin-wrapper">
  <h2>Jchat - Chatbot</h2>
  <div class="jchat-messages"></div>
  <form class="jchat-input-form">
    <input type="text" placeholder="Type your message here...">
    <button type="submit">Send</button>
  </form>
</div>
