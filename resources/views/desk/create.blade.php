<!DOCTYPE html>
<html>
<head>
    <title>Add desk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- Link to the app.css file -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #draggable {
            width: 50px;
            height: 50px;
            padding: 0.5em;
        }

        .container {
            /*position: relative;*/
            width: 300%;
            height: 300px; /* Set the desired height of the map */
            border: 1px solid #ccc;
            /*margin-top: 20px;*/
        }

        .desk {
            position: absolute;
            width: 150px; /* Set the desired width of each desk */
            height: 150px; /* Set the desired height of each desk */
            background-color: #ffcc00; /* Set the background color */
            border: 1px solid #333;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 12px;
        }

        .symbol {
            font-weight: bold;
        }

        .name {
            margin-top: 5px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#draggable").draggable();
        });
    </script>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <div class="card bg-light mt-3">
                        <div class="card-header">
                            <!-- Search Form -->
                            <form class="mt-3">
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
                    </div>
                </div>
                <div class="card-body">
                    <div id="map">
                        @foreach($desks as $desk)
                            <div id="draggable" class="ui-widget-content">
                                <div class="desk"
                                     style="left: {{ $desk->position_x }}px; top: {{ $desk->position_y }}px;">
                                    <div class="symbol">{{ $desk->symbol }}</div>
                                    <div class="name">{{ $desk->name }}</div>
                                    <div class="modal-header">
                                        <a href="{{ route('desks.edit', ['desk' => $desk->id]) }}"
                                           class="btn btn-success">Edit Desk</a>
                                        <form action="{{ route('desks.destroy', $desk->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete Desk</button>
                                        </form>
                                    </div>
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
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                               required="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="symbol" class="form-label">Symbol:</label>
                                        <input type="text" id="symbol" class="form-control">
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

    $(".btn-submit").click(function (e) {
        e.preventDefault();

        var name = $("#name").val();
        var symbol = $("#symbol").val();
        console.log(symbol);

        $.ajax({
            type: 'POST',
            url: "{{ route('desks.store') }}",
            data: {name: name, symbol: symbol},
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    location.reload();
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    });

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function (key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }

    $("#searchButton").click(function (e) {
        e.preventDefault();
        var searchKeyword = $("#searchKeyword").val();
        performSearch(searchKeyword);
    });

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

    function updateDeskPosition(deskId, positionX, positionY) {
        $.ajax({
            type: "POST",
            url: "{{ route('desks.updatePosition') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: deskId,
                position_x: positionX,
                position_y: positionY
            },
            success: function (response) {
                // Handle success response if needed
            },
            error: function (error) {
                // Handle error response if needed
            }
        });
    }

    $(".desk").mousedown(function (e) {
        e.preventDefault();
        var desk = $(this);
        var initialX = e.clientX;
        var initialY = e.clientY;

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

            // Send updated position to the server
            updateDeskPosition(deskId, positionX, positionY);
        });
    });
    // Delete Desk
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
                    alert(data.success);
                    location.reload();
                },
                error: function (error) {
                    // Handle error response if needed
                }
            });
        }
    });
</script>
