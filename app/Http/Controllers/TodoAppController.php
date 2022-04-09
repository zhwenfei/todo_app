<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\TodoService;
use Illuminate\Support\Facades\Auth;

class TodoAppController extends Controller
{
    /**
     * @var TodoService
     */
    protected $todoService;

    /**
     * __construct
     *
     * @param  TodoService $todoService
     * @return void
     */
    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Create todo item.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $data = $request->only([
            'id',
        ]);
        $data = Validator::make($data, [
            'id' => 'required|integer',
        ])->validate();

        $todo = $this->todoService->get($data['id']);
        if ($todo === null) {
            $responseData = [
                'message' => 'Todo item not found.',
            ];
            return response()->json($responseData, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data['userId'] = Auth::user()->id;
        if ($todo->user_id !== $data['userId']) {
            $responseData = [
                'message' => 'Unauthorised.',
            ];
            return response()->json($responseData, Response::HTTP_UNAUTHORIZED);
        }

        $responseData = [
            'data' => $todo->toArray(),
        ];
        return response()->json($responseData, Response::HTTP_OK);
    }

    /**
     * Create todo item.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->only([
            'title',
            'description',
        ]);
        $data = Validator::make($data, [
            'title' => 'required',
            'description' => 'nullable',
        ])->validate();

        $data['userId'] = Auth::user()->id;
        $todo = $this->todoService->create($data);

        $responseData = [
            'data' => $todo->toArray(),
        ];
        return response()->json($responseData, Response::HTTP_OK);
    }

    /**
     * update todo item.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->only([
            'id',
            'title',
            'description',
        ]);
        $data = Validator::make($data, [
            'id' => 'required|integer',
            'title' => 'nullable',
            'description' => 'nullable',
        ])->validate();

        $todo = $this->todoService->get($data['id']);
        if ($todo === null) {
            $responseData = [
                'message' => 'Todo item not found.',
            ];
            return response()->json($responseData, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($todo->user_id !== Auth::user()->id) {
            $responseData = [
                'message' => 'Unauthorised.',
            ];
            return response()->json($responseData, Response::HTTP_UNAUTHORIZED);
        }

        $todo = $this->todoService->update($data);
        $responseData = [
            'data' => $todo->toArray(),
        ];
        return response()->json($responseData, Response::HTTP_OK);
    }

    /**
     * Delete todo item.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $data = $request->only([
            'id',
        ]);
        $data = Validator::make($data, [
            'id' => 'required|integer',
        ])->validate();

        $todo = $this->todoService->get($data['id']);
        if ($todo === null) {
            $responseData = [
                'message' => 'Todo item not found.',
            ];
            return response()->json($responseData, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data['userId'] = Auth::user()->id;
        if ($todo->user_id !== $data['userId']) {
            $responseData = [
                'message' => 'Unauthorised.',
            ];
            return response()->json($responseData, Response::HTTP_UNAUTHORIZED);
        }

        $this->todoService->delete($data['id']);

        $responseData = [
            'message' => 'Todo item deleted.',
        ];
        return response()->json($responseData, Response::HTTP_OK);
    }

    /**
     * list all todo items.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $userId = Auth::user()->id;

        $todos = $this->todoService->list($userId);
        $responseData = [
            'data' => $todos->toArray(),
        ];
        return response()->json($responseData, Response::HTTP_OK);
    }
}
