<?php

namespace App\Exports\Dashboard;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class UsersExport implements
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

            'title'  => 'users',

        ];
    }


    public function map($user): array
    {



        return [
            $user->name,
            $user->email,
            $user->created_at,
        ];
    }




    public function headings(): array
    {
        return [

            // "#",
            "name",
            "email",
            "created at",
        ];
    }


    public function collection()
    {
        return $this->collect;
    }
}
