<?php 

namespace app\core;

use app\core\Application;
use app\controllers\AuthController;

class Router
{

	public Request $request;
	protected array $routes = [];
	public Response $response;


	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function get($path, $callback)
	{
		$this->routes['get'][$path] = $callback ;
	}

	public function post($path, $callback)
	{
		$this->routes['post'][$path] = $callback ;
	}

	public function resolve()
	{
		$path = $this->request->getPath();
		$method = $this->request->method();
		$callback = $this->routes[$method][$path] ?? false;
		if($callback == false){
			$this->response->setStatusCode(404);
			return $this->renderView("_404");
		}
		if(is_string($callback)){
			return $this->renderView($callback);
		}
		if(is_array($callback)){
			// var_dump($callback);die;
			Application::$app->controller = new $callback[0]();
			// $callback[0] = new $callback[0];
			$callback[0] = Application::$app->controller;
		}
		// var_dump($callback[0]);die;
		// if (is_array($callback)) {
		//     $callback[0] = new $callback[0];
		// }
		return call_user_func($callback, $this->request, $this->response);
	}

	public function renderView($view, $params = [])
	{	$layoutContent = $this->layoutContent();
		$viewContent = $this->renderOnlyView($view, $params);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	public function renderContent($viewContent)
	{	$layoutContent = $this->layoutContent();
		$viewContent = $this->renderOnlyView($view);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	protected function layoutContent()
	{	
		$layout = Application::$app->controller->layout;
		ob_start();
		include_once Application::$ROOT_DIR. "/views/Layouts/$layout.php";
		return ob_get_clean();
	}
	protected function renderOnlyView($view, $params)
	{	
		foreach($params as $key => $value){
			$$key = $value;
		}
		ob_start();
		include_once Application::$ROOT_DIR. "/views/$view.php";
		return  ob_get_clean();
	}

}