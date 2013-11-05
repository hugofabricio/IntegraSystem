<section id="provas" class="section b2">
	<div class="container">
		<div class="row">
			<header class="col-md-12">
				<h1>Provas</h1>
			</header>
			<div class="col-md-12">
				<?php if (count($results) > 0): ?>
				<ul class="media-list row">
					<?php foreach ($results as $result): ?>
					<li class="media col-md-6">
						<?php
						if (!$result['Task']['image_small']):
							$img = 'theme/nophoto.jpg';
						else:
							$img = 'tasks/' . $result['Task']['image_small'];
						endif;

						echo
							$this->Html->link(
    							$this->Html->image($img, array('alt' => 'Prova', 'class' => 'img-rounded img-responsive')),
								array(
									'controller' => 'tasks',
									'action' => 'view',
									'id' => $result['Task']['id'],
									'slug' => $result['Task']['slug']
								),
								array(
									'escape' => false,
									'class' => 'pull-left'
								)
							);
						?>

						<div class="media-body">
							<h2 class="media-heading">
								<?php echo $result['Task']['name']; ?>
							</h2>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php else: ?>
				<p>Nenhuma prova cadastrada.</p>
				<?php endif; ?>
				<?php echo $this->element('cms/pagination'); ?>
			</div>
		</div>
	</div>
</section>
