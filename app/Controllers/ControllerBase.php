<?php

class ControllerBase {
	protected function render($viewPath, $data = []) {
		extract($data); // load data into variables. cool function tbh

		$viewFile = __DIR__ . "/../Views/" . $viewPath . ".php";

		if (!file_exists($viewFile)) {
			throw new Exception("View not found at path: $viewPath");
		}

		require $viewFile;
	}

	protected function redirect($path) {
		header("Location: $path");
		exit();
	}
}
