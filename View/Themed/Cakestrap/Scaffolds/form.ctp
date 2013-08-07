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
<div class="<?php echo $pluralVar; ?> form clearfix">
<?php
$sidebar = $navbar = '';
if ($this->request->action !== 'add') {
	$sidebar .= $this->Form->postLink(
		__d('cake', 'Delete'),
		array('action' => 'delete', $this->Form->value($modelClass . '.' . $primaryKey)),
		array('class' => 'list-group-item'),
		__d('cake', 'Are you sure you want to delete # %s?', $this->Form->value($modelClass . '.' . $primaryKey)));
	$navbar .= $this->Html->tag('li', $this->Form->postLink(
		__d('cake', 'Delete'),
		array('action' => 'delete', $this->Form->value($modelClass . '.' . $primaryKey)),
		array('class' => 'list-group-item'),
		__d('cake', 'Are you sure you want to delete # %s?', $this->Form->value($modelClass . '.' . $primaryKey))));
}
$sidebar .= $this->Html->link(__d('cake', 'List') . ' ' . $pluralHumanName, array('action' => 'index'), array('class' => 'list-group-item'));
$navbar .= $this->Html->tag('li', $this->Html->link(__d('cake', 'List') . ' ' . $pluralHumanName, array('action' => 'index')));
$done = array();
foreach ($associations as $_type => $_data) {
	foreach ($_data as $_alias => $_details) {
		if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
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
<?php
	echo $this->Form->create();
	foreach ($scaffoldFields as $scaffold) {
		echo $this->Form->input($scaffold, array('div' => 'form-group', 'class' => 'form-control'));
	}
	echo $this->Form->submit(__d('cake', 'Submit'), array('class' => 'btn btn-success'));
	echo $this->Form->end(null);
?>
</div>
</div>
