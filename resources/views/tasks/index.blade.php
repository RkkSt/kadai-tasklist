@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <h1>{{ Auth::user()->name }}のタスク一覧</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>ステータス</th>
                        <th>タスク</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        <td>{!! link_to_route("tasks.show", $task->id, ["task" => $task->id]) !!}</td>
                        <td>{!! $task->status !!}</td>
                        <td>{!! Nl2br(e($task->content)) !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $tasks->links('pagination::bootstrap-4') }}
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the tasklist</h1>
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection