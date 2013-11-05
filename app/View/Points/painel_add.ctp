<div class="row">
	<div class="col-md-7 col-sm-12">
	<?php
	echo
		$this->Form->create(
			'TeamTask', array(
				'role' => 'form',
				'id' => 'form',
				'inputDefaults' => array(
					'div' => 'form-group',
					'wrapInput' => false,
					'error' => array(
						'attributes' => array(
							'wrap' => 'span',
							'class' => 'label label-danger'
						)
					)
				)
			)
		);
	?>
	<?php
	echo
		$this->Form->input(
			'team_id', array(
				'id' => 'team_id',
				'label' => 'Equipe',
				'class' => 'form-control',
				'empty' => 'Selecione'
			)
		);
	?>
	<?php
	echo
		$this->Form->input(
			'task_id', array(
				'id' => 'task_id',
				'label' => 'Prova',
				'class' => 'form-control',
				'empty' => 'Selecione'
			)
		);
	?>
	<?php
	echo
		$this->Form->input(
			'points', array(
				'id' => 'points',
				'label' => 'Pontuação',
				'class' => 'form-control',
				'min' => '0'
			)
		);
	?>
	<?php
	echo
		$this->Form->end();
	?>
	</div>
</div>