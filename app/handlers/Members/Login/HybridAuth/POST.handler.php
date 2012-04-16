<?php

final class RequestHandler extends \Router\Handler
{
  public function Request()
  {
    chdir('../../core-custom/ThirdParty/hybridauth/hybridauth');
    include('index.php');
    chdir(MINT_ROOT);
  }
}
?>
