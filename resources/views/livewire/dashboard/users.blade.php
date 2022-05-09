<div>
    <div class="clearfix">
        <div class="float-left ">
            <div class="form-inline mb-2 ">
                <input type="search" wire:model.debounce="search" id="form1" placeholder="serach....."
                    class="form-control " />
                <i wire:loading wire:target="search" class="la la-spinner"></i>
            </div>
        </div>
        <div class="float-right">
            <div class="d-flex">
                <select wire:model="perPage" id="" class="form-control mr-1">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>

                @foreach ($exportExtensions as $ext)
                    <button class="btn btn-primary mr-1 btn-sm" wire:click="export('{{ $ext }}')"
                        wire:key="{{ $ext }}">{{ strtoupper($ext) }}</button>
                @endforeach



                @if (admin()->hasPermissionTo('delete_users'))
                    <button class="btn btn-danger" {{ !count($rowsSelectedId) > 0 ? 'disabled' : '' }}
                        wire:click="confirmDelete()">
                        Delete {{ count($rowsSelectedId) }}
                    </button>
                @endif


            </div>

        </div>
    </div>


    <table class="table display nowrap table-striped table-bordered ">
        <caption> shwo {{ $users->count() }} from {{ $users->total() }} records
            users</caption>
        <thead>
            <tr>


                <x-dashboard.table.thead sortable name='id' :sort="$order_dir" :orderBy="$orderBy" wire:key="id" />
                <x-dashboard.table.thead sortable name='name' :sort="$order_dir" :orderBy="$orderBy" wire:key="name" />
                <x-dashboard.table.thead sortable name='email' :sort="$order_dir" :orderBy="$orderBy" wire:key="email" />
                <x-dashboard.table.thead name='image' wire:key="image" />

                <x-dashboard.table.thead sortable name='created_at' :sort="$order_dir" :orderBy="$orderBy"
                    wire:key="created_at" />
                <x-dashboard.table.thead name='edit' wire:key="edit" />

                <th><input type="checkbox" name="select_all" wire:model="selectAll" wire:key="select_box"></th>



            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
                <tr>
                    <th scope="row" style="width: 5.66%">{{ $user->id }}</th>
                    <td> {{ $user->name }} </td>
                    <td> {{ $user->email }} </td>
                    <td>
                        @if ($user->image && fileExists(public_path($user->image)))
                            <img src="{{ asset($user->image) }}" alt="" width="50" height="50"
                                class="rounded-circle">
                        @endif

                    </td>
                    <td>{{ $user->created_at }}</td>


                    @if (admin()->hasPermissionTo('update_users'))
                        <td>
                            <a href="{{ route('dashboard.users.edit', $user->id) }}"> <i class="la la-edit"></i>
                            </a>
                        </td>
                    @endif

                    @if (admin()->hasPermissionTo('delete_users'))
                        <td>
                            <input type="checkbox" wire:model="rowsSelectedId" value="{{ $user->id }}">
                        </td>
                    @endif

                </tr>
            @endforeach


        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>


</div>


@section('js')
    <script>
        window.addEventListener('alert_confirm', event => {



            Swal.fire({
                title: event.detail.title,
                text: event.detail.message,
                icon: event.detail.type,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emitTo('dashboard.show-users','delete');
                }
            })


        });
    </script>
@endsection
