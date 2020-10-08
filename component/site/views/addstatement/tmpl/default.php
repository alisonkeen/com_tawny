<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tawny
 *
 * @copyright   Copyright (C) 2020 Alison Keen
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * input for adding a statement ... 
 * 
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$jinput = JFactory::getApplication()->input;
$jurisdiction_id = $jinput->get('jurisdiction_id', 0, 'INT');

JViewLegacy::loadHelper('tawnyhelper');

JViewLegacy::loadHelper('usersgroups');

$db = TawnyHelper::getDB();

$statement_list = TawnyHelper::getStatements($question_id, $party_id, $jurisdiction_id, $db);

echo "<h2> Adding policy statement... </h2>";

echo "<br/>";
  
  if(TawnyUsers::amILoggedIn() == true) {
    // ======================Logged in user? yay, we can add and edit! ===============
    
    // ---------- read all the variables ---------------
    
    $new_statement = new \stdClass;
    $new_statement->statement_id = 0; // start off as 0, 'insert' query will overwrite
    
    $new_statement->question_id = $jinput->get('question_id', 0, 'INT');
    echo "<p> Question ID: " . strval($new_statement->question_id) . "</p>";
    
    
    $new_statement->party_id    = $jinput->get('party_id', 0, 'INT');
    echo "<p> Party: " . TawnyHelper::getPartyName($new_statement->party_id, $db) . "</p>";
    if($new_statement->party_id == 0) {
      echo "<h3><b>Invalid Party ID.</b></h3>";
      return;
    }
    
    $new_statement->jurisdiction = $jurisdiction_id;
    echo "<p> Jurisdiction: " . TawnyHelper::getStateName($new_statement->jurisdiction) . "</p>";
    if($new_statement->jurisdiction == 0) {
      echo "<h3><b>Invalid State/Territory</b></h3>";
      return;
    }
    
    $new_statement->score    = $jinput->get('score', 99, 'INT');
    if($new_statement->score > 1 || $new_statement->score < -1) {
      echo "Score submitted... " . $new_statement->score;
      echo "<h3>Score out of bounds... between -1 and 1 please</h3>";
      return;
    }
    
    $new_statement->comment    = $jinput->get('comment', '', 'STRING');
    echo "<p> Comment: " . $new_statement->comment . "</p>";

    
    $new_statement->source_url    = $jinput->get('source_url', '', 'STRING');
    echo "<p> Source URL: " . $new_statement->source_url . "</p>";
   
    // ------- then add the statement ... ---------------------
    
    $result = TawnyHelper::addStatement($new_statement, $db);
  
    // ---------- then show confirmation -----------------------
  
  }
  else {
    // =========================== Not logged in =========================
    
    echo "<h3>You must be logged in to make changes.</h3>";
  
  }
  
  
  echo "<a href=\"index.php?option=com_tawnychecklist&view=rationale";
  echo "&jurisdiction_id=" . strval($jurisdiction_id);
  echo "&party_id=" . strval($new_statement->party_id);  
  echo "&question_id=" . strval($new_statement->question_id) . "\">";
  echo "<h3>Back to Question</h3></a>";
  
  echo"<a href=\"index.php?option=com_tawnychecklist&view=checklist&jurisdiction_id=";
  echo strval($jurisdiction_id) . "\"><h3>Back to Checklist</h3></a>";


?>
