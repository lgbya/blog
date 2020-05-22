<script src="{{asset('vendor/laravel-admin-ext/editormd/editormd-1.5.0/lib/flowchart.min.js')}}"></script>
<script src="{{asset('vendor/laravel-admin-ext/editormd/editormd-1.5.0/lib/jquery.flowchart.min.js')}}"></script>
<script src="{{asset('vendor/laravel-admin-ext/editormd/editormd-1.5.0/lib/marked.min.js')}}"></script>
<script src="{{asset('vendor/laravel-admin-ext/editormd/editormd-1.5.0/lib/prettify.min.js')}}"></script>
<script src="{{asset('vendor/laravel-admin-ext/editormd/editormd-1.5.0/lib/raphael.min.js')}}"></script>
<script src="{{asset('vendor/laravel-admin-ext/editormd/editormd-1.5.0/lib/underscore.min.js')}}"></script>
<script src="{{asset('vendor/laravel-admin-ext/editormd/editormd-1.5.0/lib/sequence-diagram.min.js')}}"></script>
<script src="{{asset('vendor/laravel-admin-ext/editormd/editormd-1.5.0/js/editormd.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('vendor/laravel-admin-ext/editormd/editormd-1.5.0/css/editormd.min.css')}}" />

<div id="doc-content">
    <textarea   style="display:none;">{!!$docContent!!}</textarea>
</div>

<div id="content">
</div>
<script type="text/javascript">
    var ShowEditor;
    $(function () {
        ShowEditor = editormd.markdownToHTML("doc-content", {//注意：这里是上面DIV的id
            htmlDecode: "style,script,iframe",
            emoji: true,
            taskList: true,
            tex: true, // 默认不解析
            flowChart: true, // 默认不解析
            sequenceDiagram: true, // 默认不解析
            codeFold: true,
        });});
</script>