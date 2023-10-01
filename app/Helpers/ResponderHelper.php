<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Trait ResponderHelper
 *
 * @package App\Helpers
 */
trait ResponderHelper
{

    protected function response(int $code, string $message, $data = null, $other = [])
    {
        return response()
            ->json(
                collect(
                    [
                        'code' => $code,
                        'message' => $message,
                        'data' => $data
                    ]
                )->merge($other),
                $code
            );
    }

    /**
     * Default response application
     *
     * @param bool $status
     * @param int $code
     * @param string $message
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseSuccess($data = null, int $code = 200, string $message = 'Success', $other = [])
    {
        return response()
            ->json(
                collect(
                    [
                        'code' => $code,
                        'message' => $message,
                        'data' => $data
                    ]
                )->merge($other),
                $code
            );
    }

    /**
     * Response Failed
     * 
     * @param String $message Message
     * @param String $data    Data
     * 
     * @return json
     */
    public function responseFailed($message, $code = 500, $data = null)
    {
        return $this->response($code, $message, $data);
    }

    /**
     * Response Paginate
     *
     * @param JsonResource $resource
     * @param LengthAwarePaginator $data
     * @param array $other
     * @return void
     */
    public function responsePaginate($resource, LengthAwarePaginator $data, array $other = null)
    {
        return $this->responseSuccess($resource::collection($data->items()), 200, 'Success', [
            'pagination' => [
                'per_page' => $data->perPage(),
                'total_data' => $data->total(),
                'total_page' => ceil($data->total() / $data->perPage()),
                'current_page' => $data->currentPage(),
            ],
            'query' => request()->toArray(),
        ]);
    }
}
