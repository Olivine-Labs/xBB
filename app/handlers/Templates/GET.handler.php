<?php

final class RequestHandler extends \Router\Handler
{
  public function Request()
  {
    $this->_context->Templates = array(

    );

    $this->setTemplate('templates/load');
  }
}
?>
