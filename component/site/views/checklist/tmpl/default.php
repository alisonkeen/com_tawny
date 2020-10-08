<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tawny
 *
 * @copyright   Copyright (C) 2020 Alison Keen
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * FRONT END CHECKLIST (SLOW VERSION)
 * 
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$jinput = JFactory::getApplication()->input;
$jurisdiction_id    = $jinput->get('jurisdiction_id', 0, 'INT');

JViewLegacy::loadHelper('tawnyhelper');

$db = TawnyHelper::getDB();

$question_list = TawnyHelper::getQuestions($jurisdiction_id, $db);

$parties = TawnyHelper::getParties($jurisdiction_id, $db);


  echo "<table class=\"table table-bordered\" >";
  
  echo "<tr>"; // table header row =============
  echo "<th> &nbsp; </th>";
  echo "<th> &nbsp; </th>";
  echo "<th> &nbsp; </th>";
  
  foreach ($parties as $party) {
    echo "<td> " .  $party->acronym . "</td>";
        }
  echo "</tr>"; // end table header row =================
  
    foreach ($question_list as $question) {
    
      echo "<tr>";
        echo "<td> " . $question->q_id . "</td>";
        echo "<td> " . $question->issue . "</td>";
        echo "<td> " . $question->question . "</td>";
        foreach ($parties as $party) {
	        echo "<td> <a href=\"index.php?option=com_tawnychecklist&view=rationale";
	        echo "&jurisdiction_id=" . strval($jurisdiction_id);
	        echo "&question_id=" . strval($question->question_id);
	        echo "&party_id=" . strval($party->party_id) . "\">";
	        echo TawnyHelper::get_position($question->question_id, $party->party_id,  $jurisdiction_id, $db);
	        echo "</a></td>";
        }
      echo "</tr>";
    
    }
    
    echo "</table>";

  echo "<br/>";

  print_r($data_array);
  



?>
