<?php

require ('Autoload.php');

$multiupload = new Multiupload("archivo");
$multiupload->setPolicy(3);
$multiupload->upload();
