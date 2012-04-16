<?php

final class RequestHandler extends \Router\Handler
{
  public function Request()
  {
    $this->_session->Data["previous_domain"] = str_replace('qotr', '', \Common\GetSubDomain());

    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");
    $this->addPartial("openIdProviders", "members/openIdProviders");

    $this->setTemplate('members/login-register');
  }
}
?>
