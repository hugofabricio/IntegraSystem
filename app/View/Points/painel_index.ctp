<?php if (count($results) > 0): ?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('Team.acronym', 'Equipe'); ?></th>
				<th><?php echo $this->Paginator->sort('Task.name', 'Prova'); ?></th>
				<th><?php echo $this->Paginator->sort('TeamTask.points', 'Pontuação'); ?></th>
				<th class="text-right">Ações</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($results as $result): ?>
			<tr>
				<th>
					<span style="background-color: <?php echo $result['Team']['color']; ?>" class="badge"><?php echo $result['Team']['acronym']; ?></span>
				</th>
				<td>
					<?php echo $result['Task']['name']; ?>
				</td>
				<td>
					<?php echo $result['TeamTask']['points']; ?>
				</td>
				<td class="text-right">
					<?php
					echo
						$this->Html->link(
							'<i class="glyphicon glyphicon-pencil"></i>',
							array(
								'controller' 			=> 'points',
								'action' 				=> 'edit', $result['TeamTask']['id'],
								'painel' 				=> true
							),
							array(
								'title' 				=> 'Editar',
								'escape' 				=> false,
								'class'					=> 'btn btn-default btn-xs'
							)
						);
					?>
					<?php
					echo
						$this->Html->link(
							'<i class="glyphicon glyphicon-remove"></i>',
							array(
								'controller' 			=> 'points',
								'action' 				=> 'delete', $result['TeamTask']['id'],
								'painel' 				=> true
							),
							array(
								'title' 				=> 'Excluir',
								'escape' 				=> false,
								'class'					=> 'btn btn-default btn-xs'
							)
						);
					?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php echo $this->element('cms/pagination'); ?>

<?php else: ?>
<div class="alert alert-warning">Nenhuma pontuação cadastrada!</div>
<?php endif; ?>