@extends('admin.layout.base')
@section('add_css')

@endsection
@section('content')
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.layout.side')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.layout.header')
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="layui-body layout-content" id="admin-app-body">
                    <div class="admin-tabs-body-item layui-show">
                        <iframe src="{{ admin_url('Home','console') }}" frameborder="0" class="admin-iframe"></iframe>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>


        </div>
        <!-- End of Content Wrapper -->

    </div>
@endsection
