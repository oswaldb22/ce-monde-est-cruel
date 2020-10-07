<?php
ini_set('memory_limit', '-1');
include_once(__DIR__.'/vendor/autoload.php');

$a = new \Hackathon\Game\Main();
$a->execute();
