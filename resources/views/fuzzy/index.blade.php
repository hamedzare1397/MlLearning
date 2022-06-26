<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Fuzzy Sets and Systems</h1>
<a href="{{ route('fuzzy.index') }}">صفحه اصلی</a>
<a href="{{ route('fuzzy.learn') }}">یادگیری</a>
<a href="{{ route('fuzzy.predict') }}">پیش بینی</a>
<div>
    @yield('content')
</div>
</body>
</html>
