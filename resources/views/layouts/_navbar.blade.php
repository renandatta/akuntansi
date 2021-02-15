@php($fitur_program = $fitur_program ?? array())
<nav class="navbar navbar-light navbar-expand-lg topnav-menu">
    <div class="collapse navbar-collapse" id="topnav-menu-content">
        <ul class="navbar-nav">
            @foreach($fitur_program as $item)
                @if(count($item['children']) == 0)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ has_route($item['url']) }}">
                            {{ $item['nama'] }}
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" role="button" data-toggle="dropdown">
                            {{ $item['nama'] }} <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu">
                            @foreach($item['children'] as $sub_item)
                                <a href="{{ has_route($sub_item->url) }}" class="dropdown-item">{{ $sub_item->nama }}</a>
                            @endforeach
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>
