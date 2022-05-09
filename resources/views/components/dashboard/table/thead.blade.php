@props([
    'sort' => 'asc',
    'name',
    'sortable',
    'orderBy' => 'id',
    'thName'
])

@if (isset($sortable))
    <th {{ $attributes }} wire:click="orderBy('{{ $name }}')">
        <span class="text-nowrap">
            {{ $thName ?? $name }}
            <i class="la la-angle-{{ $sort == 'asc' ? 'down' : 'up' }} {{ $orderBy != $name ? 'd-none' : '' }} " style=" font-size: 1rem;">
            </i>
        </span>
    </th>
@else
    <th {{ $attributes }}> <span class="text-nowrap">
            {{ $name }}

        </span>
    </th>
@endif
