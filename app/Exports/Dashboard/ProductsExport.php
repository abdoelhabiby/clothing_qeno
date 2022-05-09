<?php

namespace App\Exports\Dashboard;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductsExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStrictNullComparison,
    WithProperties
{
    protected $collect;

    public function __construct(Collection $collect)
    {
        $this->collect = $collect;
    }




    public function properties(): array
    {
        return [

            'title'  => 'categories',

        ];
    }


    public function map($user): array
    {



        return [
            $user->name,
            $user->slug,
            $user->sku,
            $user->quantity,
            $user->price,
            $user->active,
            $user->vendor ? $user->vendor->name : '',
            $user->created_at

        ];
    }




    public function headings(): array
    {
        return [

            // "#",
            "name",
            "slug",
            'sku',
            'quantity',
            'price',
            'active',
            'vendor',
            "created at",
        ];
    }


    public function collection()
    {
        return $this->collect;
    }
}
