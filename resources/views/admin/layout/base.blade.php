<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @section('title')
        <title>{{ $title ?? config('copyright.site_name') }}</title>
        <meta name="keywords" content="{{ $keyword ?? config('copyright.site_name') }}">
        <meta name="description" content="{{ $description??config('copyright.site_name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @show
    @section('theme_css')
        @include('admin.layout.common.theme')
    @show

    @yield('add_css')
    @section('font_css')

    @show
</head>
<body>


@yield('content')




@section('base_js')
    @include('admin.layout.common.js')

    @include('admin.layout.configJs')
    <script>
        //每个页面都初始化表单数据和检验表单
        layui.use([  'verify','custorm'], function () {
            var $ = layui.$


        });
    </script>
@show
@yield('foot_js')
</body>
</html>
