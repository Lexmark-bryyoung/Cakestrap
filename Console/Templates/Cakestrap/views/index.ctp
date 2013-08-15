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
<div class="<?php echo $pluralVar; ?> index">
<?php
	echo "<?php\n";
	echo "\$sidebar = \$this->Html->link(__('New " . $singularHumanName . "'), array('action' => 'add'), array('class' => 'list-group-item'));\n";
	echo "\$navbar = \$this->Html->tag('li', \$this->Html->link(__('New " . $singularHumanName . "'), array('action' => 'add')));\n";
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
<div class="actions navbar hidden-lg">
	<a class="navbar-brand">Actions</a>
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <div class="nav-collapse collapse navbar-responsive-collapse">
		<ul class="nav navbar-nav">
			<?php echo "<?php echo \$navbar; ?>\n"; ?>
		</ul>
	</div>
</div>
<div class="actions col-lg-2 visible-lg">
	<div class="list-group">
		<div class="list-group-item">
			<h4>Actions</h4>
		</div>
		<?php echo "<?php echo \$sidebar; ?>\n"; ?>
	</div>
</div>
<div class="col-lg-10 col-12">
	<h2><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h2>
	<table class="table table-striped table-bordered">
	<tr>
	<?php foreach ($fields as $field): ?>
		<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
	<?php endforeach; ?>
		<th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
	</tr>
	<?php
	echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t<tr>\n";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
			}
		}

		echo "\t\t<td class=\"actions\">\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-default btn-small')); ?>\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-default btn-small')); ?>\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-default btn-small', 'data-toggle' => 'modal', 'data-target' => '#deleteModal-{$modelClass}' . \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "\t\t\t<?php \$modals[] = \$this->element('delete_modal', array('object_id' => \${$singularVar}['{$modelClass}']['{$primaryKey}'], 'controller' => '{$pluralVar}', 'model' => '{$modelClass}')); ?>\n";
		echo "\t\t</td>\n";
	echo "\t</tr>\n";

	echo "<?php endforeach; ?>\n";
	?>
	</table>
	<p>
	<?php echo "<?php
	echo \$this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>"; ?>
	</p>
	<div class="pagination">
	<?php
		echo "<?php\n";
		echo "\t\techo \$this->Paginator->prev('< ' . __('previous'), array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'span'));\n";
		echo "\t\techo \$this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentTag' => 'span'));\n";
		echo "\t\techo \$this->Paginator->next(__('next') . ' >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'span'));\n";
		echo "\t?>\n";
	?>
	</div>
</div>
</div>
<?php echo "<?php if (!empty(\$modals)) echo implode(\"\\n\", \$modals); ?>\n"; ?>
