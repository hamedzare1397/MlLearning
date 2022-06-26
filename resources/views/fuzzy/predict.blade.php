@extends('fuzzy.index')

@section('content')
    <table>
        <thead>
        <tr>
            <th>شماره</th>
            <th>تایپ واقعی</th>
            <th>تایپ تشخیص داده شده</th>
        </tr>
        </thead>
        <tbody>
    @foreach($predict as $key => $value)
        <tr>
            <td>{{$key}}</td>
            <td>{{$data[$key]}}</td>
            <td>{{$value}}</td>
        </tr>

    @endforeach
        </tbody>
    </table>
@endsection
