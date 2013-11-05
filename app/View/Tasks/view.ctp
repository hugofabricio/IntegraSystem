<section id="provas" class="section b2">
	<div class="container">
		<div class="row">
			<header class="col-md-12">
				<h1><?php echo $result['Task']['name']; ?></h1>
			</header>
			<article>
				<?php if ($result['Task']['image']): ?>
				<div class="col-sm-4 col-md-4">
				<?php echo $this->Html->image('tasks/' . $result['Task']['image'], array('alt' => 'Prova', 'class' => 'pull-left img-rounded img-responsive')); ?>
				</div>
				<?php endif; ?>
				<div class="col-sm-8 col-md-8">
					<?php echo $result['Task']['details']; ?>
				</div>
			</article>
		</div>
	</div>
</section>
