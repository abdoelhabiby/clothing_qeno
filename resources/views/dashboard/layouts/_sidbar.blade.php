<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">


        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


            {{-- -------------------home----------------------- --}}

            <x-dashboard.sidbar-item name="home" :one-list="true" route-name-open="dashboard.home">
                <x-slot name="icon"> <i class="la la-car"></i> </x-slot>
            </x-dashboard.sidbar-item>

            {{-- ----------------users livewire show--------- --}}

            {{-- <x-dashboard.sidbar-item name="users" count="{{ App\Models\User::count() }}" :one-list="true" route-name-open="dashboard.livewire.show_usesr">
                <x-slot name="icon"> <i class="la la-car"></i> </x-slot>
            </x-dashboard.sidbar-item> --}}

            {{-- ---------------------------------------------- --}}

            {{-- -------------------users----------------------- --}}
            @php  $module_name = 'users';  @endphp

            <x-dashboard.sidbar-item name="{{ $module_name }}" :one-list="false"
                route-name-open="dashboard.{{ $module_name }}.*" count="{{ App\Models\User::count() }}">
                <x-slot name="icon"> <i class="la la-list"></i> </x-slot>

                <ul class="menu-content">
                    <x-dashboard.sidbar-item-list name="show all" route-name="dashboard.{{ $module_name }}.index" />
                    <x-dashboard.sidbar-item-list name="add" route-name="dashboard.{{ $module_name }}.create" />
                </ul>

            </x-dashboard.sidbar-item>

            {{-- --------------------------------------------------- --}}
            {{-- ------------------categories-------------- --}}

            @php  $module_name = 'categories';  @endphp

            <x-dashboard.sidbar-item name="{{ $module_name }}" :one-list="false"
                route-name-open="dashboard.{{ $module_name }}.*" count="{{ App\Models\Category::count() }}">
                <x-slot name="icon"> <i class="la la-list"></i> </x-slot>

                <ul class="menu-content">
                    <x-dashboard.sidbar-item-list name="show all" route-name="dashboard.{{ $module_name }}.index" />
                    <x-dashboard.sidbar-item-list name="add" route-name="dashboard.{{ $module_name }}.create" />
                </ul>

            </x-dashboard.sidbar-item>

            {{-- ---------------------------------------------- --}}


            {{-- -------------------products----------------------- --}}
            @php  $module_name = 'products';  @endphp
            <x-dashboard.sidbar-item name="{{ $module_name }}" :one-list="false"
                route-name-open="dashboard.{{ $module_name }}.*" count="{{ App\Models\Product::count() }}">
                <x-slot name="icon"> <i class="la la-list"></i> </x-slot>

                <ul class="menu-content">
                    <x-dashboard.sidbar-item-list name="show all" route-name="dashboard.{{ $module_name }}.index" />
                    <x-dashboard.sidbar-item-list name="add" route-name="dashboard.{{ $module_name }}.create" />
                </ul>

            </x-dashboard.sidbar-item>

            {{-- --------------------------------------------------- --}}

        </ul>

    </div>
</div>
