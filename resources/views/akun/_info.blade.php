@if(!empty($akun))
    <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-pencil mr-2"></i> Ubah</h5>
@else
    <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-plus mr-2"></i> Tambah</h5>
@endif
<form id="akun_form" method="post">
    @csrf
    <x-alert type="error" id="alert_akun" />
    <input type="hidden" name="id" value="{{ $akun->id ?? '' }}">
    <input type="hidden" name="kode" value="{{ $kode ?? '-' }}">
    <input type="hidden" name="parent_kode" value="{{ $parent_kode ?? '-' }}">
    @if($is_child == true)
        <x-form-group id="parent" caption="Parent">
            <x-input name="parent" value="{{ $parent->nama ?? '' }}" readonly />
        </x-form-group>
    @endif
    <x-form-group id="nama" caption="Nama">
        <x-input name="nama" value="{{ $akun->nama ?? '' }}" />
    </x-form-group>
    <div class="text-right">
        @if(!empty($akun))
            <button type="button" class="btn btn-danger px-3 float-left" onclick="confirm_delete({{ $akun->id }})">Hapus</button>
        @endif
        <button type="button" class="btn btn-default px-3" onclick="clear_form()">Batal</button>
        <button type="submit" class="btn btn-primary px-3">Simpan</button>
        @if(!empty($akun))
            <hr class="border-white">
            <div class="row">
                <div class="col-md-5">
                    <div class="btn-group mr-5" role="group">
                        <button type="button" class="btn btn-primary" onclick="reosisi('down', '{{ $akun->id }}')"><i class="bx bx-down-arrow-alt"></i></button>
                        <button type="button" class="btn btn-primary" onclick="reosisi('up', '{{ $akun->id }}')"><i class="bx bx-up-arrow-alt"></i></button>
                    </div>
                </div>
                <div class="col-md-7">
                    @if($is_child == false)
                        <button type="button" class="btn btn-success btn-block px-3" onclick="add_child('{{ $akun->kode }}')">Tambahkan Sub</button>
                    @endif
                </div>
            </div>
        @endif
    </div>
</form>

<script>
    init_form_element();
    $akun_form = $('#akun_form');
    $akun_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($akun_form.get(0));
        $.ajax({
            url: "{{ route('akun.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                search_akun();
                clear_form();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                displayErrors('alert_akun', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });
    confirm_delete = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            console.log(result);
            if (result.value === true) {
                delete_akun(id);
            }
        })
    }
    delete_akun = (id) => {
        let data = {_token: '{{ csrf_token() }}', id};
        $.post("{{ route('akun.delete') }}", data, () => {
            search_akun();
            clear_form();
        }).fail((xhr) => {
            console.log(xhr.responseText);
        });
    }
    reosisi = (arah, id) => {
        $.post("{{ route('akun.reposisi') }}", {
            _token: '{{ csrf_token() }}', arah, id
        }, () => {
            search_akun();
            clear_form();
        }).fail((xhr) => {
            console.log(xhr.responseText);
        });
    }
</script>
