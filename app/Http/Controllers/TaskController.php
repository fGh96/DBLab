<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Board;
use App\Task;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
   public function index(Request $request)
    {
        $boards = Board::all();
        $doneTasks = Task::where('status','=','done')->get();
        $doingTasks = Task::where('status','=','doing')->get();
        $todoTasks = Task::where('status','=','todo')->get();

        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
            'todotasks'=>$todoTasks,
            'doingtasks' => $doingTasks,
            'donetasks' => $doneTasks,
            'boards' => $boards
        ]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
     public function store(Request $request)
    {
        
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'todo',
            'board' => $request->board
        ]);

        return redirect('/tasks');
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }

public function edit(Request $request , Task $task){
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function edit_post(Request $request , Task $task){
        $task -> name = $request['name'];
        $task -> description = $request['description'];
        $task->update();

        return redirect('/tasks');

    }

    public function changeStatus (Request $request , Task $task){
        $task -> status = $request['task-status'];
        $task -> update();
        return redirect('/tasks');

    }

    public function addBoard (){
        $boards = Board::all();
        return view('tasks.board_new_edit' , ['boards' => $boards]);
    }


    public function addBoardPost(Request $request){
       $board = new Board(['name' => $request['board-name']]);
        $board -> save();
        return redirect('/boards');
    }


    public function addBoardToTask(Request $request , Task $task){
        $task->board = $request['task-board'];
        $task -> update();
        return redirect('/tasks');
    }

    public function BoardIndex(Board $board){
        $todo = Task::where('board' , $board->id) -> where('status' , 'todo')->get();
        $doing = Task::where('board' , $board->id) -> where('status' , 'doing')->get();
        $done = Task::where('board' , $board->id) -> where('status' , 'done')->get();
        $boards = Board::all();
        return view('tasks.board' , ['boards' => $boards , 'board' => $board , 'todotasks' => $todo , 'doingtasks' => $doing , 'donetasks' => $done]);

    }





}
