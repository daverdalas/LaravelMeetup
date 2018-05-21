@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edycja użytkownika</div>

                    <div class="panel-body">
                        {!! Former::open(route('users.update', $user))->method('PUT') !!}
                        {!! Former::populate($user) !!}
                        {!! Former::text('name') !!}
                        {!! Former::email('email') !!}
                        {!! Former::submit('Zapisz')->addClass('center-block') !!}
                        {!! Former::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
