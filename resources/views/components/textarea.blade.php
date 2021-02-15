<textarea
    name="{{ $name }}"
    id="{{ $prefix.$name }}"
    rows="{{ $rows }}"
    class="form-control {{ $class }}"
    placeholder="{{ $caption }}"
    {{ $attributes }}
>{{ $value }}</textarea>
