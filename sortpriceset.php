<?php

require_once 'sortpriceset.civix.php';
use CRM_Sortpriceset_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function sortpriceset_civicrm_config(&$config) {
  _sortpriceset_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function sortpriceset_civicrm_xmlMenu(&$files) {
  _sortpriceset_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function sortpriceset_civicrm_install() {
  _sortpriceset_civix_civicrm_install();
}

function sortpriceset_civicrm_pageRun(&$page) {
  if (get_class($page) == 'CRM_Price_Page_Set') {
    $rows = CRM_Core_Smarty::singleton()->get_template_vars('rows');
    if (!empty($rows)) {
      $priceSetWeights = getpricesetbyweight(TRUE);
      $weights = [];
      $count = 1;
      foreach ($rows as $id => $row) {
        $weights[$row['title']] = CRM_Utils_Array::value($id, $priceSetWeights, $count);
        $count++;
      }
      $page->assign('weights', json_encode($weights));
      CRM_Core_Region::instance('page-body')->add(array(
        'template' => "pricesetweight.tpl",
      ));
    }
  }
}

function sortpriceset_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Price_Form_Set') {
    $form->add('text', 'weight', ts('Weight'));
    CRM_Core_Region::instance('page-body')->add(array(
      'template' => "addweight.tpl",
    ));
    if ($id = $form->getVar('_sid')) {
      $defaults = [
        'weight' => CRM_Core_DAO::singleValueQuery('SELECT weight FROM civicrm_price_set_weight WHERE price_set_id = ' . $id),
      ];
      $form->setDefaults($defaults);
    }
  }
  elseif ($formName == 'CRM_Event_Form_ManageEvent_Fee') {
    $price = CRM_Price_BAO_PriceSet::getAssoc(FALSE, 'CiviEvent');
    $priceSets = getpricesetbyweight(TRUE);
    $newprice = [];
    foreach ($priceSets as $id => $weight) {
      if (array_key_exists($id, $price)) {
        $newprice[$id] = $price[$id];
        unset($price[$id]);
      }
    }
    $newprice = $newprice + $priceSets;
    $form->add('select', 'price_set_id', ts('Price Set'),
      [
        '' => ts('- none -'),
      ] + $newprice,
      NULL, ['onchange' => "return showHideByValue('price_set_id', '', 'map-field', 'block', 'select', false);"]
    );
  }
}

function sortpriceset_civicrm_postProcess($formName, &$form) {
  if ($formName == 'CRM_Price_Form_Set' && !empty($form->getVar('_sid'))) {
    if ($id = $form->getVar('_sid')) {
      $params = $form->exportValues();
      if (!empty($params['weight'])) {
        CRM_Core_DAO::executeQuery(sprintf('REPLACE INTO civicrm_price_set_weight(price_set_id, weight) VALUES (%d, %d)', $id , $params['weight']));
      }
    }
  }
}

function getpricesetbyweight($sort = FALSE) {
  $clause = $sort ? 'ORDER BY weight ASC' : '';
  $v = CRM_Core_DAO::executeQuery("SELECT price_set_id, weight FROM civicrm_price_set_weight $clause ")->fetchAll();
  $priceSet = [];
  foreach($v as $value) {
    $priceSet[$value['price_set_id']] = $value['weight'];
  }
  return $priceSet;
}


/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function sortpriceset_civicrm_postInstall() {
  _sortpriceset_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function sortpriceset_civicrm_uninstall() {
  _sortpriceset_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function sortpriceset_civicrm_enable() {
  _sortpriceset_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function sortpriceset_civicrm_disable() {
  _sortpriceset_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function sortpriceset_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _sortpriceset_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function sortpriceset_civicrm_managed(&$entities) {
  _sortpriceset_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function sortpriceset_civicrm_caseTypes(&$caseTypes) {
  _sortpriceset_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function sortpriceset_civicrm_angularModules(&$angularModules) {
  _sortpriceset_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function sortpriceset_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _sortpriceset_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function sortpriceset_civicrm_entityTypes(&$entityTypes) {
  _sortpriceset_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function sortpriceset_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function sortpriceset_civicrm_navigationMenu(&$menu) {
  _sortpriceset_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _sortpriceset_civix_navigationMenu($menu);
} // */
