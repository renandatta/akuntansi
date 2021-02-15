<select
    name="{{ $name }}"
    id="{{ $prefix.$name }}"
    class="form-control {{ $class }}"
    {{ $attributes }}
>
    @if($default == '1')
        <option value="">{{ $caption }}</option>
    @endif
    @foreach($options as $key => $option)
        <option value="{{ $key }}" @if($key == $value) selected @endif>{{ $option }}</option>
    @endforeach
</select>
