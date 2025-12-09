<?php

class Router {
	private $routes = [];

	public function add($method, $path, $callback) {
		$this->routes[] = [
			"method" => $method,
			"path" => $path,
			"callback" => $callback,
			"middlewareFuncs" => []
		];
		return $this;
	}

	public function useMiddleware($middleware) {
		$this->routes[count($this->routes) - 1]["middlewareFuncs"][] = $middleware;
		return $this;
	}

	public function handleRequest() {
		// get current request URI
		$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

		// remove base path if exists (/public)
		$basePath = dirname($_SERVER["SCRIPT_NAME"]);
		if ($basePath !== "/") $uri = str_replace($basePath, "", $uri);

		$path = rtrim($uri, "/");
		if ($path === "") $path = "/";

		// find matching route
		$method = $_SERVER["REQUEST_METHOD"];
		foreach ($this->routes as $route) {
			if ($route["method"] !== $method) continue; // skip if method doesn't match
			if ($route["path"] !== $path) continue; // skip if path doesn't match

			// run middleware
			foreach ($route["middlewareFuncs"] as $middlewareFunc) {
				// allow middleware to deny request
				if ($middlewareFunc() === false) return;
			}

			// invoke handler
			$this->runController($route["callback"], []);
			return;
		}

		// fallback to 404
		http_response_code(404);
		echo "Page not found";
	}

	private function runController($controllerAction, $params) {
		if (strpos($controllerAction, "@") === false) return;

		list($controller, $action) = explode("@", $controllerAction);

		if (!class_exists($controller)) {
			throw new Exception("Controller {$controller} not found");
		}

		$instance = new $controller();

		if (!method_exists($instance, $action)) {
			throw new Exception("Method {$action} not found in {$controller}");
		}

		$instance->$action();
	}
}
