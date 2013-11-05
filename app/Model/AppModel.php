<?php
/**
 * 
 * AppModel
 * 
 */

App::uses('Model', 'Model');

class AppModel extends Model {

	public $cacheQueries = true;

	/**
	 * Função para gerar slug do campo
	 */
	public function formatName($campo)
	{

		$slug = strtolower(Inflector::slug($campo, '-'));
		return sprintf('%s', $slug);

	}

	/**
	 * Função para converter a data para o metodo YYYY-MM-DD
	 */
	public function dateFormat($date)
	{

		return implode("-",array_reverse(explode("/",$date)));

	}

    /**
     * Função para string em slug
     */
    public function generateSlug($title)
    {

		return Inflector::slug(mb_strtolower($title), '-');

    }

    /**
     * Integra os campos calculados e os dados do modelo no CakePHP
     */
	public function afterFind($results, $primary = false)
	{

		if($primary == true) {
			if(Set::check($results, '0.0') && Set::check($results, "0." . $this->alias)) {
				$fields = array_keys( $results[0][0] );
				foreach($results as $key=>$value) {
					foreach( $fields as $fieldName ) {
						$results[$key][$this->alias][$fieldName] = $value[0][$fieldName];
					}
					unset($results[$key][0]);
				}
			}
		}
		return $results;

	}

	/**
	 * Métodos carregados antes de salvar
	 */
	function beforeSave($options = array())
	{

		$exists = $this->exists();

		// Ao adicionar um registro inclui o id do usuário que criou
		if (!$exists && $this->hasField('creator_id') && empty($this->data[$this->alias]['creator_id'])) {
			$this->data[$this->alias]['creator_id'] = AuthComponent::user('id');
		}

		// Ao editar um registro inclui o id do usuário que editou
		if ($this->hasField('editor_id') && empty($this->data[$this->alias]['editor_id'])) {
			$this->data[$this->alias]['editor_id'] = AuthComponent::user('id');
		}

        return parent::beforeSave($options);

	}

}
