<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tawny
 *
 * @copyright   Copyright (C) 2020 Alison Keen
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * ADMIN EDIT QUESTIONS PAGE
 * This page displays the "questions" view (menu: components > Tawny > questions)
 * This is for ordering questions in each checklist and adding/removing them.
 *
 * Quick overview to jog my memory:
 * 1, read the likely variables from last time we submitted the form
 * 2, check for values we need to feed back to database, put into DB
 * 3, then read new status from database and display
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// Grab submitted data if an update was posted:
$jinput = JFactory::getApplication()->input;

$row_id     = $jinput->get('row_id', -1, 'INT');
$jurisdiction_id    = $jinput->get('jurisdiction_id', 0, 'INT');

// This should be done by using joomla tasks, but i haven't learnt
// that yet and am on enough of a learning curve as it is... 
$operation   = $jinput->get('operation', '', 'STRING');

// Set up database connection .... 

JViewLegacy::loadHelper('tawnyhelper');

$db = TawnyHelper::getDB();


// Process form data .... 


/**

  if($operation == "update") {
    // submit updated data... // i.e. UPDATE query
    echo "Updating row # {$row_id}";
    
	$updated_row_for_db = new stdClass();
		
	$updated_row_for_db->row_id = $row_id; // set this as zero, this is modified by insertObject
		
	$updated_row_for_db->{'$jurisdiction_id'} = $question_active ;
		
	if(!empty($last_election)) {
        	$updated_row_for_db->last_election = $last_election; 
		}
		
	if(!empty($usual_term_length)) {
        	$updated_row_for_db->usual_term_length = $usual_term_length ; 
		}
  
  
  	if(!empty($next_election_actual)) {
        	$updated_row_for_db->next_election_actual = $next_election_actual ; 
		}
			
    echo "Data for update: ";
    print_r($updated_row_for_db);
  
		$result = $db->updateObject('#__com_tawny_questions', $updated_row_for_db, 'row_id');	
    
    $row_id = -1; // now reset the form
		
    
  }
  else if ($operation == "add_new") {
    echo "New Data detected.. "; // will need an INSERT query not UPDATE.
		
		// I think using an object then putting to dB is the cleanest way to do this? at least until errors drive me bananas
		$new_row_for_db = new stdClass();
		$new_row_for_db->row_id = 0; // set this as zero, this is modified by insertObject
		
		$new_row_for_db->jurisdiction_id = $jurisdiction_id;
		
		if(!empty($last_election)) {
        	$new_row_for_db->last_election = $last_election; 
		}
		
		if(!empty($usual_term_length)) {
        	$new_row_for_db->usual_term_length = $usual_term_length ; 
		}
  
  	if(!empty($next_election_guess)) {
        	$new_row_for_db->next_election_guess = $next_election_guess ; 
		}
  
  	if(!empty($next_election_actual)) {
        	$new_row_for_db->next_election_actual = $next_election_actual ; 
		}
			
    print_r($new_row_for_db);
  
		$result = $db->insertObject('elections', $new_row_for_db, 'row_id');	
		
    echo "Row ID is now... {$new_row_for_db->row_id}";
  }
  
*** END processing form data **/
?>

<h3> Questions...  </h3>

<table>
  <tr>
    <th> Question ID </th>
    <th> Question </th> 
    <th> Issue </th>
    <th> Keywords </th>
    <th> <?php echo TawnyHelper::getStateAbbrev(0); ?> </th>
    <th> <?php echo TawnyHelper::getStateAbbrev(1); ?> </th>
    <th> <?php echo TawnyHelper::getStateAbbrev(2); ?> </th>
    <th> <?php echo TawnyHelper::getStateAbbrev(3); ?> </th>
    <th> <?php echo TawnyHelper::getStateAbbrev(4); ?> </th>
    <th> <?php echo TawnyHelper::getStateAbbrev(5); ?> </th>
    <th> <?php echo TawnyHelper::getStateAbbrev(6); ?> </th>
    <th> <?php echo TawnyHelper::getStateAbbrev(7); ?> </th>
    <th> <?php echo TawnyHelper::getStateAbbrev(8); ?> </th>
    <th> <?php echo TawnyHelper::getStateAbbrev(9); ?> </th>
  </tr>
  
<?php

$question_list = TawnyHelper::getQuestions($jurisdiction_id, $db);

foreach ( $question_list as $row) {

    if($row_id == $row->question_id) {
?>
      <form action="index.php?option=com_tawnychecklist&view=questions" method="post" name="edit_row">
        
        <tr>
          <td>
            <input type="hidden" name="operation" value="update"  />
            <input type="hidden" name="row_id" value="<?php echo $row->question_id?>"  />
            <?php echo $row->question_id ?>
          </td>
          <td>
            <?php echo $row->question ?>
          </td>
          <td>
            <?php echo $row->issue ?>
          </td>
          <td>
            <?php echo $row->keywords ?>
          </td>
          <td>
            <?php echo $row->{'1'} ?>
          </td>
          <td>
            <?php echo $row->{'2'} ?>
          </td>
          <td>
            <?php echo $row->{'3'} ?>
          </td>
          <td>
            <?php echo $row->{'4'} ?>
          </td>
          <td>
            <?php echo $row->{'5'} ?>
          </td>
          <td>
            <?php echo $row->{'6'} ?>
          </td>
          <td>
            <?php echo $row->{'7'} ?>
          </td>
          <td>
            <?php echo $row->{'8'} ?>
          </td>
          <td>
            <?php echo $row->{'9'} ?>
          </td>
          <td>
            <input id="flyingfox" value="Update!" type="submit" class="btn btn-success" >
          </td>
        </tr>
      </form>
<?php
    } else {
?>
      <form action="index.php?option=com_tawnychecklist&view=questions" method="post" name="update_row">
        <input type="hidden" name="row_id" value="<?php echo $row->question_id?>"  />
        <tr>
          <td><?php echo $row->question_id ?></td>
          <td><?php echo $row->question ?></td>
          <td><?php echo $row->issue?></td>
          <td><?php echo $row->keywords ?></td>
          <td><?php echo strval($row->{'1'}) ?></td>
          <td><?php echo $row->{'2'} ?></td>    
          <td><?php echo $row->{'3'} ?></td>    
          <td><?php echo $row->{'4'} ?></td>
          <td><?php echo $row->{'5'} ?></td>    
          <td><?php echo $row->{'6'} ?></td>    
          <td><?php echo $row->{'7'} ?></td>
          <td><?php echo strval($row->{'8'}); ?></td>    
          <td><?php echo $row->{'9'} ?></td>    
          <td>
            <input id="flyingfox" value="Edit..." type="submit" class="btn btn-success" >
          </td>

        </tr>
      </form>
<?php
    } // end 'if editing/else' clause

	} // end foreach row... 
  
?>
</table>
