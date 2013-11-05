<section id="home" class="section">
	<div class="container">
		<div class="row">
			<header class="col-md-12">
				<h1 class="c1"><?php echo $name; ?></h1>
			</header>
			<div class="col-md-12 c1">
				<?php printf(
				__d('cake', 'O endereço %s não foi encontrado.'),
				"<strong>'{$url}'</strong>"
				); ?>
				<?php
				if (Configure::read('debug') > 0):
					echo $this->element('exception_stack_trace');
				endif;
				?>
			</div>
		</div>
	</div>
</section>
