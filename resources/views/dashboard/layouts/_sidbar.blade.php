<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">


        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            {{-- -------------------home----------------------- --}}

            <li class=" @if (request()->routeIs('dashboard.home')) active @endif"><a href="{{ route('dashboard.home') }}">
                    <i class="la la-envelope"></i>
                    <span class="menu-title" data-i18n="">Home</span></a>
            </li>
            {{-- --------------------------------------------------- --}}
            {{-- -------------------categories----------------------- --}}

            <li class="nav-item @if (request()->routeIs(['dashboard.categories.index', 'dashboard.categories.create'])) open active @endif }}">

                @php
                    $module_name = 'categories';
                @endphp

                <a href=""><i class="la la-list"></i>
                    <span class="menu-title" data-i18n="nav.dash.main"> {{ ucfirst($module_name) }}</span>
                    <span
                        class="badge badge badge-info badge-pill float-right mr-2">{{ App\Models\Category::count() }}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('dashboard.' . $module_name . '.index') ? 'active' : '' }}"><a
                            class="menu-item" href="{{ route('dashboard.' . $module_name . '.index') }}"
                            data-i18n="nav.dash.ecommerce">show all </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.' . $module_name . '.create') ? 'active' : '' }}">
                        <a class="menu-item" href="{{ route('dashboard.' . $module_name . '.create') }}"
                            data-i18n="nav.dash.crypto">
                            add
                        </a>
                    </li>


                </ul>
            </li>
            {{-- --------------------------------------------------- --}}


                {{-- -------------------products----------------------- --}}

                <li class="nav-item @if (request()->routeIs(['dashboard.products.index', 'dashboard.products.create'])) open active @endif }}">

                    @php
                        $module_name = 'products';
                    @endphp

                    <a href=""><i class="la la-list"></i>
                        <span class="menu-title" data-i18n="nav.dash.main"> {{ ucfirst($module_name) }}</span>
                        <span
                            class="badge badge badge-info badge-pill float-right mr-2">{{ App\Models\Product::count() }}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="{{ request()->routeIs('dashboard.' . $module_name . '.index') ? 'active' : '' }}"><a
                                class="menu-item" href="{{ route('dashboard.' . $module_name . '.index') }}"
                                data-i18n="nav.dash.ecommerce">show all </a>
                        </li>
                        <li class="{{ request()->routeIs('dashboard.' . $module_name . '.create') ? 'active' : '' }}">
                            <a class="menu-item" href="{{ route('dashboard.' . $module_name . '.create') }}"
                                data-i18n="nav.dash.crypto">
                                add
                            </a>
                        </li>


                    </ul>
                </li>
                {{-- --------------------------------------------------- --}}


        </ul>

    </div>
</div>
