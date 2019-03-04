<?php
//
// Базовый контроллер сайта.
//
abstract class C_Base extends C_Controller
{

	private $title;		// заголовок страницы
  protected $content;		// содержание страницы
  protected $auth;
  // Для запоминания посещения страниц
  public function setTitle($title){
    $this->title .= $title;
    $this->pushTitleToHistory($title);
  }
  public function getTitle() {
    return $this->title;
  }

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
    $this->auth = empty($this->getLogin()) ? 'Авторизироваться' : '@'.$this->getLogin();
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
