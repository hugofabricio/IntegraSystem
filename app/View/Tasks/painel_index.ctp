<?php if (count($results) > 0): ?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('name', 'Nome'); ?></th>
				<th><?php echo $this->Paginator->sort('deadline', 'Prazo'); ?></th>
				<th><?php echo $this->Paginator->sort('is_active', 'Status'); ?></th>
				<th>Adicionado por</th>
				<th>Última edição</th>
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
					<?php echo $this->Time->format('d/m/Y', $result['Task']['deadline']); ?>
				</td>
				<td>
					<?php echo $result['Task']['is_active'] === true ? 'Ativo' : 'Desativado'; ?>
				</td>
				<td>
					<?php echo $result['Creator']['name']; ?>
				</td>
				<td>
					<?php echo $result['Editor']['name']; ?>
				</td>
				<td class="text-right">
					<?php
					$class = $result['Task']['is_active'] === true ? 'close' : 'open';
					$status = $result['Task']['is_active'] === true ? 'Desativar' : 'Ativar';
					echo
						$this->Html->link(
							'<i class="glyphicon glyphicon-eye-'.$class.'"></i>',
							array(
								'controller' 			=> 'tasks',
								'action' 				=> 'status', $result['Task']['id'],
								'painel' 				=> true
							),
							array(
								'title' 				=> $status,
								'escape' 				=> false,
								'class'					=> 'btn btn-default btn-xs'
							)
						);
					?>
					<?php
					echo
						$this->Html->link(
							'<i class="glyphicon glyphicon-pencil"></i>',
							array(
								'controller' 			=> 'tasks',
								'action' 				=> 'edit', $result['Task']['id'],
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
								'controller' 			=> 'tasks',
								'action' 				=> 'delete', $result['Task']['id'],
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
<div class="alert alert-warning">Nenhuma prova cadastrada!</div>
<?php endif; ?>