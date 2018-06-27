<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formrule');

class JFormRuleJson extends JFormRule {

  public function test(&$element, $value, $group = null, &$input = null, &$form = null) {
    if (empty($value)) {
      return TRUE;
    }
    $is_json = json_decode($value);
    if ($is_json) {
      return TRUE;
    }
    $element->addAttribute('message', $value . ' is not valid JSON format: ' . json_last_error_msg());
    return FALSE;
  }
}

