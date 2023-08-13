@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ __('Desks app') }}</h1></div>

                    <div class="card-body text-center">
                        <h4>Login to view Desk dashboard</h4> <br>
                        <h4>Only admin can perform update and delete</h4><br>
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
