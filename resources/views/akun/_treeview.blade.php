<link href="{{ asset('assets/libs/jstree/jstree.bundle.css?v=7.0.9') }}" rel="stylesheet" type="text/css" />
<div id="tree_view_akun" class="tree-demo mb-5" style="overflow-x: scroll;">
</div>

<script src="{{ asset('assets/libs/jstree/jstree.bundle.js?v=7.0.9') }}"></script>
<script>
    divTree = $("#tree_view_akun");
    divTree.jstree({
        core: {
            themes: {
                responsive: false
            },
            check_callback: true,
            data: JSON.parse(`{!! json_encode($akun) !!}`),
        },
        types: {
            default: {
                icon: "fa fa-folder text-primary"
            },
        },
        plugins: ["types"]
    }).on("refresh.jstree", function () {
        $(this).jstree("open_all");
    }).on("select_node.jstree", function (e, data) {
        on_click_tree_view_akun(data.node.original);
    });
    divTree.jstree(true).refresh(true);
</script>
