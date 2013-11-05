<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title_for_layout; ?> | <?php echo Configure::read('Application.name'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Styles -->
	<?php echo $this->Html->css('http://fonts.googleapis.com/css?family=Lato:100,300,400,700'); ?>

	<?php echo $this->Html->css('lib/bootstrap.min'); ?>

	<?php echo $this->Html->css('theme'); ?>

	<?php echo $this->Html->meta('/img/cms/favicon.ico', '/img/cms/icon.png', array('type' => 'icon'), true); ?>

	<!--[if lt IE 9]>
	<?php echo $this->Html->script('html5shiv'); ?>

	<![endif]-->
</head>
<body>

	<?php echo $this->element('theme/header'); ?>

	<main class="main">
		<?php echo $this->fetch('content'); ?>

		<?php echo $this->element('theme/footer'); ?>

	</main>

	<!-- Scripts -->
	<?php echo $this->Html->script('lib/jquery.min'); ?>

	<?php echo $this->Html->script('lib/bootstrap.min'); ?>

	<?php echo $this->Html->script('plugins'); ?>

	<?php if ($this->params['controller'] == 'home'): ?>
	<script type="text/javascript">
    <?php echo Highchart::setOptions($theme); ?>

    <?php echo $chart->render("chart"); ?>
	</script>
	<?php endif; ?>

	<?php echo $this->Html->script('theme'); ?>

</body>
</html>