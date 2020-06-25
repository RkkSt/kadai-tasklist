<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if(\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::check()) {
            $task = new Task;

            return view("tasks.create", [
                "task" => $task,
            ]);
        } else {
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::check()) {
            $this->validate($request, [
                'status' => 'required|max:10',
                'content' => 'required|max:191',
            ]);

            $request->user()->tasks()->create([
                'status' => $request->status,
                'content' => $request->content,
            ]);

            // 下記の記述でも反映される。
            // $task = new Task;
            // $task->content = $request->content;
            // $task->user_id = \Auth::id();
            // task->save();
        }
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Auth::check() && \Auth::id() === \Auth::user()) {
            $task = Task::find($id);

            return view('tasks.show', [
                'task' => $task,
            ]);
        }
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::check() && \Auth::id() === \Auth::user()) {
            $task = Task::find($id);

            return view('tasks.edit', [
                'task' => $task,
            ]);
        }
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::check() && \Auth::id() === \Auth::user()) {
            $this->validate($request, [
                'status' => 'required|max:191',
                'content' => 'required|max:191',
            ]);

            $task = Task::find($id);
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }
        return redirect("/");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::check() && \Auth::id() === \Auth::user()) {
            $task = Task::find($id);
            $task->delete();
        }
        return redirect("/");
    }
}
