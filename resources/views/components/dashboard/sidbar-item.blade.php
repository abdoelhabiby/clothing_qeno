

<li class="nav-item @if (request()->routeIs($routeNameOpen)) open active @endif }}">

    <a @if($oneList) href="{{ route($routeNameOpen) }}" @endif > {{ $icon }}

        <span class="menu-title" data-i18n="nav.dash.main"> {{ ucfirst($name) }}</span>
        @if(isset($count) )
         <span class="badge badge badge-info badge-pill float-right mr-2">{{ $count }}</span>

        @endif
    </a>

    {{ $slot }}

</li>
