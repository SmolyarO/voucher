<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    private $statusCode = self::HTTP_OK;

    protected $user;

    const HTTP_OK = 200;
    const HTTP_NOT_FOUND = 404;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_FORBIDDEN = 403;
    const HTTP_UNAUTHORIZED = 401;


    /**
     * Sets status code.
     *
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Gets status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Respond not found
     *
     * @param string $msg
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNotFound($msg = 'Resource not found.')
    {
        return $this->respondWithError($msg, self::HTTP_NOT_FOUND);
    }

    /**
     * Respond that request is bad
     *
     * @param string $msg
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondBadRequest($msg = 'Bad request')
    {
        return $this->respondWithError($msg, self::HTTP_BAD_REQUEST);
    }

    /**
     * Respond with error
     *
     * @param string $msg
     * @param int $code
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError($msg = 'Some error occurred', $code = 500, $headers = [])
    {
        $this->setStatusCode($code);

        return response()->json([
            'error' => [
                'message' => $msg,
                'code'    => $this->getStatusCode()
            ]
        ], $this->getStatusCode(), $headers);
    }

    /**
     * Respond some data.
     *
     * @param $data
     * @param array $headers
     * @param bool $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data, $headers = [], $statusCode = false)
    {
        if ($statusCode !== false) {
            $this->setStatusCode($statusCode);
        }

        return response()->json([
            'data' => $data,
        ], $this->getStatusCode(), $headers);
    }
}
