<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tawnychecklist
 *
 * @copyright   (C) 2018 - Alison Keen 
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * ADMIN EDIT_A_QUESTION PAGE
 * Shows details of a question and lets administrator update some things
 * 
 * This page was copied from some other code i wrote as a starting point, 
 * the other page was about updating quotes related to bills going through 
 * parliament. 
 *
 * THIS CODE IS TOTALLY BROKEN and needs rewriting, 
 * i obviously started it and just haven't come back to it yet
 * 
 * Quick overview to jog my memory:
 * 1, read the likely variables from last time we submitted the form
 * 2, check for values we need to feed back to database, put into DB
 * 3, then read new status from database and display
 */



// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// TODO you're up to here: 
// you need to rename the variable "jurisdiction" in the xml 
// then you need to change it to an integer, and get rid of the case statement
// then add sanitising code here somewhere... 
$jinput = JFactory::getApplication()->input;


// need to define some objects so they have whole-page scope and can be accessed;
$related_bill = null;
$a_quote = null;


$quote_id = $jinput->get('question_id', 0, 'INT');

// In case you forgot, this is joomla-ese. The "0" in the second argument
// is the default value if it isn't found. 

// If the form was just submitted, we need to collect the new data and save it:
$quote_date   = $jinput->get('quote_date', '', 'STRING');
$quote_title   = $jinput->get('quote_title', '', 'STRING');
$quote_author   = $jinput->get('quote_author', '', 'STRING');
$quote   = $jinput->get('quote', '', 'STRING');
$quote_url  = $jinput->get('quote_url', '', 'STRING');

$option = array(); //prevent problems

## BROKEN needs to use the HElper::getDB function... 
$db = JDatabaseDriver::getInstance( $option );


if(!empty($quote) && $quote_id == 0) {
  echo "<p> NEW Quote detected. </p>";

  // I think using an object then putting to dB is the cleanest way to do this? at least until errors drive me bananas
  $quote_for_db = new stdClass();

  // RELATED BILL ID must be supplied as an argument. 
  // All quotes must be related to a bill as things stand, to avoid orphaned quotes... 
  $quote_for_db->pipe_bill_id = $related_bill_id;
  $quote_for_db->quote_id = 0;

  if(!empty($quote)) {
    $quote_for_db->quote = $quote; 
  }

  if(!empty($quote_title)) {
    $quote_for_db->title = $quote_title; 
  }

  if(!empty($quote_date)) {
    $quote_for_db->date = $quote_date; 
  }

  if(!empty($quote_author)) {
    $quote_for_db->author = $quote_author; 
  }

  if(!empty($quote_url)) {
    $quote_for_db->URL = $quote_url; 
  }  

  // Echidna.

  $result = $db->insertObject('quotes', $quote_for_db, 'quote_id');  

  $quote_id = $quote_for_db->quote_id;

  print_r($quote_for_db);
}
else if (!empty($quote)){

  echo "<p>Updating quote as requested... </p>";

  if(!empty($quote_date)) {
    echo "quote_date=" . $quote_date . '</br>';

    $query3 = $db->getQuery(true);
    $query3->update('quotes');
    $query3->set($db->quoteName('date').' = '.$db->quote($db->escape($quote_date)));
    $query3->where($db->quoteName('quote_id')." = ".$db->quote($quote_id));
    $db->setQuery($query3);
    $db->execute();
  }

  if(!empty($quote_title)) {
    echo "quote_title=" . $quote_title . '</br>';

    $query4 = $db->getQuery(true);
    $query4->update('quotes');
    $query4->set($db->quoteName('title').' = '.$db->quote($db->escape($quote_title)));
    $query4->where($db->quoteName('quote_id')." = ".$db->quote($quote_id));
    $db->setQuery($query4);
    $db->execute();
  }

  if(!empty($quote)) {
    echo "quote=" . $quote . '</br>';

    $query5 = $db->getQuery(true);
    $query5->update('quotes');
    $query5->set($db->quoteName('quote').' = '.$db->quote($db->escape($quote)));
    $query5->where($db->quoteName('quote_id')." = ".$db->quote($quote_id));
    $db->setQuery($query5);
    $db->execute();
  }

  if(!empty($quote_author)) {
    echo "quote_author=" . $quote_author . '</br>';

    $query6 = $db->getQuery(true);
    $query6->update('quotes');
    $query6->set($db->quoteName('author').' = '.$db->quote($db->escape($quote_author)));
    $query6->where($db->quoteName('quote_id')." = ".$db->quote($quote_id));
    $db->setQuery($query6);
    $db->execute();
  }

  if(!empty($quote_url)) {
    echo "quote_url=" . $quote_url . '</br>';

    $query7 = $db->getQuery(true);
    $query7->update('quotes');
    $query7->set($db->quoteName('URL').' = '.$db->quote($db->escape($quote_url)));
    $query7->where($db->quoteName('quote_id')." = ".$db->quote($quote_id));
    $db->setQuery($query7);
    $db->execute();
  }
}


// ========== End of under-the-hood processing, start of displaying page ==========

if( $quote_id == 0 ) {
  // Create a new quote  
	echo "<h2>New Quote </h2>";
  $a_quote = new \stdClass;
  $a_quote->title = "";
  $a_quote->quote_id = "";
  $a_quote->author = "";
  $a_quote->quote = "";

  // i don't know an easier way to just go Date.now() in php...
  $today = new DateTime('now');
  $todaystr = $today->format('Y-m-d');

  $a_quote->date = $todaystr;
  $a_quote->URL = "";

}
else {
  // Edit an existing quote.
  echo "<h2>Edit Existing Quote</h2>";

  // First we look up the quote details as it stands... 
  // For my reference: This is where we just read the requested bill and display it 
  // as it now is in the db

  // If there were updates submitted, the code above has already posted that to db
  // (or failed to do so) and this is the result.

  $query = $db->getQuery(true);
  $query->select($db->quoteName('*'));
  $query->from('quotes');
  $query->where($db->quoteName('quote_id')." = ".$db->quote($quote_id));

  $db->setQuery($query);

  $a_quote = $db->loadObject();
}

//--- Then we want to look up the related bill, whether its a new or existing quote we are editing

$query2 = $db->getQuery(true);
$query2->select($db->quoteName('*'));
$query2->from('bills');
$query2->where($db->quoteName('pipe_bill_id')." = ".$db->quote($related_bill_id));

$db->setQuery($query2);

$related_bill = $db->loadObject();

//echo "<div id='bill_id'><p>Bill ID: " . $related_bill->pipe_bill_id . "</p></div>";

echo "<div id='bill_slang_title'><h5>Quote is related to: " . $related_bill->official_title. " </h5></div>";

if(!empty($bill->slang_title)) {
  echo "<div id='bill_slang_title'><h5>Also Known As: " . $related_bill->slang_title . " </h5></div>";
}

?>

<a class="badge" href="index.php?option=com_pipebills&view=curatebill&pipe_bill_id=<?php echo $related_bill_id; ?>"> Back to Bill Details </a> |


<form method="post"> 

  <form action="index.php?option=com_pipebills&view=editbill" method="post" id="quoteForm" name="quoteForm">

  <input type="hidden" name="pipe_bill_id" value="<?php echo $related_bill_id; ?>"  />
  <input type="hidden" name="pipe_quote_id" value="<?php echo $a_quote->quote_id; ?>"  />

  <br/>

  <div class="label">Title: </div> 
  <input type="text" class="form-control span6" name="quote_title" value="<?php echo $a_quote->title ?>"><br/>

  <div class="label"> Author (Speaker):</div> 
  <input type="text" class="form-control span6" name="quote_author" value="<?php echo $a_quote->author ?>"> <br/>

  <div class="label">Quote: </div> <br/>
  <textarea name="quote" rows="5" width="100%" class="form-control span6"><?php echo $a_quote->quote ?></textarea><br/>

  <div class="label">Date:</div> 
  <input type="date" class="form-control span6" name="quote_date" value="<?php echo $a_quote->date ?>"> <br/>

  <div class="label">Source URL: </div>
  <textarea name="quote_url"  width="100%" class="form-control span6"><?php echo $a_quote->URL ?></textarea><br/>

  <input id="spinifex" value="Update Changes" type="submit" class="btn btn-success" >

    </form>
<?php
print_r($a_quote);

?>
