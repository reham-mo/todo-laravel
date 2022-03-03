<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Todo List</title>
</head>

<body>

    <div class="container">

        <form class="row g-3" action="{{ url('task/' . $data->id) }}" method="post" enctype="multipart/form-data">

            @csrf
            @method('put')
            <h2 class="text-center pt-5"> Todo List</h2>
            @if ($errors->any())

            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="col-12">
                <label for="inputAddress2" class="form-label">Title</label>
                <input type="text" class="form-control" id="inputAddress2" name="title" value="{{ $data->title }}">
            </div>

            <div class="col-12">
                <label for="inputEmail4" class="form-label">Content</label>
                <input type="text" class="form-control" id="inputEmail4" name="content" value="{{ $data->content }}">
            </div>

            <div class="col-md-6">
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" type="file" id="formFile" name="image">
            </div>

            <div class="col-md-3">
                <label for="formFile" class="form-label">Start Date</label>
                <input class="form-control" type="date" id="formFile" name="start_date" value="{{ $data->start_date }}">
            </div>

            <div class="col-md-3">
                <label for="formFile" class="form-label">End Date</label>
                <input class="form-control" type="date" id="formFile" name="end_date" value="{{ $data->end_date }}">
            </div>

            <div class="col-12">
                <img src="{{ url('/images/' . $data->image) }}" height="200">
            </div>

            <div class="col-md-1 py-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

            <div class="col-md-1 py-3">
                <a href="{{ url('/task') }}" class="btn btn-primary" role="button" data-bs-toggle="button">index</a>
            </div>

        </form>
    </div>

</body>

</html>
