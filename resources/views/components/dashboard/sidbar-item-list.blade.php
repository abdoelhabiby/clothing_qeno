<li class="{{ request()->routeIs($routeName) ? 'active' : '' }}"><a class="menu-item"
        href="{{ route($routeName) }}" data-i18n="nav.dash.ecommerce">{{ $name }} </a>
</li>
