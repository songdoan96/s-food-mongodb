<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>


</head>

<body>
  {{-- <form action="{{ route('upload') }}" method="post">
    @csrf
    <input type="file" name="file">
    <button type="submit">Upload</button>
  </form> --}}


  {{-- <form class="form-vertical" role="form" enctype="multipart/form-data" method="post" action="{{ route('upload') }}">
    {{ csrf_field() }}

    <input type="file" name="image" class="form-control" id="name" value="">

    <button type="submit" class="btn btn-success">Upload Image </button>
  </form> --}}
</body>

</html>
