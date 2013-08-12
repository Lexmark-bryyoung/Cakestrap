<?php
$delete_link = $this->Form->postLink(__('Delete'), array('action' => 'delete', $object_id), array('class' => 'btn btn-danger'));
?>
<div id="deleteModal-<?php echo $object_id; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Delete Confirmation</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete # <?php echo $object_id; ?>?</p>
			</div>
			<div class="modal-footer">
				<?php echo $delete_link; ?>
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
			</div>
		</div>
	</div>
</div>
