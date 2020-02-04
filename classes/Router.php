<?php


class Router
{
	protected $controller = 'PagesController';
	protected $method = 'home';
	protected $params = [];
	protected $url;

	public function __construct($request)
	{	
		$this->url = $request;
		$this->availableRoutes();
	}

	public function availableRoutes()
	{
		if (isset($this->url->url_parts[0])) {
			$controller_base = $this->url->url_parts[0];
			$controller_name = ucfirst($controller_base).'Controller';
			if (file_exists('./controller/' . $controller_name . '.php')) {
				$this->controller = $controller_name;
				unset($this->url->url_parts[0]);
			}
			require_once('./controller/' . $this->controller .'.php');
			$this->controller = new $this->controller;
		}
		if (isset($this->url->url_parts[1])) {
			if (method_exists($this->controller, $this->url->url_parts[1])) {
				$this->method = $this->url->url_parts[1];
				unset($this->url->url_parts[1]);
			}
		}
		$this->params = $this->url->url_parts ? array_values($this->url->url_parts) : [];
		call_user_func_array(array($this->controller, $this->method), $this->params);
	}
}
