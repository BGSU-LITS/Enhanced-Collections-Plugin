<?php $title = __('Edit Settings')." : ".strip_formatting(metadata('collection', array('Dublin Core', 'Title'))); ?>

<?php
	echo head(array('title' => $title, 'bodyclass' => "collections"));
	echo flash();
?>

<h2>Settings</h2>

<form method="post">
	<section class="seven columns alpha">
		<div class="field">
			<div class="two columns alpha">
				<?php echo $this->formLabel('slug', __('Slug')); ?>
			</div>
			<div class="inputs five columns omega">
				<?php echo $this->formText('slug', $this->settings['slug']); ?>
			</div>
		</div>

		<div class="field">
			<div class="two columns alpha">
				<?php echo $this->formLabel('per_page', __('Results Per Page')); ?>
			</div>
			<div class="inputs five columns omega">
				<?php echo $this->formText('per_page', $this->settings['per_page']); ?>
			</div>
		</div>

		<div class="field">
			<div class="two columns alpha">
				<?php echo $this->formLabel('theme', __('Theme')); ?>
			</div>
			<div class="inputs five columns omega">
        		<?php echo $this->formSelect('theme', $this->settings['theme'], null, $this->themes); ?>
			</div>
		</div>

		<?php fire_plugin_hook('admin_settings_form', array('view' => $this)); ?>
	</section>
	<section class="three columns omega">
		<div id="save" class="panel">
			<?php echo $this->formSubmit('submit', __('Save Changes'), array('class'=>'submit big green button')); ?>
		</div>
	</section>
</form>

<?php echo foot(); ?>
