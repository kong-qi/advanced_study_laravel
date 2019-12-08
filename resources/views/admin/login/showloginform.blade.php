@extends('admin.layout.base')
@section('add_css')

@endsection
@section('content')

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="layui-form">
                            @csrf
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">后台管理</h1>
                                        </div>
                                        <div class="user">
                                            <div class="form-group">
                                                <input type="text" name="account" id="LAY-user-login-username"
                                                       lay-verify="required"
                                                       placeholder="用户名" class="form-control form-control-user">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" id="LAY-user-login-password"
                                                       lay-verify="required"
                                                       placeholder="密码" class="form-control form-control-user">

                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="captcha" id="LAY-user-login-vercode" lay-verify="required"
                                                       placeholder="图形验证码" class="form-control form-control-user" style="width: 150px;display: inline-block">
                                                <img src="{{ route('api.captcha',['type'=>3]) }}"
                                                     data-src="{{ route('api.captcha',['type'=>3]) }}"
                                                     class="layadmin-user-login-codeimg" id="LAY-user-get-vercode">
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" lay-ignore class="custom-control-input" name="remember"
                                                           id="customCheck" title="记住密码">
                                                    <label class="custom-control-label" for="customCheck">记住密码</label>

                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-user btn-block" lay-submit
                                                    lay-filter="LAY-user-login-submit">登 入
                                            </button>

                                            <hr>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>



@endsection
@section('foot_js')
    <script>

        var postLoginUrl = '{{ route('admin.post.login') }}';

        layui.use([  'verify', 'request','form'], function () {

            var $ = layui.$
                , request = layui.request
                , form = layui.form
                , layer = layui.layer;

            //提交
            form.on('submit(LAY-user-login-submit)', function (obj) {
                request.post(postLoginUrl, obj.field, function (res) {
                    if (res.code != 200) {
                        layer.msg(res.msg, {icon: 5, shift: 6});
                        //刷新验证码
                        $("#LAY-user-get-vercode").click();
                    } else {
                        layer.msg(res.msg, {icon: 1, shift: 6});
                        location.href = res.data; //后台主页
                    }
                })

            });

            //更换图形验证码
            $("body").on('click', '#LAY-user-get-vercode', function () {
                var othis = $(this);
                this.src = othis.data('src') + '?t=' + new Date().getTime()
            });

        })
    </script>
@endsection
