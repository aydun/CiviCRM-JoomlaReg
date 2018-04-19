<?php
/*
 * Joomla/CiviCRM Registration Plugin
 *
 * This plugin restricts user registrations to email addresses that already
 * exist in CiviCRM as the primary address of a (non-dead) Contact
 *
 * @author     Aidan Saunders (aidan.saunders@squiffle.uk)
 * @license    GNU General Public License version 3 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class plgUserRegCivi extends JPlugin {
  protected $autoloadLanguage = TRUE;

  /**
   * Check that email address is known to CiviCRM
   * @url https://docs.joomla.org/Plugin/Events/User#onUserBeforeSave
   */
  public function onUserBeforeSave($user, $isnew, $new) {
    if (!$isnew || JFactory::getApplication()->isAdmin()) {
      return TRUE;
    }

    $this->_initializeCiviCRM();

    if (!$this->_checkEmail($new['email'])) {
      throw new Exception(JText::_('PLG_USER_REGCIVI_BADEMAIL'));
      return FALSE;
    }
    return TRUE;
  }


  /**
   * Initialize CiviCRM and return config object
   */
  public function _initializeCiviCRM() {
    require_once JPATH_ROOT . '/administrator/components/com_civicrm/civicrm.settings.php';
    require_once 'CRM/Core/Config.php';
    $config = CRM_Core_Config::singleton();
    return $config;
  }

  /**
   * Check the email is primary address of one living Civi Individual
   * @param  string $email [email address to check]
   * @return [type]        [description]
   */
  public function _checkEmail($email) {
    $params = array(
      'email' => $email,
      'is_deceased' => 0,
      'contact_type' => 'Individual',
    );
    $contact = civicrm_api3('Contact', 'get', $params);
    return ($contact['count'] == 1);
  }

}
