<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Response;

trait AppResponseTrait
{

    /**
     * @var int
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $data
     * @param array header
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param Paginator $items
     * @param $data
     * @return mixed
     */
    public function respondWithPagination(Paginator $items, $data = [])
    {
        // dd($items);
        $data = array_merge($data, [
            'paginator' => [
                'total_count'        => $items->total(),
                'total_pages'        => ceil($items->total() / $items->perPage()),
                'current_page'       => $items->currentPage(),
                'current_page_count' => $items->count(),
                'limit'              => (int) $items->perPage(),
            ],
        ]);

        return $this->setStatusCode($this->statusCode)->respondWithSuccess('', $data);
    }

    public function respondCreated($data = [])
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respond($data);
    }

    /**
     * @param string message
     * @return mixed
     */
    public function respondWithSuccess($message, $data = [])
    {
        return $this->respond([
            'status'      => 'success',
            'message'     => $message,
            'status_code' => $this->getStatusCode(),
            'data'        => $data,
        ]);
    }

    /**
     * @param string message
     * @return mixed
     */
    public function respondWithError($message, $data = [])
    {
        return $this->respond([
            'status'      => 'error',
            'message'     => $message,
            'status_code' => $this->getStatusCode(),
            'data'        => $data,
        ]);
    }

    /**
     * @param String $message
     * @return mixed mixed
     */
    public function respondNotFound($message = 'Not found!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param String $message
     * @return mixed mixed
     */
    public function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    public function respondWithValidationError($message = 'Validation failed', $data = [])
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message, $data);
    }

}
