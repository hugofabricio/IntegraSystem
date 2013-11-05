<?php
/**
 * AppController
 */

App::uses('Controller', 'Controller');

class AppController extends Controller {

	/**
	 * Chama os models definidos
	 */
	public $uses = array(
		'User'
	);

	/**
	 * Componentes utilizados na aplicação
	 */
	public $components = array(
		'Auth',
		'Session',
		'Cookie'
	);

	/**
	 * Helpers utilizados na aplicação
	 */
	public $helpers = array(
		'Html',
		'Form' => array('className' => 'BoostCakeForm'),
		'Session',
		'Active'
	);

	/**
	 * Métodos carregados antes da action ser chamada 
	 */
	public function beforeFilter()
	{

		// Se acessar prefixo cliente
		if ($this->isPrefix('painel')):

			// Troca o layout
			$this->layout = 'cms';

			// Configurações do Auth
			$this->_authPainel();

		else:

			// Libera as demais páginas
			$this->Auth->allow();

		endif;

		// Seta o usuário
		if ($this->Auth->user())
            $this->set(array('usuario' => $this->Auth->user()));

	}

	/**
	 * Função para verificar o prefixo atual
	 */
	private function isPrefix($prefix)
	{
		return isset($this->request->params['prefix']) &&
					 $this->request->params['prefix'] == $prefix;
	}

	/**
	 * Configurações Auth Component Painel
	 */
	private function _authPainel()
	{

		// Configurações do Cookie
		$this->Cookie->time = '30 Days';
		$this->Cookie->key = 'FF()XA(S*D)AS3sA(Sd80A(SDA*STDASAS#!@2DSA4$AS#SD@ASDtyASIH)_AS0dAoIASNKAshgaFfda3tFASDASgfSG3d#A@$SDAZCHVASCa4s33%$ˆ$%$#s253$AS5#Â$%s645$#AS@%#AˆS6%A&*SÂ%S$';
		$this->Cookie->httpOnly = true;

		// Chave da Sessão
		AuthComponent::$sessionKey = 'Auth.Painel';

		// Configurações de Autenticação
		$this->Auth->authenticate = array(
			'Blowfish' => array(
				'userModel' => 'User',
				'scope' => array(
					'User.is_active' => true
				)
			)
		);

		// Página de login
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'painel' => true);

		// Redirecionamento ao logar
		$this->Auth->loginRedirect = array('controller' => 'home', 'action' => 'index', 'painel' => true);

		// Redirecionamento ao sair
		$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'painel' => true);

		if (!$this->Auth->loggedIn() && $this->Cookie->check('Auth.Painel')):

			// Cookie
			$cookie = $this->Cookie->read('Auth.Painel');

			// Busca o usuário
			$usuario = $this->User->find('first', array(
				'conditions' => array(
						'User.username' => $cookie['username']
					)
				)
			);

			// Login manual do usuário
			if ($this->Auth->login($usuario['User'])){
				$this->redirect('/painel');
			}

			// Login automatico do usuário
			if ($this->Auth->loggedIn() && $this->params->controller == 'users' && $this->params->action == 'painel_login')
				$this->redirect('/painel');

		endif;

	}

}
