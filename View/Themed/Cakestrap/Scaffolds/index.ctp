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
<div class="<?php echo $pluralVar; ?> index clearfix">
<?php /* craft navigation */
	$sidebar = $this->Html->link(__d('cake', 'New %s', $singularHumanName), array('action' => 'add'), array('class' => 'list-group-item'));
	$navbar = $this->Html->tag('li', $this->Html->link(__d('cake', 'New %s', $singularHumanName), array('action' => 'add')));
	$done = array();
	foreach ($associations as $_type => $_data) {
		foreach ($_data as $_alias => $_details) {
			if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
				$sidebar .= $this->Html->link(
					__d('cake', 'List %s', Inflector::humanize($_details['controller'])),
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'index'),
					array('class' => 'list-group-item')
				);
				$navbar .= $this->Html->tag('li', $this->Html->link(
					__d('cake', 'List %s', Inflector::humanize($_details['controller'])),
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'index')));

				$sidebar .= $this->Html->link(
					__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))),
					array('plugin' => $_details['plugin'], 'controller' => $_details['controller'], 'action' => 'add'),
					array('class' => 'list-group-item')
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
	<h2><?php echo $pluralHumanName; ?></h2>
	<table class="table table-bordered table-striped">
		<tr>
<?php foreach ($scaffoldFields as $_field): ?>
				<th><?php echo $this->Paginator->sort($_field); ?></th>
<?php endforeach; ?>
				<th><?php echo __d('cake', 'Actions'); ?></th>
			</tr>
<?php
foreach (${$pluralVar} as ${$singularVar}):
	echo '<tr>';
		foreach ($scaffoldFields as $_field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $_alias => $_details) {
					if ($_field === $_details['foreignKey']) {
						$isKey = true;
						echo '<td>' . $this->Html->link(${$singularVar}[$_alias][$_details['displayField']], array('controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])) . '</td>';
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo '<td>' . h(${$singularVar}[$modelClass][$_field]) . '</td>';
			}
		}

		echo '<td class="actions">';
		echo $this->Html->link(__d('cake', 'View'), array('action' => 'view', ${$singularVar}[$modelClass][$primaryKey]), array('class' => 'btn btn-default btn-small'));
		echo ' ' . $this->Html->link(__d('cake', 'Edit'), array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]), array('class' => 'btn btn-default btn-small'));
		
		$modals[] = $this->element('delete_modal', array('object_id' => ${$singularVar}[$modelClass][$primaryKey], 'controller' => $pluralVar, 'model' => $singularHumanName));
		echo ' ' . $this->Html->link(__d('cake', 'Delete'), array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]), array('class' => 'btn btn-default btn-small', 'data-toggle' => 'modal', 'data-target' => '#deleteModal-' . $singularHumanName . ${$singularVar}[$modelClass][$primaryKey]));
		echo '</td>';
	echo '</tr>';

endforeach;

?>
			</table>

	<p><?php
	echo $this->Paginator->counter(array(
		'format' => __d('cake', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?></p>
	<ul class="pagination">
	<?php
		echo $this->Paginator->prev(
			'< ' . __d('cake', 'previous'), 
			array('tag' => 'li'), 
			null, 
			array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'span')
		);
		echo $this->Paginator->numbers(
			array('separator' => '', 'tag' => 'li', 'currentTag' => 'span')
		);
		echo $this->Paginator->next(
			__d('cake', 'next') .' >', 
			array('tag' => 'li'), 
			null, 
			array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'span')
		);
	?>
	</ul>
		</div>

</div>
<?php if (!empty($modals)) echo implode("\n", $modals); ?>
