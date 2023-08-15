<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Add desk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Link to your app.css file -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function () {
            $(".draggable").draggable();
        });
        $(function () {
            $(".resizable").resizable();
        });
    </script>
</head>
<body>
<ul>
{{--    <li><a class="active" href="{{ route('desks.index') }}">Home</a></li>--}}
    @guest
        @if (Route::has('login'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @endif

        @if (Route::has('register'))
            <li>
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @endif
    @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div>
                <a class="dropdown-item" href="{{ route('logout') }}" style="color: blue"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    @endguest
</ul>
<div class="container">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>
            <div class="card-body">
                <div>
                    <form>
                        <div class="mb-3">
                            <label for="searchKeyword" class="form-label">Search by Name or Symbol:</label>
                            <input type="text" id="searchKeyword" name="searchKeyword" class="form-control"
                                   placeholder="Enter name or symbol">
                        </div>
                        <button type="button" class="btn btn-primary" id="searchButton">Search</button>
                        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal"
                                data-bs-target="#postModal">Create Desk
                        </button>
                    </form>
                </div>
                <div id="map">
                    @foreach($desks as $desk)
                        <div class="desk draggable resizable" data-desk-id="{{ $desk->id }}"
                             style="left: {{ $desk->position_x }}px; top: {{ $desk->position_y }}px;
                              width: {{ $desk->width }}px; height: {{ $desk->height }}px;">
                            <input type="hidden" class="deskId" value="{{ $desk->id }}">
                            <input type="hidden" class="deskPositionX" value="{{ $desk->position_x }}">
                            <input type="hidden" class="deskPositionY" value="{{ $desk->position_y }}">
                            <input type="hidden" class="deskWidth" value="{{ $desk->width }}"> <!-- Default width -->
                            <input type="hidden" class="deskHeight" value="{{ $desk->height }}"> <!-- Default height -->
                            <div class="symbol">{{ $desk->category->name }}</div>
                            <div class="symbol">{{ $desk->symbol }}</div>
                            <div class="name">{{ $desk->name }}</div>
                            <div class="modal-header">
                                <a href="#" class="btn btn-primary"
                                   data-desk-id="{{ $desk->id }}"
                                   data-name="{{ $desk->name }}" data-symbol="{{ $desk->symbol }}"
                                   data-category-id="{{ $desk->category->id }}"
                                   data-bs-toggle="modal"
                                   data-bs-target="#editModal">Edit</a>

                                <form action="{{ route('desks.destroy', $desk->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Desk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div id="map"></div>
                        <div class="modal-body">
                            <form>
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-6 ">
                                        <label class="form-label">Select Category</label>
                                        <select id="category_id" name="category_id" class="form-control">
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                           required="">
                                </div>
                                <div class="mb-3">
                                    <label for="symbol" class="form-label">Symbol:</label>
                                    <input type="text" id="symbol" name="symbol" class="form-control">
                                </div>
                                <div class="mb-3 text-center">
                                    <button class="btn btn-success btn-submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Modal -->
            <div class="modal fade" id="editModal"
                 @if ($desks->count() > 0)
                     data-desk-id="{{ $desk->id }}"
                 @endif
                 tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Desk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div id="map"></div>
                        <div class="modal-body">
                            <form>
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-6 ">
                                        <label class="form-label">Select Category</label>
                                        <select id="category_id" name="category_id" class="form-control">
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="editName" class="form-label">Name:</label>
                                    <input type="text" id="editName" name="editName" class="form-control" placeholder="Name"
                                           required="">
                                </div>
                                <div class="mb-3">
                                    <label for="editSymbol" class="form-label">Symbol:</label>
                                    <input type="text" id="editSymbol" name="editSymbol" class="form-control">
                                </div>
                                <div class="mb-3 text-center">
                                    <button class="btn btn-success btn-update">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Handle form submission
    $(".btn-submit").click(function (e) {
        e.preventDefault();

        var name = $("#name").val();
        var symbol = $("#symbol").val();
        var category_id = $("#category_id").val();
        console.log(symbol);

        $.ajax({
            type: 'POST',
            url: "{{ route('desks.store') }}",
            data: {name: name, symbol: symbol, category_id: category_id},
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    location.reload();
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    });
    // Display error messages
    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function (key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }

    $(document).ready(function () {
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var deskId = button.data('desk-id');
            var editName = button.data('name');
            var editSymbol = button.data('symbol');
            var category_id = button.data('category-id');

            var modal = $(this);
            modal.find('#deskId').val(deskId);
            modal.find('#editName').val(editName);
            modal.find('#editSymbol').val(editSymbol);
            modal.find('#category_id').val(category_id);
        });
    });

        // Handle the update action
        $(".btn-update").click(function (e) {
            e.preventDefault();
            var name = $("#editName").val();
            var symbol = $("#editSymbol").val();
            var category_id = $("#category_id").val();
            var desk_id = $("#editModal").data('desk-id');
            console.log(desk_id);
            $.ajax({
                type: 'PUT',
                url: "{{ route('desks.update', '') }}" + '/' + desk_id,
                data: {name: name, symbol: symbol, category_id: category_id, desk_id: desk_id},
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        location.reload();
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });
    // Handle search button click
    $("#searchButton").click(function (e) {
        e.preventDefault();
        var searchKeyword = $("#searchKeyword").val();
        performSearch(searchKeyword);
    });
    // Perform search using AJAX
    function performSearch(keyword) {
        $.ajax({
            type: "GET",
            url: "{{ route('desks.search') }}",
            data: {keyword: keyword},
            success: function (response) {
                updateMapWithSearchResults(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
    // Update map with search results
    function updateMapWithSearchResults(desks) {
        $("#map").empty(); // Clear existing desks

        $.each(desks, function (index, desk) {
            var deskHtml = '<div class="desk" style="left: ' + desk.position_x + 'px; top: ' + desk.position_y + 'px;">' +
                '<div class="symbol">' + desk.symbol + '</div>' +
                '<div class="name">' + desk.name + '</div>' +
                '<div class="actions">' +
                '<a href="' + desk.edit_url + '" class="btn btn-primary">Edit</a>' +
                '<button class="btn btn-danger delete-desk" data-desk-id="' + desk.id + '">Delete</button>' +
                '</div>' +
                '</div>';

            $("#map").append(deskHtml);
        });
    }
    // Update desk position
    function updateDeskPosition(deskId, positionX, positionY, width, height) {
        console.log(deskId, positionX, positionY, width, height);
        $.ajax({
            type: "POST",
            url: "{{ route('desks.updatePosition') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: deskId,
                position_x: positionX,
                position_y: positionY,
                width: width, // Include the width value
                height: height // Include the height value
            },
            success: function (response) {
                // Handle success response if needed
            },
            error: function (error) {
                printErrorMsg(data.error);
            }
        });
    }

    $(".desk").mousedown(function (e) {
        e.preventDefault();
        var desk = $(this);
        var initialX = e.clientX;
        var initialY = e.clientY;

        var deskPositionX = desk.find(".deskPositionX").val(); // Store the initial X position
        var deskPositionY = desk.find(".deskPositionY").val(); // Store the initial Y position
        var deskWidth = desk.find(".deskWidth").val(); // Store the initial width
        var deskHeight = desk.find(".deskHeight").val(); // Store the initial height

        $(document).mousemove(function (e) {
            var offsetX = e.clientX - initialX;
            var offsetY = e.clientY - initialY;

            var currentX = parseInt(desk.css("left")) || 0;
            var currentY = parseInt(desk.css("top")) || 0;

            desk.css("left", currentX + offsetX + "px");
            desk.css("top", currentY + offsetY + "px");

            initialX = e.clientX;
            initialY = e.clientY;
        });

        $(document).mouseup(function (e) {
            $(document).off("mousemove");
            $(document).off("mouseup");

            var positionX = parseInt(desk.css("left")) || 0;
            var positionY = parseInt(desk.css("top")) || 0;
            var deskId = desk.data("desk-id");

            // Update the hidden input values
            desk.find(".deskPositionX").val(positionX);
            desk.find(".deskPositionY").val(positionY);
            desk.find(".deskWidth").val(desk.width());
            desk.find(".deskHeight").val(desk.height());

            // Send updated position, width, and height to the server
            updateDeskPosition(deskId, positionX, positionY, desk.width(), desk.height());
        });
    });


    $(function () {
        // Make the desk element resizable
        $(".resizable").resizable({
            stop: function (event, ui) {
                var deskId = $(this).find(".deskId").val();
                var deskWidth = ui.size.width;
                var deskHeight = ui.size.height;

                // Update the desk size using AJAX
                updateDeskSize(deskId, deskWidth, deskHeight);
            }
        });
    });

    function updateDeskSize(deskId, width, height) {
        $.ajax({
            type: "POST",
            url: "{{ route('desks.updateSize') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: deskId,
                width: width,
                height: height
            },
            success: function (response) {
                // Handle success response if needed
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    // Handle desk deletion
    $(".delete-desk").click(function (e) {
        e.preventDefault();
        var deskId = $(this).data("desk-id");

        if (confirm("Are you sure you want to delete this desk?")) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('desks.destroy', '') }}" + "/" + deskId,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    location.reload();
                },
                error: function (error) {
                    printErrorMsg(data.error);
                }
            });
        }
    });
</script>
</html>
