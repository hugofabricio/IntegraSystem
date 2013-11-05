<?php if (count($results) > 0): ?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('acronym', 'Sigla'); ?></th>
				<th><?php echo $this->Paginator->sort('name', 'Curso'); ?></th>
				<th><?php echo $this->Paginator->sort('points', 'Total Tectech´s'); ?></th>
				<th><?php echo $this->Paginator->sort('is_active', 'Status'); ?></th>
				<th>Adicionado por</th>
				<th>Última edição</th>
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
					<?php echo $result['Team']['name']; ?>
				</td>
				<td>
					<?php echo $result['Team']['points']; ?>
				</td>
				<td>
					<?php echo $result['Team']['is_active'] === true ? 'Ativo' : 'Desativado'; ?>
				</td>
				<td>
					<?php echo $result['Creator']['name']; ?>
				</td>
				<td>
					<?php echo $result['Editor']['name']; ?>
				</td>
				<td class="text-right">
					<?php
					echo
						$this->Html->link(
							'<i class="glyphicon glyphicon-thumbs-up"></i>',
							array(
								'controller' 			=> 'teams',
								'action' 				=> 'points', $result['Team']['id'],
								'painel' 				=> true
							),
							array(
								'title' 				=> 'Pontuação',
								'escape' 				=> false,
								'class'					=> 'btn btn-default btn-xs'
							)
						);
					?>
					<?php
					$class = $result['Team']['is_active'] === true ? 'close' : 'open';
					$status = $result['Team']['is_active'] === true ? 'Desativar' : 'Ativar';
					echo
						$this->Html->link(
							'<i class="glyphicon glyphicon-eye-'.$class.'"></i>',
							array(
								'controller' 			=> 'teams',
								'action' 				=> 'status', $result['Team']['id'],
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
								'controller' 			=> 'teams',
								'action' 				=> 'edit', $result['Team']['id'],
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
								'action' 				=> 'delete', $result['Team']['id'],
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
<div class="alert alert-warning">Nenhuma equipe cadastrada!</div>
<?php endif; ?>