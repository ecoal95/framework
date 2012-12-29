<?php
class Response {
	public static function json($args, $callback = null, $echo = true) {
		$response = json_encode($args);

		if( $callback ) {
			header('Content-Type: text/javascript; charset=UTF-8');
			$response = $callback . '(' . $response . ')';
		} else {
			header('Content-Type: application/json; charset=UTF-8');
		}

		if( $echo ) {
			echo $response;
		} else {
			return $response;
		}
		
		return true;
	}
	public static function error($error_code = 404, $echo = false) {
		$error_path = Config::get('path.views') . 'error/';
		$response = null;
		switch ($error_code) {
			case 404:
				header('Status: HTTP 1.1 404 Not Found');
				break;
			case 500:
				header('Status: HTTP 1.1 500 Internal Server Error');
				break;
		}
		if( file_exists( $error_path . $error_code . '.php') ) {
			ob_start();
			include $error_path . $error_code . '.php';
			$response = ob_get_clean();
		}
		if( $echo ) {
			echo $response;
		} else {
			return $response;
		}
		return true;
	}
}