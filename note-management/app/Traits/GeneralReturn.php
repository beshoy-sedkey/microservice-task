<?php

namespace App\Traits;

use Illuminate\Support\Facades\Route;

trait GeneralReturn
{

    /**
     * 200 - Generic everything is OK
     *
     * @param $data
     *
     * @return mixed json
     */
    protected function Success200($data = null)
    {
        if (is_null($data))
            $data = ["data" => "Done"];

        return response($data);
    }


    /**
     * 201 - The request has been fulfilled and has resulted in one or more new resources being created.
     *
     * @return array of json
     */
    protected function Success201($resource)
    {
        return response(["action" => $resource . ' ' . 'Created Successfully'], 201);
    }


    /**
     * 202 - Accepted but is being processed async (video is encoding, image is resizing, etc)
     *
     * @return array of json
     */
    protected function Success202($resource)
    {

        $action = Route::getCurrentRoute()->getAction()['uses'];
        list($controller, $method) = explode('@', $action);
        $method = $method . 'd';
        return response(["message" => ucfirst($resource) . ' ' ."$method successfully"], 202);
    }


    /**
     * 400 - Wrong arguments (missing validation)
     *
     * @param $error
     *
     * @return mixed json
     */
    protected function error400($message, $code)
    {
        return response([
            'error' => [
                'code' => $code,
                'message' =>  $message
            ]
        ], 400);
    }


    /**
     * 401 - Unauthorized (no current user and there should be)
     *
     * @return array of json
     */
    protected function error401()
    {
        return response(["Unauthorized"], 401);
    }


    /**
     * 403 - The current user is forbidden from accessing this data
     *
     * @return array of json
     */
    protected function error403()
    {
        return response(["The current user is forbidden from accessing this data"], 403);
    }


    /**
     * 404 - That URL is not a valid route, or the item resource does not exist
     *
     * @return array of json
     */
    protected function error404()
    {
        return response(["That URL is not a valid"], 404);
    }


    /**
     * 405 - Method Not Allowed (your framework will probably do this for you)
     *
     * @return array of json
     */
    protected function error405()
    {
        return response(['message' => "Method Not Allowed"], 405);
    }


    /**
     * 410 - Data has been deleted, deactivated, suspended, etc
     *
     * @return array of json
     */
    protected function error410()
    {
        return response(["Data has been deleted, deactivated, suspended, etc"], 410);
    }

    /**
     * Reject the request for some reason.
     *
     * @param string $reason
     *
     * @return array of json
     */
    protected function error411($reason, $code = 411, $data = null)
    {
        return response([$reason], $code);
    }


    /**
     * 500 - Something unexpected happened and it is the APIs fault
     *
     * @return array of json
     */
    protected function error500()
    {
        return response([
            'error' => [
                'message' => "Internal server error",
            ]
        ], 500);
    }


    /**
     * 503 - API is not here right now, please try again later
     *
     * @return array of json
     */
    protected function error503()
    {
        return response([
            'error' => [
                'message' => "API is not here right now, please try again later",
            ]
        ], 503);
    }


    /**
     * error422 function
     *
     * @param [type] $error
     * @return response
     */
    protected function error422($error)
    {
        $message = trans('messages.invalid_data');
        if (request()->hasHeader('lang')) {
            if (request()->header('lang') == 'ar')
                $message = trans('messages.invalid_data');
        }
        return response([
            'error' => [
                'message' => $message,
                'errors' =>
                $error->errors()
            ]
        ], 422);
    }

    /**
     * customErrors function
     *
     * @param [type] $statusCode
     * @param [type] $message
     * @return response
     */
    protected function customErrors($statusCode, $message)
    {
        $data = array(
            'message' => $message
        );

        return response()->json($data, $statusCode);
    }

    /**
     * Custom Validations Errors
     *
     * @param array $errors
     * @return response
     */
    protected function customValidationsErrors(array $errors)
    {
        return response()->json($errors, 422);
    }

    /**
     * customError422 function
     *
     * @param array $errors
     * @return response
     */
    protected function customError422(array $errors)
    {
        $message = trans('messages.invalid_data');
        if (request()->hasHeader('lang')) {
            if (request()->header('lang') == 'ar')
                $message = trans('messages.invalid_data');
        }
        return response([
            'error' => [
                'message' => $message,
                'error' =>
                $errors
            ]
        ], 422);
    }
}
