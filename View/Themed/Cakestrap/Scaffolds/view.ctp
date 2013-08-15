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
 * @package       Cake.View.Scaffolds
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div class="<?php echo $pluralVar; ?> view clearfix">
<?php /* craft navigation */
	$sidebar = $this->Html->link(__d('cake', 'Edit %s', $singularHumanName),   array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]), array('class' => 'list-group-item'));
	$navbar = $this->Html->tag('li', $this->Html->link(__d('cake', 'Edit %s', $singularHumanName),   array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey])));
	
	$sidebar .= $this->Html->link(__d('cake', 'Delete %s', $singularHumanName), array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]), array('class' => 'list-group-item', 'data-toggle' => 'modal', 'data-target' => '#deleteModal-' . $singularHumanName . ${$singularVar}[$modelClass][$primaryKey]));
	$navbar .= $this->Html->tag('li', $this->Html->link(__d('cake', 'Delete %s', $singularHumanName), array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]), array('data-toggle' => 'modal', 'data-target' => '#deleteModal-' . $singularHumanName . ${$singularVar}[$modelClass][$primaryKey])));
	$modals[] = $this->element('delete_modal', array('object_id' => ${$singularVar}[$modelClass][$primaryKey], 'controller' => $pluralVar, 'model' => $singularHumanName));

	$sidebar .= $this->Html->link(__d('cake', 'List %s', $pluralHumanName), array('action' => 'index'), array('class' => 'list-group-item'));
	$navbar .= $this->Html->tag('li', $this->Html->link(__d('cake', 'List %s', $pluralHumanName), array('action' => 'index')));
	
	$sidebar .= $this->Html->link(__d('cake', 'New %s', $singularHumanName), array('action' => 'add'), array('class' => 'list-group-item'));
	$navbar .= $this->Html->tag('li', $this->Html->link(__d('cake', 'New %s', $singularHumanName), array('action' => 'add')));
	
	$done = array();
	foreach ($associations as $_type => $_data) {
		foreach ($_data as $_alias => $_details) {
			if ($_details['controller'] != strtolower($this->name) && !in_array($_details['controller'], $done)) {
				$sidebar .= $this->Html->link(
					__d('cake', 'List %s', Inflector::humanize($_details['controller'])),
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'index'), array('class' => 'list-group-item')
				);
				$navbar .= $this->Html->tag('li', $this->Html->link(
					__d('cake', 'List %s', Inflector::humanize($_details['controller'])),
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'index')));

				$sidebar .= $this->Html->link(
					__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))),
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'add'), array('class' => 'list-group-item')
				);
				$navbar .= $this->Html->tag('li', $this->Html->link(
					__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))),
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'add')));

				$done[] = $_details['controller'];
			}
		}
	}
?>
<div class="actions navbar hidden-lg">
	<a class="navbar-brand">Actions</a>
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <div class="nav-collapse collapse navbar-responsive-collapse">
		<ul class="nav navbar-nav">
			<?php echo $navbar; ?>
		</ul>
	</div>
</div>
<div class="actions col-lg-2 visible-lg">
	<div class="list-group">
		<div class="list-group-item">
			<h4>Actions</h4>
		</div>
		<?php echo $sidebar; ?>
	</div>
</div>
<div class="col-lg-10 col-12">
	<h2><?php echo __d('cake', 'View %s', $singularHumanName); ?></h2>
	<table class="table table-striped">
<?php
$i = 0;
foreach ($scaffoldFields as $_field) {
	echo "\t<tr>";
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $_alias => $_details) {
			if ($_field === $_details['foreignKey']) {
				$isKey = true;
				echo "\t\t<th>" . Inflector::humanize($_alias) . "</th>\n";
				echo "\t\t<td>\n\t\t\t";
				echo $this->Html->link(
					${$singularVar}[$_alias][$_details['displayField']],
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])
				);
				echo "\n\t\t&nbsp;</td>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t<th>" . Inflector::humanize($_field) . "</th>\n";
		echo "\t\t<td>" . h(${$singularVar}[$modelClass][$_field]) . "&nbsp;</td>\n";
	}
	echo "\t</tr>";
}
?>
	</table>
</div>
</div>
<?php
if (!empty($associations['hasOne'])) :
foreach ($associations['hasOne'] as $_alias => $_details): ?>
<div class="related">
	<h3><?php echo __d('cake', "Related %s", Inflector::humanize($_details['controller'])); ?></h3>
<?php if (!empty(${$singularVar}[$_alias])): ?>
	<table class="table table-striped">
<?php
		$i = 0;
		$otherFields = array_keys(${$singularVar}[$_alias]);
		foreach ($otherFields as $_field) {
			echo "\t<tr>";
			echo "\t\t<th>" . Inflector::humanize($_field) . "</th>\n";
			echo "\t\t<td>\n\t" . ${$singularVar}[$_alias][$_field] . "\n&nbsp;</td>\n";
		}
?>
	</table>
<?php endif; ?>
	<div class="actions">
		<ul class="list-unstyled">
		<li><?php
			echo $this->Html->link(
				__d('cake', 'Edit %s', Inflector::humanize(Inflector::underscore($_alias))),
				array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'edit', ${$singularVar}[$_alias][$_details['primaryKey']]),
					array('class' => 'btn btn-default btn-small')
			);
			echo "</li>\n";
			?>
		</ul>
	</div>
</div>
<?php
endforeach;
endif;

if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $_alias => $_details):
$otherSingularVar = Inflector::variable($_alias);
?>
<div class="related">
	<h3><?php echo __d('cake', "Related %s", Inflector::humanize($_details['controller'])); ?></h3>
<?php if (!empty(${$singularVar}[$_alias])): ?>
	<table class="table table-striped table-bordered">
	<tr>
<?php
		$otherFields = array_keys(${$singularVar}[$_alias][0]);
		if (isset($_details['with'])) {
			$index = array_search($_details['with'], $otherFields);
			unset($otherFields[$index]);
		}
		foreach ($otherFields as $_field) {
			echo "\t\t<th>" . Inflector::humanize($_field) . "</th>\n";
		}
?>
		<th class="actions">Actions</th>
	</tr>
<?php
		$i = 0;
		foreach (${$singularVar}[$_alias] as ${$otherSingularVar}):
			echo "\t\t<tr>\n";

			foreach ($otherFields as $_field) {
				echo "\t\t\t<td>" . ${$otherSingularVar}[$_field] . "</td>\n";
			}

			echo "\t\t\t<td class=\"actions\">\n";
			echo "\t\t\t\t";
			echo $this->Html->link(
				__d('cake', 'View'),
				array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'view', ${$otherSingularVar}[$_details['primaryKey']]),
					array('class' => 'btn btn-default btn-small')
			);
			echo "\n";
			echo "\t\t\t\t";
			echo $this->Html->link(
				__d('cake', 'Edit'),
				array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'edit', ${$otherSingularVar}[$_details['primaryKey']]),
					array('class' => 'btn btn-default btn-small')
			);
			echo "\n";
			echo "\t\t\t\t";
			echo $this->Html->link(
				__d('cake', 'Delete'),
				array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'delete', ${$otherSingularVar}[$_details['primaryKey']]),
					array('class' => 'btn btn-default btn-small', 'data-toggle' => 'modal', 'data-target' => '#deleteModal-' . ucfirst($otherSingularVar) . ${$otherSingularVar}[$_details['primaryKey']])
			);
			$modals[] = $this->element('delete_modal', array('object_id' => ${$otherSingularVar}[$_details['primaryKey']], 'controller' => $_details['controller'], 'model' => ucfirst($otherSingularVar)));
			echo "\n";
			echo "\t\t\t</td>\n";
		echo "\t\t</tr>\n";
		endforeach;
?>
	</table>
<?php endif; ?>
	<div class="actions">
		<ul class="list-unstyled">
			<li><?php echo $this->Html->link(
				__d('cake', "New %s", Inflector::humanize(Inflector::underscore($_alias))),
				array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'add'),
					array('class' => 'btn btn-default btn-small')
			); ?> </li>
		</ul>
	</div>
</div>
<?php endforeach; ?>
<?php if (!empty($modals)) echo implode("\n", $modals); ?>
