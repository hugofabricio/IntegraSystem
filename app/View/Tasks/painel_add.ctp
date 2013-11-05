<div class="row">
	<div class="col-md-7 col-sm-12">
	<?php
	echo
		$this->Form->create(
			'Task', array(
				'role' => 'form',
				'id' => 'form',
				'type' => 'file',
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
			'name', array(
				'id' => 'name',
				'label' => 'Nome',
				'class' => 'form-control'
			)
		);
	?>

	<?php
	echo
		$this->Form->input(
			'deadline', array(
				'id' => 'deadline',
				'label' => 'Data de Entrega',
				'class' => 'dp form-control',
				'readonly' => 'readonly',
				'type' =>'text',
				'value' => date('d/m/Y')
			)
		);
	?>

	<?php
	echo
		$this->Form->input(
			'details', array(
				'id' => 'details',
				'label' => 'Detalhes',
				'class' => 'form-control'
			)
		);
	?>

	<?php
	echo
		$this->Form->input(
			'image', array(
				'id' => 'image',
				'label' => 'Imagem',
				'type' => 'file'
			)
		);
	?>

	<?php
	echo
		$this->Form->input(
			'is_active',
			array(
				'id' => 'is_active',
				'label' => 'Ativo?'
			)
		);
	?>

	<?php
	echo
		$this->Form->end();
	?>
	</div>
</div>