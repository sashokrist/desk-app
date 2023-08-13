@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ __('Desks app') }}</h1></div>

                    <div class="card-body text-center">
                        <a href="{{ route('desks.index') }}" class="btn btn-primary">View Desk DashBoard</a> <br>
                        <span>Only admin can perform update and delete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
