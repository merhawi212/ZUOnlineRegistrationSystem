<?php
spl_autoload_register('myAutoLoader');

function myAutoLoader($classNamae){
    $full_path= 'GA/'.$classNamae.".php";
    include_once $full_path;
}