<?php

final class RequestHandler extends \Router\Handler
{
  public function Request()
  {
    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");

    $this->setTemplate("public/index");
  }
}
?>
