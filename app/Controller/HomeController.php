<?php
/**
 * 
 * HomeController
 * 
 */

App::uses('AppController', 'Controller');
App::import('Vendor', 'HighchartsPHP/Highchart');

class HomeController extends AppController {

	/**
	 * Chama os models definidos
	 */
	public $uses = array(
		'Task',
		'Team'
	);

	/**
	 * Index
	 */
	public function index()
	{

		// Busca todas as equipes
		$teams = $this->Team->find('all', array('conditions' => array('Team.is_active' => true), 'recursive' => -1));

		// Istância um novo gráfico
		$chart = new Highchart();
		$chart->chart->renderTo = "graph";
		$chart->chart->type = "column";
		$chart->title->text = false;
		$chart->xAxis->categories = array('Equipes');
		$chart->yAxis->min = 0;
		$chart->yAxis->title->text = "Tectech´s";
		$chart->legend->enabled = true;
		$chart->legend = array('borderWidth' => 0);
		$chart->credits->enabled = false;
		$chart->export->enabled = true;
		$chart->tooltip->formatter = new HighchartJsExpr("function() {return '' + this.series.name + ': ' + this.y;}");

		// Percorre as equipes e popula o gráfico
		foreach ($teams as $result):
			$chart->series[] = array(
				'name' => $result['Team']['acronym'],
    			'data' => array((int)$result['Team']['points'])
			);
			$colours[] = $result['Team']['color'];
		endforeach;

		// Cores das equipes no gráfico
		$theme = new HighchartOption();
		$theme->colors = $colours;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Ranking',
				'chart'				=> $chart,
				'theme'				=> $theme
			)
		);

	}

	/**
	 * Painel Index
	 */
	public function painel_index()
	{

		// Busca todas as equipes
		$teams = $this->Team->find('all', array('conditions' => array('Team.is_active' => true), 'recursive' => -1));

		// Istância um novo gráfico
		$chart = new Highchart();
		$chart->chart->renderTo = "graph";
		$chart->chart->type = "column";
		$chart->title->text = false;
		$chart->xAxis->categories = array('Equipes');
		$chart->yAxis->min = 0;
		$chart->yAxis->title->text = "Tectech´s";
		$chart->legend->enabled = true;
		$chart->legend = array('borderWidth' => 0);
		$chart->credits->enabled = false;
		$chart->export->enabled = true;
		$chart->tooltip->formatter = new HighchartJsExpr("function() {return '' + this.series.name + ': ' + this.y;}");

		// Percorre as equipes e popula o gráfico
		foreach ($teams as $result):
			$chart->series[] = array(
				'name' => $result['Team']['acronym'],
    			'data' => array((int)$result['Team']['points'])
			);
			$colours[] = $result['Team']['color'];
		endforeach;

		// Cores das equipes no gráfico
		$theme = new HighchartOption();
		$theme->colors = $colours;

		// Equipe com mais pontos
		$max_points = $this->Team->find('first', array('fields' => array('MAX(Team.points) AS points')));
		$best_team = $this->Team->find('all', array('conditions' => array('Team.points' => $max_points[0]['points'])));

		// Total de Provas
		$total_tasks = $this->Task->find('count');

		// Total de Equipes
		$total_teams = $this->Team->find('count');

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Home',
				'best_team' 		=> $best_team,
				'total_tasks'		=> $total_tasks,
				'total_teams' 		=> $total_teams,
				'chart'				=> $chart,
				'theme'				=> $theme
			)
		);

	}

}
