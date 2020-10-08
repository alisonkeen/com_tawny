<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tawny
 *
 * @copyright   Copyright (C) 2020 Alison Keen
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HTML View class for the PipeBills Component
 *
 * @since  0.0.1
 */
class TawnyViewChecklist extends JViewLegacy
{
  /**
   * Display the Tawny Checklist view
   *
   * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
   *
   * @return  void
   */
  function display($tpl = null)
  {



    // Get data from the model
    $this->items    = $this->get('Items');
    $this->pagination  = $this->get('Pagination');

    // Assign data to the view
    $this->msg = $this->get('Msg');

    // Check for errors.
    $errors = $this->get('Errors');

    if (null !== $errors)
    {
      if (count($errors = $this->get('Errors'))) {
        JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

        return false;
      }
    }

    // Display the view
    parent::display($tpl);
  }
}

