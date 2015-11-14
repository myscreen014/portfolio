<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
<?php endif; ?>

<?php if (isset($options['others_actions'])): ?>
	<?php foreach ($options['others_actions'] as $key => $action) { ?>
		<?php echo '<a href="'.$action['url'].'" class="btn '.$action['class'].'">'.$action['value'].'</a>'; ?>
	<?php } ?>
<?php endif; ?>

<?= Form::button($options['label'], $options['attr']) ?>
<?php include 'help_block.php' ?>

<?php if ($options['wrapper'] !== false): ?>
</div>
<?php endif; ?>
