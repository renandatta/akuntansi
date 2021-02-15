<div class="{{ $class ?? '' }}">
    @if(in_array($file_type, array('jpg', 'jpeg', 'png', 'bmp')))
        <a target="_blank" href="{{ asset("assets/$file") }}">
            <img src="{{ asset("assets/$file") }}" alt="{{ $name }}" class="img-fluid">
        </a>
    @endif

    @if($file_type == 'pdf')
        <iframe src="{{ asset("assets/$file") }}" style="width: 100%;height: 400px;border: none;"></iframe>
    @endif
</div>
