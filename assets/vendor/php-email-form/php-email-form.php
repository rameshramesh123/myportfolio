<?php

class PHP_Email_Form {
  public $to;
  public $from_name;
  public $from_email;
  public $subject;
  public $ajax = false;
  public $smtp = false;
  private $messages = [];

  function add_message($content, $label = '', $length = 0) {
    if (!empty($content) && strlen($content) >= $length) {
      $message = '';
      if ($label) {
        $message .= "<strong>$label:</strong> ";
      }
      $message .= nl2br(htmlspecialchars($content, ENT_QUOTES));
      $this->messages[] = $message;
    }
  }

  function send() {
    $email_content = implode("<br><br>", $this->messages);

    $headers = "From: " . $this->from_name . " <" . $this->from_email . ">\r\n";
    $headers .= "Reply-To: " . $this->from_email . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $success = mail($this->to, $this->subject, $email_content, $headers);

    if ($this->ajax) {
      return $success ? 'OK' : 'Failed to send email.';
    } else {
      return $success;
    }
  }
}
