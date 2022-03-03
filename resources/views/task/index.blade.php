<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Todo List</title>
</head>

<body>

    <!-- container -->
    <div class="container">
        <div class="mt-5 pt-5 my-4 text-center">
            <h1> Todo List</h1>
            <a href="{{ url('/task/create') }}">+ Add Task</a> ||  <a href="{{url('/user')}}"> My Account </a> ||  <a href="{{url('/user/logout')}}">Logout</a>
            <br>
            @php
            echo session()->get('message');
            @endphp
        </div>
        @foreach ($data as $value)

        @if (isset(auth()->user()->id) && auth()->user()->id == $value->userId)
        <div class="row  justify-content-md-center">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{url('/images/'.$value->image)}}" class="img-fluid" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $value->title }}</h5>
                            <p class="card-text">{{ substr($value->content,0,30) }}</p>
                            <div class="d-flex pt-5">
                                <div class="p-2 col-10">
                                    <p class="card-text my-0"><small class="text-muted"> start date : {{ $value->start_date}} </small></p>
                                    <p class="card-text"><small class="text-muted"> end date : {{ $value->end_date}} </small></p>
                                </div>
                                <div class="p-2 align-self-end">
                                    <a href='{{ url("/task/" . $value->id . "/edit") }}' class="link-primary">Edit</a>
                                    <a href='' data-toggle="modal" data-target="#modal_single_del{{$value->id}}" class='link-primary'>Remove </a>                         </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <div class="modal" id="modal_single_del{{$value->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">delete confirmation</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true"></span>
                       </button>
                        </div>

                        <div class="modal-body">
                        <p> Do you want to delete, {{$value->title}} ??</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{url('/task/'.$value->id)}}" method="post">

                                @csrf
                                @method('delete')

                                <div class="not-empty-record">
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endforeach
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- confirm delete record will be here -->
</body>

</html>
