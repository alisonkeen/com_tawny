<?php defined('_JEXEC') or die();

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;

abstract class TawnyFormHelper 
{

  function addStatementForm() {
    
    $formtext = "<h3> Form is displayed here... </h3>";
    
    return $formtext;
  }
  
  function echoJSFunctions() {
  
    return; // maybe not... 
  
  }
  
}
