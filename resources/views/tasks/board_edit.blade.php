@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Board
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                    <form action="{{ url('task/board/add/post') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}

                    <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Board</label>

                            <div class="col-sm-6">
                                <input type="text" name="board-name" id="board-name" class="form-control" value="{{ old('board') }}">
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Board
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
</div>
            <div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Boards List
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                            <th>#</th>
                            <th>name</th>
                            <th>action</th>
                            </thead>
                            <tbody>
                        @foreach($boards as $index=>$board)
                            <tr>
                                <td>{{$index}}</td>
                                <td>{{$board->name}}</td>
                                <td>
                                    <form action="{{url('board/' . $board->id)}}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('POST') }}

                                        <button type="submit" id="show-board-{{ $board->id }}" class="btn btn-warning">
                                            <i class="fa fa-btn fa-edit"></i>View
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
