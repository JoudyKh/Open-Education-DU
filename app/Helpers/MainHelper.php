<?php

use App\Constants\Constants;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

if (!function_exists('error')) {
    function error(string $message = null, $errors = null,  $code = 401)
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors ?? [$message],
            'code' => $code < 400 || $code > 503 ? 500 : $code,
        ], $code < 400 || $code > 503 ? 500 : $code);
    }
}
if (!function_exists('success')) {
    function success($data = null, int $code = Response::HTTP_OK, $additionalData = [])
    {
        return response()->json(
            array_merge([
                'data' => $data ?? ['success' => true],
                'code' => $code
            ], $additionalData),
            $code
        );
    }
}
if (!function_exists('throwError')) {
    function throwError($message, $errors = null, int $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        throw new HttpResponseException(response()->json(
            [
                'message' => $message,
                'errors' => $errors ?? [$message],
            ],
            $code
        ));
    }
}


if (!function_exists('paginate')) {
    function paginate(&$data, $paginationLimit = null)
    {
        $paginationLimit = $paginationLimit ?? config('app.pagination_limit');
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginatedStudents = collect($data)->forPage($page, $paginationLimit);

        // Create a LengthAwarePaginator-like structure
        $paginator = new LengthAwarePaginator(
            $paginatedStudents,
            count($data),
            $paginationLimit,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // Convert the paginator to an array with numerically indexed data
        $data = $paginator->toArray();
        $data['data'] = collect($data['data'])->values()->all();

        return $data;
    }
}
if (!function_exists('diffForHumans')) {
    function diffForHumans($time)
    {
        return Carbon::parse($time)->diffForHumans(Carbon::now(), [
            'long' => true,
            'parts' => 2,
            'join' => true,
        ]);
    }
}
if (!function_exists('pushNotification')) {
    function pushNotification($title, $description, $type, $state, $user, $modelType, $modelId, $checkDuplicated = false)
    {
        $data = [
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'state' => $state,
            'model_id' => $modelId,
            'model_type' => $modelType,
        ];

        if ($checkDuplicated) {
            $filteredData = array_diff_key($data, array_flip(['title', 'description']));
            if ($user === null) {
                User::whereHas('roles', function ($q) use ($filteredData, $data) {
                    $q->where('name', Constants::SUPER_ADMIN_ROLE);
                })->get()->map(function ($user) use ($filteredData, $data) {
                    $user->notifications()->firstOrCreate($filteredData, $data);
                });
            } else
                $user->notifications()->firstOrCreate($filteredData, $data);
        } else {
            if ($user === null) {
                User::whereHas('roles', function ($q) {
                    $q->where('name', Constants::SUPER_ADMIN_ROLE);
                })->get()->map(function ($user) use ($data) {
                    $user->notifications()->create($data);
                });
            } else
                $user->notifications()->create($data);
        }
    }
}
