<script>
    var g_upload_url = '{{ admin_url('FileUpload','handle',['type'=>'upload']) }}';
    var g_upload_files = '{{ admin_url('FileUpload','handle',['type'=>'files']) }}';

    var g_import_url = '{{ admin_url('Excel','index',['type'=>'import']) }}';
    var g_import_post_url = '{{ admin_url('Excel','index',['type'=>'importpost']) }}';

    var g_icon_url = '{{ admin_url('Icon','index') }}';
    layui.config({
        version: "{{ env('APP_DEBUG')?time():'v1' }}",
        debug: false,
        base: '{{ ___("/admin/js/modules/") }}/' //静态资源所在路径
    }).extend({
        admin: '/admin' //附加入库
    }).use('admin') //加载入口





</script>
