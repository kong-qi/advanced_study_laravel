
<div class="admin-page-tabs " id="LAY_app_tabs">
    <div class="layui-icon admin-tabs-control layui-icon-prev" tabpage-event="leftPage"></div>
    <div class="layui-icon admin-tabs-control layui-icon-next" tabpage-event="rightPage"></div>
    <div class="layui-icon admin-tabs-control layui-icon-down">

        <ul class="layui-nav admin-tabs-select" lay-filter="">

            <li class="layui-nav-item">
                <a href="javascript:;" href="javascript:;"><span class="layui-nav-more"></span></a>
                <dl class="layui-nav-child">
                    <dd tabpage-event="closeThis"><a href="javascript:;" href="javascript:;">关闭当前标签页</a>
                    </dd>
                    <dd tabpage-event="closeOther"><a href="javascript:;"
                                                      href="javascript:;">关闭其它标签页</a></dd>
                    <dd tabpage-event="closeAllTabs"><a href="javascript:;"
                                                        href="javascript:;">关闭全部标签页</a></dd>
                </dl>
            </li>

        </ul>
    </div>
    <div class="layui-tab" lay-unauto="" lay-allowclose="true" lay-filter="admin-layout-tabs">
        <ul class="layui-tab-title" id="admin-app-tab-header">
            <li lay-id="{{ admin_url('Home','console') }}" lay-attr="{{ admin_url('Home','console') }}" class=""><i
                    class="layui-icon layui-icon-home"></i><i class="layui-icon layui-unselect layui-tab-close"></i> 后台首页</li>
        </ul>
    </div>
</div>
