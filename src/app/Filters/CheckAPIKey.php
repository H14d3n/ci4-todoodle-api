<?php

namespace App\Filters;

use Config\Services;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;


class CheckAPIKey implements FilterInterface
{

    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {

        // Load API config
        $api_config = config('API');

        // First, set access to false, then check all rules
        $has_valid_api_key = FALSE;

        if ($api_config->check_api_key === TRUE) {

            // Get API Key
            $key = get_api_key_from_request($request);

            // Is API Key set?
            if (!empty($key)) {

                // Check API Key
                if (array_key_exists($key, $api_config->allowed_api_keys)) {

                    $has_valid_api_key = TRUE;

                }

            }
        }
        else {
            $has_valid_api_key = TRUE;
        }


        if (!$has_valid_api_key) {

            // Send forbidden header
            return Services::response()
                ->setJSON(
                    [
                        'error' => 'Unauthorized'
                    ]
                )->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);

        }

    }


    
    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}