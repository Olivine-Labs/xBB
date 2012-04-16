<?php
final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $currentUser = $this->currentUser();

    if(array_key_exists("error", $this->_request))
    {
      $errors = array("You entered an incorrect password.", "There was a problem saving your new password or username. Email and username must be unique and valid.");
      $this->_context->Error = $errors[$this->_request["error"]];
    }
    else if(array_key_exists("success", $this->_request))
    {
      $this->_context->Error = "Settings updated.";
    }

    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");

    $this->setTemplate('members/settings');
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
