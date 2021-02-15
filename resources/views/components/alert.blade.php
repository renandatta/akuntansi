<div class="alert {{ $type == 'error' ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show" role="alert" id="{{ $id }}" {{ $attributes }} style="display: none;">
    <div id="{{ $id }}_content"></div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
