<?php
//Session Settings
$Settings = new \Database\Settings();
$Settings->Name			  = 'Sessions';
$Settings->Driver		  = 'MongoDB';
$Settings->Host			  = 'localhost';
$Settings->Port			  = 27017;
$Settings->User			  = 'Application';
$Settings->Password		= 'ApplicationPW';
$Settings->Database		= 'Application';
$Settings->Collection	= 'Sessions';
$Settings->ClassName	= '\Database\Collections\MongoDB\SessionCollection';
$this->addCollection($Settings);

//Boards Settings
$Settings = new \Database\Settings();
$Settings->Name			  = 'Boards';
$Settings->Driver		  = 'MongoDB';
$Settings->Host			  = 'localhost';
$Settings->Port			  = 27017;
$Settings->User			  = 'Application';
$Settings->Password		= 'ApplicationPW';
$Settings->Database		= 'xBB';
$Settings->Collection	= 'Boards';
$Settings->ClassName	= '\Database\Collections\MongoDB\BoardCollection';
$this->addCollection($Settings);

//Posts Settings
$Settings = new \Database\Settings();
$Settings->Name			  = 'Posts';
$Settings->Driver		  = 'MongoDB';
$Settings->Host			  = 'localhost';
$Settings->Port			  = 27017;
$Settings->User			  = 'Application';
$Settings->Password		= 'ApplicationPW';
$Settings->Database		= 'xBB';
$Settings->Collection	= 'Posts';
$Settings->ClassName	= '\Database\Collections\MongoDB\PostCollection';
$this->addCollection($Settings);


//User Settings
$Settings = new \Database\Settings();
$Settings->Name			  = 'Users';
$Settings->Driver		  = 'MongoDB';
$Settings->Host			  = 'localhost';
$Settings->Port			  = 27017;
$Settings->User			  = 'Application';
$Settings->Password		= 'ApplicationPW';
$Settings->Database		= 'Application';
$Settings->Collection	= 'Users';
$Settings->ClassName	= '\Database\Collections\MongoDB\UserCollection';
$this->addCollection($Settings);

//Statistic Settings
$Settings = new \Database\Settings();
$Settings->Name			  = 'Statistics';
$Settings->Driver		  = 'MongoDB';
$Settings->Host			  = 'localhost';
$Settings->Port			  = 27017;
$Settings->User			  = 'Application';
$Settings->Password		= 'ApplicationPW';
$Settings->Database		= 'Application';
$Settings->Collection	= 'Statistics';
$Settings->ClassName	= '\Database\Collections\MongoDB\StatisticCollection';
$this->addCollection($Settings);

//Log Settings
$Settings = new \Database\Settings();
$Settings->Name			  = 'Logs';
$Settings->Driver		  = 'MongoDB';
$Settings->Host			  = 'localhost';
$Settings->Port			  = 27017;
$Settings->User			  = 'Application';
$Settings->Password		= 'ApplicationPW';
$Settings->Database		= 'Application';
$Settings->Collection	= 'Logs';
$Settings->ClassName	= '\Database\Collections\MongoDB\LogCollection';
$this->addCollection($Settings);
?>
