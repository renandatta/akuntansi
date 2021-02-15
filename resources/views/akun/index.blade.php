@extends('layouts.index')

@section('title')
    {{ $title }} -
@endsection

@push('styles')
    <link href="{{ asset('assets/libs/jstree/jstree.bundle.css?v=7.0.9') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $title }}</h4>
            </div>
        </div>
    </div>
    <table class="table bg-main" >
        <tr>
            <td>
                <button class="btn btn-sm btn-success float-right px-3" onclick="add_new()">Tambah</button>
                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-database mr-2"></i> Data {{ $title }}</h5>
                <div id="akun_table">
                    <x-input prefix="search_" name="nama" caption="Pencarian nama" />
                    <div id="tree_view_akun" class="tree-demo mb-5" style="overflow-x: scroll;">
                    </div>
                </div>
            </td>
            <td class="bg-light" id="akun_info" width="350px">
            </td>
        </tr>
    </table>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/jstree/jstree.bundle.js?v=7.0.9') }}"></script>
    <script>
        init_form_element();

        // manage ui
        $akun_data = $('#akun_data');
        $search_nama = $('#search_nama')

        // search
        $akun_table = $('#akun_table');
        divTree = $("#tree_view_akun");
        divTree.jstree({
            core: {
                themes: { responsive: false },
                check_callback: true,
                data: [],
            },
            types: {
                default: {
                    icon: "fa fa-folder text-primary"
                },
            },
            plugins: ["types", "search"],
            "search" : { "show_only_matches" : true }
        }).on("refresh.jstree", function () {
            $(this).jstree("open_all");
        }).on("select_node.jstree", function (e, data) {
            on_click_tree_view_akun(data.node.original);
        });
        let to = true;
        $search_nama.keyup(function () {
            if(to) clearTimeout(to);
            to = setTimeout(function () {
                divTree.jstree(true).search($search_nama.val());
            }, 250);
        });
        function search_akun() {
            $.post("{{ route('akun.search') }}", {
                _token: '{{ csrf_token() }}', ajax: true
            }, function (result) {
                divTree.jstree(true).settings.core.data = result;
                divTree.jstree(true).refresh(true);
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        }
        search_akun();

        // crud
        $akun_info = $('#akun_info');
        $akun_info.hide();
        add_new = () => {
            let data = {_token: '{{ csrf_token() }}'};
            $.post("{{ route('akun.info') }}", data, (result) => {
                $akun_info.html(result);
                $akun_info.show();
            }).fail((xhr) => {
                $akun_info.html(xhr.responseText);
                $akun_info.show();
            });
        }
        edit_akun = (id) => {
            let data = {_token: '{{ csrf_token() }}', id};
            $.post("{{ route('akun.info') }}", data, (result) => {
                $akun_info.html(result);
                $akun_info.show();
            }).fail((xhr) => {
                $akun_info.html(xhr.responseText);
                $akun_info.show();
            });
        }
        clear_form = () => {
            $akun_info.html('');
            $akun_info.hide();
        }
        add_child = (kode) => {
            let data = {_token: '{{ csrf_token() }}', parent_kode: kode};
            $.post("{{ route('akun.info') }}", data, (result) => {
                $akun_info.html(result);
                $akun_info.show();
            }).fail((xhr) => {
                $akun_info.html(xhr.responseText);
                $akun_info.show();
            });
        }

        //treeview actions
        on_click_tree_view_akun = (data) => {
            edit_akun(data.id);
        }
    </script>
@endpush
