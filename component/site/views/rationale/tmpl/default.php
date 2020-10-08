<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_acvi
 *
 * @copyright   Copyright (C) 2020 Alison Keen
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * Rationale PREVIEW
 * 
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$jinput = JFactory::getApplication()->input;
$jurisdiction_id    = $jinput->get('jurisdiction_id', 0, 'INT');
$question_id    = $jinput->get('question_id', 0, 'INT');
$party_id    = $jinput->get('party_id', 0, 'INT');


JViewLegacy::loadHelper('acvihelper');
JViewLegacy::loadHelper('formhelper');
JViewLegacy::loadHelper('usersgroups');


ACVIFormHelper::echoJSFunctions();

$db = ACVIHelper::getDB();

$statement_list = ACVIHelper::getStatements($question_id, $party_id, $jurisdiction_id, $db);
$votes_list = ACVIHelper::getVotes($question_id, $party_id, $jurisdiction_id, $db);

$fed_statement_list = ACVIHelper::getStatements($question_id, $party_id, 9, $db);
$fed_votes_list = ACVIHelper::getVotes($question_id, $party_id, 9, $db);


echo "<h2> Rationale behind score </h2>";

// -------------- Look up question these statements are about... ------------------------

$question_obj = ACVIHelper::getQuestion($question_id, $db);

echo "\n<h4>Question: " . $question_obj->question . " </h4>";

echo "\n<h4>Topic: " . $question_obj->issue . " </h4>";

echo "\n<p> Jurisdiction: " . ACVIHelper::getStateName($jurisdiction_id) . "</p>";
echo "\n<p> Political Party: " . ACVIHelper::getPartyName($party_id, $db) . "</p>";

echo "\n<p> Score: " . ACVIHelper::get_position($question_id, $party_id,  $jurisdiction_id, $db);

echo "<br/>";



  
  echo "\n<table>";
  
    foreach ($statement_list as $statement) {
        echo "<tr>";
        echo "<td> Policy Statement: " . $statement->comment . "</td>";
        echo "</tr>";
    }
    
    foreach ($fed_statement_list as $statement) {
        echo "<tr>";
        echo "<td> Policy Statement (Federal) " . $statement->comment . "</td>";
        echo "</tr>";
    }
    
    foreach ($votes_list as $vote) {
        echo "<tr>";
        echo "<td> Vote on bill: " . $vote->bill_name;
        
        // if date is not null/empty {
        //    echo " on " . $vote->date;
        // }
        
        echo "<br/> Comment: " . $vote->comment . "</td>";
        echo "</tr>";
    
    }
    
    foreach ($fed_votes_list as $vote) {
        echo "<tr>";
        echo "<td> Vote on bill (Federal) " . $vote->bill_name;
        
        // if date is not null/empty {
        //    echo " on " . $vote->date;
        // }
        
        echo "<br/> Comment: " . $vote->comment . "</td>";
        echo "</tr>";
    
    }
    
    echo "\n</table> </hr>";
  
  if(ACVIUsers::amILoggedIn() == true) {
    // ======================Logged in user? yay, we can add and edit! ===============

   
   // echo $formtext; 
   

?>
    
   <div id="acvistatementform"> <input value="Add Statement" type="button" onClick="showStatementForm('addstatementform')" class="btn btn-success" > </div>  
  
    <div class="well" id="addstatementform" style="visibility:collapse">
    
    <h3> Add another policy statement: </h3>
    
    <form action="index.php?option=com_acvichecklist&view=addstatement" method="post">      
      <input type="hidden" name="question_id" value="<?php echo $question_id; ?>"  />
      <input type="hidden" name="jurisdiction_id" value="<?php echo $jurisdiction_id; ?>"  />
      <input type="hidden" name="action" value="add" />
      
    <table> 
      <tr>
	<!-- State/Territory drop-down list... -->
        <td>
	<label for="jurisdiction_id">State/Territory:</label> 
	</td>
	<td>
	<select id="jurisdiction_id" name="jurisdiction_id">
	  <option value="<?php echo strval($jurisdiction_id); ?>" selected ><?php echo ACVIHelper::getStateName($jurisdiction_id); ?></option>
          <option value="9">Federal</option>
          <option value="1">ACT</option>
          <option value="2">NSW</option>
          <option value="3">Victoria</option>
          <option value="4">Queensland</option>
          <option value="5">SA</option>
          <option value="6">WA</option>
          <option value="7">Tasmania</option>
          <option value="8">NT</option>
        </select>
	</td>
       </tr>
       
        <!-- Party drop-down list... -->
      <tr>
        <td>	
        <label for="party">Political Party:</label>
        </td><td>
        <select id="party" name="party_id">
<?php 	  
        $parties = ACVIHelper::getParties($jurisdiction_id, $db);
        foreach ($parties as $party) {
          echo "\n<option value=\"" . strval($party->party_id) . "\"";
          if ($party->party_id == $party_id) {
            echo " selected";
          }
          echo ">" . $party->name . "</option>";
        }
?>
	</select>
	</td></tr>
	
	
      <!-- Score...  -->
      
      <tr>
        <td> Is this a good or bad policy statement? </td>
        <td>
        <select id="score" name="score">
          <option value="1">Good</option>
          <option value="0">Neutral</option>
          <option value="-1">Bad</option>          
	</select>
	</td>
      </tr>
	
      <tr>
      <td> Describe their policy statement: </td>
      <td>
      <textarea name="comment" rows="1" > </textarea>
      </td>
      </tr> 
      
      <tr> <td> Enter some keywords...? </td> 
      <td>
      <textarea name="keywords" rows="1" > </textarea>
      </td> </tr>
      
      <tr> <td> Source URL to verify this: </td> 
      <td>
      <textarea name="source_url" rows="1" > </textarea>
      </td> </tr>
      
   </table>
   
   <input value="Add!" type="submit" class="btn btn-success" >

    </form>
    </div> <!-- end form well ... -->
    
    
    
       <div id="acvivoteform"> <input value="Add Vote" type="button" onClick="showStatementForm('addvoteform')" class="btn btn-success" > </div>  
  
    <div class="well" id="addvoteform" style="visibility:collapse">
    
    <h3> Add details of a past vote in parliament... </h3>
    
    <form action="index.php?option=com_acvichecklist&view=addvote" method="post">      
      <input type="hidden" name="question_id" value="<?php echo $question_id; ?>"  />
      <input type="hidden" name="jurisdiction_id" value="<?php echo $jurisdiction_id; ?>"  />
      <input type="hidden" name="action" value="add" />
      
    <table> 
      <tr>
	<!-- State/Territory drop-down list... -->
        <td>
	<label for="jurisdiction_id">State/Territory:</label> 
	</td>
	<td>
	<select id="jurisdiction_id" name="jurisdiction_id">
	  <option value="<?php echo strval($jurisdiction_id); ?>" selected ><?php echo ACVIHelper::getStateName($jurisdiction_id); ?></option>
          <option value="9">Federal</option>
          <option value="1">ACT</option>
          <option value="2">NSW</option>
          <option value="3">Victoria</option>
          <option value="4">Queensland</option>
          <option value="5">SA</option>
          <option value="6">WA</option>
          <option value="7">Tasmania</option>
          <option value="8">NT</option>
        </select>
	</td>
       </tr>
       
        <!-- Party drop-down list... -->
      <tr>
        <td>	
        <label for="party">Political Party:</label>
        </td><td>
        <select id="party" name="party_id">
<?php 	  
        $parties = ACVIHelper::getParties($jurisdiction_id, $db);
        foreach ($parties as $party) {
          echo "\n<option value=\"" . strval($party->party_id) . "\"";
          if ($party->party_id == $party_id) {
            echo " selected";
          }
          echo ">" . $party->name . "</option>";
        }
?>
	</select>
	</td></tr>
	
	
      <!-- Score...  -->
      
      <tr>
        <td> Is this a good or bad policy statement? </td>
        <td>
        <select id="score" name="score">
          <option value="1">Good</option>
          <option value="0.5">Sort of good?</option>
          <option value="0">Neutral</option>
          <option value="-0.5">Sort of bad?</option>         
          <option value="-1">Bad</option>          
	</select>
	</td>
      </tr>
	
      <tr>
      <td> Describe the vote </td>
      <td>
      <textarea name="comment" rows="1" > </textarea>
      </td>
      </tr> 
      
      <tr> <td> Title of bill in question: </td> 
      <td>
      <textarea name="bill_name" rows="1" > </textarea>
      </td> </tr>
      
      <tr> <td> date of speech or vote </td> 
      <td>
      <input type="date" name="date" rows="1" > </textarea>
      </td> </tr>
      
      <tr> <td> Source URL to verify this: </td> 
      <td>
      <textarea name="source_url" rows="1" > </textarea>
      </td> </tr>
      
   </table>
   
   <input value="Add!" type="submit" class="btn btn-success" >

    </form>
    </div> <!-- end form well ... -->
    
<?php
    
  }
  else {
    // =========================== Not logged in, just display =========================
    
    // since there's no edit function yet, display code above will do... 
  }
  
  
  
  
  echo"\n<a href=\"index.php?option=com_acvichecklist&view=checklist&jurisdiction_id=";
  echo strval($jurisdiction_id) . "\">Back to Checklist</a>";


    echo "\n<script type=\"text/javaScript\">";
    
    echo "\nfunction showStatementForm(divID) {";
    echo "\n   var fieldNameElement = document.getElementById(divID);";
    echo "\n   fieldNameElement.style.visibility= \"visible\";";
    
    
    // echo "\n   document.write(\"Javascript is loading properly.\");";
    
    //    echo "\n   text = \"" . ACVIFormHelper::addStatementForm() . "\";";
    
    echo "\n}";
    
    
    echo "\n   var fieldNameElement = document.getElementById(divID);";
    echo "\n   fieldNameElement.innerHTML = text;";
    
    echo "\n</script>";

  



?>
