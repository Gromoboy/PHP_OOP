<?php
//
// Базовый контроллер сайта.
//
abstract class C_Base extends C_Controller
{
	protected $title;		// заголовок страницы
  protected $content;		// содержание страницы
  protected $auth;

	//
	// Конструктор.
	//
	function __construct()
	{		
    
	}
	
	protected function before()
	{
		$this->title = 'Название сайта';
    $this->content = '';
    $this->auth = 'Авторизироваться';
	}
	
	//
	// Генерация базового шаблонаы
	//	
	public function render()
	{
		$vars = array('title' => $this->title, 'content' => $this->content, 'auth' => $this->auth);	
		$page = $this->Template('v/v_main.php', $vars);				
		echo $page;
	}	
}
