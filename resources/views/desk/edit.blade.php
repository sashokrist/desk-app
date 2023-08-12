@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Desk') }}</div>

                    <div class="card-body">
                        <form action="{{ route('desks.update', $desk->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <div class="mb-3">
                                <div class="mb-6 ">
                                    <label class="form-label">Select Category</label>
                                    <select name="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="symbol" class="form-label">Symbol:</label>
                                <input type="text" id="symbol" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">edit Name:</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ $desk->name }}" placeholder="Name" required="">
                            </div>

                            <div class="mb-3">
                                <label for="symbol" class="form-label">Symbol:</label>
                                <input type="text" id="symbol" name="symbol" value="{{ $desk->symbol }}" class="form-control" >
                            </div>

                            <div class="mb-3 text-center">
                                <button class="btn btn-success btn-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



