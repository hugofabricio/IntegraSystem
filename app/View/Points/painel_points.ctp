<?php if (count($results) > 0): ?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('Task.name', 'Prova'); ?></th>
				<th><?php echo $this->Paginator->sort('points', 'Pontuação Total'); ?></th>
				<th class="text-right">Ações</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($results as $result): ?>
			<tr>
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
								'controller' 			=> 'teams',
								'action' 				=> 'edit_points', $result['TeamTask']['id'],
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
								'controller' 			=> 'teams',
								'action' 				=> 'delete_points', $result['TeamTask']['id'],
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
<div class="alert alert-warning">Nenhuma pontuação cadastrada para esta equipe!</div>
<?php endif; ?>