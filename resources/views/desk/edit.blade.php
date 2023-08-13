@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Desk') }}</div>
                    <div class="card-body">
                        <form action="{{ route('desks.update', ['id' => $desk->id]) }}" method="post">
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
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ $desk->name }}" placeholder="Name" required="">
                                </div>
                            <div class="mb-3">
                                <label for="symbol"  class="form-label">Symbol:</label>
                                <input type="text" name="symbol" id="symbol" value="{{ $desk->symbol }}" class="form-control">
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
{{--    <script>--}}
{{--        $.ajaxSetup({--}}
{{--            headers: {--}}
{{--                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--            }--}}
{{--        });--}}
{{--        $(document).ready(function() {--}}
{{--            $(".btn-submit").click(function(e) {--}}
{{--                e.preventDefault();--}}

{{--                var name = $("#name").val();--}}
{{--                var symbol = $("#symbol").val();--}}
{{--                var categoryId = $("select[name='category_id']").val(); // Get the selected category ID--}}

{{--                $.ajax({--}}
{{--                    type: 'POST',--}}
{{--                    url: "{{ route('desks.update', $desk->id) }}",--}}
{{--                    data: {--}}
{{--                        _token: "{{ csrf_token() }}",--}}
{{--                        _method: "PUT", // Use _method to specify the HTTP method for the update--}}
{{--                        name: name,--}}
{{--                        symbol: symbol,--}}
{{--                        category_id: categoryId, // Include the selected category ID in the data--}}
{{--                    },--}}
{{--                    success: function(data) {--}}
{{--                        if ($.isEmptyObject(data.error)) {--}}
{{--                            window.location.href = "{{ route('desks.index') }}";--}}
{{--                        } else {--}}
{{--                            printErrorMsg(data.error);--}}
{{--                        }--}}
{{--                    },--}}
{{--                    error: function(error) {--}}
{{--                        // Handle error response if needed--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}

{{--            function printErrorMsg(msg) {--}}
{{--                $(".print-error-msg").find("ul").html('');--}}
{{--                $(".print-error-msg").css('display', 'block');--}}
{{--                $.each(msg, function(key, value) {--}}
{{--                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
@endsection



