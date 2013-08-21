<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div class="<?php echo $pluralVar; ?> form clearfix">
<?php /* craft navigation */
echo "<?php \n\$sidebar = \$navbar = '';\n";
if (strpos($action, 'add') === false) {
	echo "\$sidebar .= \$this->Html->link(__('Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), array('class' => 'list-group-item', 'data-toggle' => 'modal', 'data-target' => '#deleteModal-{$modelClass}' . \$this->Form->value('{$modelClass}.{$primaryKey}')));\n";
	echo "\$navbar .= \$this->Html->tag('li', \$this->Html->link(__('Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), array('data-toggle' => 'modal', 'data-target' => '#deleteModal-{$modelClass}' . \$this->Form->value('{$modelClass}.{$primaryKey}'))));\n";
	echo "\$modals[] = \$this->element('delete_modal', array('object_id' => \$this->Form->value('{$modelClass}.{$primaryKey}'), 'controller' => '{$pluralVar}', 'model' => '{$modelClass}'));\n";
}
	echo "\$sidebar .= \$this->Html->link(__('List $pluralHumanName'), array('action' => 'index'), array('class' => 'list-group-item'));";
	echo "\$navbar .= \$this->Html->tag('li', \$this->Html->link(__('List $pluralHumanName'), array('action' => 'index')));";
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != strtolower($this->name) && !in_array($details['controller'], $done)) {
				echo "\t\t\$sidebar .= \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index'), array('class' => 'list-group-item'));\n";
				echo "\t\t\$navbar .= \$this->Html->tag('li', \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')));\n";
				echo "\t\t\$sidebar .= \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class' => 'list-group-item'));\n";
				echo "\t\t\$navbar .= \$this->Html->tag('li', \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')));\n";
				$done[] = $details['controller'];
			}
		}
	}
echo "?>";
?>
<?php echo "<?php echo \$this->element('cake_navigation', compact('sidebar', 'navbar')); ?>"; ?>
<div class="col-lg-10 col-12">
<?php echo "<?php echo \$this->Form->create('{$modelClass}'); ?>\n"; ?>
	<fieldset>
		<legend><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></legend>
<?php
		echo "\t<?php\n";
		foreach ($fields as $field) {
			if (strpos($action, 'add') !== false && $field == $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
				echo "\t\techo \$this->Form->input('{$field}', array('div' => 'form-group', 'class' => 'form-control'));\n";
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\techo \$this->Form->input('{$assocName}', array('div' => 'form-group', 'class' => 'form-control'));\n";
			}
		}
		echo "\t?>\n";
?>
	</fieldset>
<?php
	echo "<?php echo \$this->Form->submit(__('Submit'), array('class' => 'btn btn-success')); ?>\n";
	echo "<?php echo \$this->Form->end(null); ?>\n";
?>
</div>
</div>
<?php echo "<?php if (!empty(\$modals)) echo implode(\"\\n\", \$modals); ?>\n"; ?>
