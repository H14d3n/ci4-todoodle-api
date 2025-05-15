<?php


use CodeIgniter\HTTP\RequestInterface;



/**
 * Get key from request
 * Either as $_GET parameter or as HTTP Header
 *
 * @param RequestInterface $request
 * @return mixed
 */
function get_api_key_from_request(RequestInterface $request) {

	// Get API Key in request (either as $_GET parameter or as HTTP Header)
	$key = null;

	// Check get parameter first ($_GET)
	$key_by_parameter = $request->getGet('key');
	if (!empty($key_by_parameter)) {
		$key = $key_by_parameter;
	}
	else {
		
		// Then, check header if nothing is set
		$key_by_header = $request->header('key');

		if (!empty($key_by_header)) {
			$key_by_header = explode(':', $key_by_header);
			$key = $key_by_header[1] ?? null;
			
			if (!empty($key)) {
				$key = trim($key);
			}
		}

	}

	return $key;

}
