<?php namespace Adnduweb\Ci4Admin\Traits;

// use CodeIgniter\HTTP\ResponseInterface;
// use CodeIgniter\HTTP\IncomingRequest;


trait ApiTrait {



/**
	 * Handles failures.
	 * https://www.twilio.com/blog/create-secured-restful-api-codeigniter-php REST API
	 * @param int $code
	 * @param string $message
	 * @param boolean|null $isAjax
	 */
	public function failure(int $code, string $message, bool $isAjax = null)
	{
		log_message('debug', $message);

		if ($isAjax ?? service('request')->isAJAX())
		{

            $response = [
                'status'   => $code,
                'error'    => true,
                'messages' => [
                    'error' => $message
                ],
                csrf_token() => csrf_hash()
            ];

			return $this->response
				->setStatusCode($code)
                ->setJSON($response);
		}

		return redirect()->back()->with('error', $message);
    }

    public function getResponse(array $responseBody,int $code = ResponseInterface::HTTP_OK, $delete = null)
    {
        $response = [
            'status'   => $code,
            'error'    => null,
            'messages' => $responseBody,
            csrf_token() => csrf_hash()
        ];

        if(is_null($delete)){

        return $this
            ->response
            ->setStatusCode($code)
            ->setJSON($response);

        }else{
            return $this->respondDeleted($response);
        }
    }

    /**
     * 
     */
    public function getRequestInput(IncomingRequest $request){
        $input = $request->getPost();
        if (empty($input)) {
            //convert request body to associative array
            $input = json_decode($request->getBody(), true);
        }
        return $input;
    }

}