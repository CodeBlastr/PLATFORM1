<?php
/* SVN FILE: $Id$ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.scaffolds
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<div class="<?php echo $pluralVar;?> form">
<?php
	echo $this->Form->create();
	echo $this->Form->inputs($scaffoldFields, array('created', 'modified', 'updated'));
	echo $this->Form->end(__('Submit', true));
?>
</div>			





<?php 
if ($this->action != 'add'):
	$menuItems[] = $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value($modelClass.'.'.$primaryKey)), null, __('Are you sure you want to delete', true).' #' . $this->Form->value($modelClass.'.'.$primaryKey)); 
endif;
	  
$done = array();
foreach ($associations as $_type => $_data) {
	foreach ($_data as $_alias => $_details) {
		if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
			$menuItems[] = $this->Html->link(sprintf(__('List %s', true), Inflector::humanize($_details['controller'])), array('controller' => $_details['controller'], 'action' => 'index'));
			$menuItems[] = $this->Html->link(sprintf(__('New %s', true), Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add'));
			$done[] = $_details['controller'];
		}
	}
}
		
// set the contextual menu items
$this->Menu->setValue(
	array(
		array(
			'heading' => $singularHumanName,
			'items' => $menuItems
		),
	)
);
?>