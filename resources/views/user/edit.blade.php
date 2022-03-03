<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>


    <div class="container">
        <h2>Update Account</h2>

        @if ($errors->any())

            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ url('/user/'.$data->id) }}" method="post">

            @csrf
            @method('put')

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" id="exampleInputName" name="name"
                    placeholder="Enter Name" value="{{ $data->name}}">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Username</label>
                <input type="text" class="form-control" id="exampleInputName" name="username"
                    placeholder="Enter Name" value="{{ $data->username}}">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1"
                    name="email" placeholder="Enter email" value="{{ $data->email }}">
            </div>

            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>


    <br>






</body>

</html>
