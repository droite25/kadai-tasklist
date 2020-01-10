<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    public function index()
    {
        // $tasks = Task::all();

        // return view('welcome', [
        //     'tasks' => $tasks,
        // ]);
    
    // 今回追加した奴
        $data = [];
            if (\Auth::check()) {
                $user = \Auth::user();
                $tasks = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
                // $tasks = Task::all();
                $data = [
                    'user' => $user,
                    'tasks' => $tasks,                      
                ];
                return view('tasks.index', $data);
            }
            return view('welcome', $data);
    }
    

    public function create()
    {
        $task = new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);
        
        // $task = new Task;
        // $task->content = $request->content;
        // $task->status = $request->status;
        // // $request->user()->tasklists()->create([
        // //     'user_id' => $request->user_id]);
        // // $task->user_id = $request->user_id;
        // $task->save();

        $request->user()->tasklists()->create(array(
            'content' => $request->content,
            // 'title' => $request->title,
            'status' => $request->status,
            'user_id' => $request->user_id
            ));
        return redirect('/');
    }

    public function show($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }
        return redirect('/');
        // return view('tasks.show', [
        //     'task' => $task,
        // ]);
    }

    public function edit($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }
        return redirect('/');
        // return view('tasks.edit', [
        //     'task' => $task,
        // ]);
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10'
        ]);
        
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            $task->content = $request->content;
            $task->status = $request->status;
            $task->save();
        }
        return redirect('/');
    }
    
    public function destroy($id)
    {
        $task = Task::find($id);

        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        return redirect('/');
    }
}
