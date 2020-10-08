<?php defined('_JEXEC') or die();

abstract class TawnyUsers
{

  function getCurrentUser() {

    $user = JFactory::getUser();

    return $user;

  }

  function getGroupName($group_id) {
    $db = JFactory::getDBO();

    $query = $db->getQuery(true);

    $query->select('*');
    $query->from("#__usergroups");

    $db->setQuery($query);

    $result = $db->loadObjectList();

    foreach ( $result as $joomlagroup ) {
      if($joomlagroup->id == $group_id) {
        return $joomlagroup->title;
      }
    }

    return "unknown";
  }

  function amIaVIP() {

    $db = JFactory::getDbo();

    $groupName = "VIP";
    $select = "select id from #__usergroups where title='".$groupName."'";
    $db->setQuery($select);
    $db->query();
    $data = $db->loadObject();
    $groupId = $data->id;

    if(empty($groupId)) {
      echo "PIPE Error: Couldn't confirm VIP group ID.";
      return false;
    } 

    $user = JFactory::getUser();
    $member_of = JAccess::getGroupsByUser($user->id);
    // in case an update breaks JAccess^: this function also does the same thing... 
    //$group_array = JUserHelper::getUserGroups($user->id);

    if( in_array($groupId, $member_of) ) {
      return true;
    }

    // Friends are people i have given permanent VIP status to 
    // because they are actually our friends in whatever way
    // (babysitting, support, encouragement, etc)
    if(amIaFriend() == true) {
      return true;
    }

    return false;

  }


  // Friends are people i have given permanent VIP status to 
  // because they are actually our friends in whatever way
  // (babysitting, support, encouragement, etc)
  function amIaFriend() {

    $db = JFactory::getDbo();

    $groupName = "friends";
    $select = "select id from #__usergroups where title='".$groupName."'";
    $db->setQuery($select);
    $db->query();
    $data = $db->loadObject();
    $groupId = $data->id;

    if(empty($groupId)) {
      echo "PIPE Error: Couldn't confirm VIP group ID.";
      return false;
    } 

    $user = JFactory::getUser();
    $member_of = JAccess::getGroupsByUser($user->id);
    // in case an update breaks JAccess^: this function also does the same thing... 
    //$group_array = JUserHelper::getUserGroups($user->id);

    if( in_array($groupId, $member_of) ) {
      return true;
    }

    return false;

  }

  function amILoggedIn() {

    $user = JFactory::getUser();

    // print_r($user);

    if($user == null) return false;

    if($user->id > 0) return true;

    return false;

  }

  // Add the current user to the specified group... 
  function addUserToGroup($groupname) {

      echo "Adding user to group... not implemented oops";

  }

}
