@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Task</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                            </div>
                        </div>

 			<!-- Task Description -->
                            <div class="form-group">
                                <label for="task-name" class="col-sm-3 control-label">Task Description</label>

                                <div class="col-sm-6">
                                    <input type="text" name="description" id="task-Description" class="form-control" value="{{ old('task-Description') }}">
                                </div>
                            </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Tasks
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Task</th>
				<th>Description</th>
				<th>Status</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                <tr>
                                    <td class="table-text"><div>{{ $task->name }}</div></td>
                                    
                                    <td class="table-text"><div>{{ $task->description }}</div></td>
				    <td class="table-text">
                                        <form action="{{ url('task/changeStatus/' . $task->id) }}" method="POST" class="form-horizontal">
                                            {{ csrf_field() }}
                                            <select name="task-status" value ="{{$task->status}}" onchange="this.form.submit()">
                                                <option value="todo" @if($task->status == 'todo') selected @endif>ToDo</option>
                                                <option value="doing" @if($task->status == 'doing') selected @endif>Doing</option>
                                                <option value="done" @if($task->status == 'done') selected @endif>Done</option>
                                            </select>
                                        </form>
                                    </td>

                                    <!-- Task Delete Button -->
                                    <td>
                                        <form action="{{url('task/' . $task->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Delete
                                            </button>
                                        </form>

                                        <form action="{{url('tasks/edit/' . $task->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('POST') }}

                                            <button type="submit" id="edit-description-{{ $task->id }}" class="btn btn-warning">
                                                <i class="fa fa-btn fa-edit"></i>Edit
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
