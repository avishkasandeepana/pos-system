<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>hellp</h2>
    {{-- Example: Accessing loginId in the dashboard view --}}
Welcome! Your login ID is: {{ $userData->id }}
<h1>user name = {{ $userData->username }}</h1>
<a href="{{ route('logout') }}"><h5> logout</h5></a>

</body>
</html>