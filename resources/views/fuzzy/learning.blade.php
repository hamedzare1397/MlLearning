@extends('fuzzy.index')

@section('content')
<h2>    بر اساس داده های زیر آموزش داده شد.</h2>
    <table>
        <thead>
        <tr>
            <th>شماره</th>
            <th>تایپ واقعی</th>
{{--            <th>تایپ تشخیص داده شده</th>--}}
        </tr>
        </thead>
        <tbody>
{{--    @foreach($data as $key => $value)--}}
        @foreach($data as $k => $v)
        <tr>
            <td>{{{$k}}}</td>
{{--            <td>{{$data[$key]}}</td>--}}
            <td>{{{$v}}}</td>
        </tr>

        @endforeach
{{--    @endforeach--}}
        </tbody>
    </table>
@endsection
