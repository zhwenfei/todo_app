<?php

namespace App\Services;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

class TodoService
{
    /**
     * get todo item
     *
     * @param  int $id
     * @return ?Todo
     */
    public function get(int $id) : ?Todo
    {
        $todo = Todo::find($id);
        return $todo;
    }

    /**
     * list todo items by user
     *
     * @param  int $id
     * @return Collection
     */
    public function list(int $userId) : Collection
    {
        $todos = Todo::where('user_id', $userId)->get();
        return $todos;
    }

    /**
     * create todo item
     *
     * @param  array $data
     * @return Todo
     */
    public function create(array $data) : Todo
    {
        $todo = new Todo;
        $todo->title = $data['title'];
        $todo->description = $data['description'] ?? '';
        $todo->user_id = $data['userId'];
        $todo->save();

        return $todo;
    }

    /**
     * update todo item
     *
     * @param  array $data
     * @return ?Todo
     */
    public function update(array $data) : ?Todo
    {
        $todo = $this->get($data['id']);
        if ($todo === null) {
            return null;
        }

        $todo->title = $data['title'] ?? $todo->title;
        $todo->description = $data['description'] ?? $todo->description;
        $todo->save();

        return $todo;
    }

    /**
     * complete todo item
     *
     * @param  int $id
     * @return bool
     */
    public function complete(int $id) : bool
    {
        $todo = $this->get($id);
        if ($todo === null) {
            return false;
        }

        if ($todo->complete_at !== null) {
            $todo->complete_at = date('Y-m-d H:i:s');
            $todo->save();
        }

        return true;
    }

    /**
     * delete todo item
     *
     * @param  int $id
     * @return bool
     */
    public function delete(int $id) : bool
    {
        $todo = $this->get($id);
        if ($todo === null) {
            return false;
        }

        $todo->delete();
        return true;
    }
}
