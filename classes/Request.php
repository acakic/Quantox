<?php 

class Request
{
	public $url_parts = array();
	public $post = array();

	public function __construct()
	{
		$this->get();
		$this->post();
	}
	protected function get()
	{
		//get url params
		if (isset($_GET['url'])) {
      		return $this->url_parts = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    	}
	}
	protected function post()
	{
		foreach ($_POST as $name => $value) {
			$this->post[$name] = $value;
		}
	}
}