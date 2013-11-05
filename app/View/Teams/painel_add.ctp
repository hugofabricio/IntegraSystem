<div class="row">
	<div class="col-md-7 col-sm-12">
	<?php
	echo
		$this->Form->create(
			'Team', array(
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
			'acronym', array(
				'id' => 'acronym',
				'label' => 'Sigla',
				'class' => 'form-control'
			)
		);
	?>

	<?php
	echo
		$this->Form->input(
			'color', array(
				'id' => 'color',
				'label' => 'Cor',
				'class' => 'form-control cp'
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