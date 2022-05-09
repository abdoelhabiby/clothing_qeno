<?php

namespace App\Http\Livewire\Dashboard\Traits;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;


trait DataTableTrait
{

    public $order_dir = 'desc'; //asc or desc
    public $orderBy = 'id';
    public $search;
    public Collection  $rowsCollection; //use with export
    public $rowsSelectedId = [];
    public $selectAll = false;
    public $perPage = 10;




    public function orderBy($column)
    {

       if(!in_array($column,$this->columns_can_order)){

           return false;
       }

        if ($this->orderBy == $column) {

            $this->order_dir = $this->order_dir == 'asc' ? 'desc' : 'asc';
        } else {
            $this->order_dir = 'desc';
        }

        $this->orderBy = $column;
        $this->resetPage();
    }




    // -----------------------------------------

    public function updatedSelectAll($value)
    {

        if ($value) {
            $this->rowsSelectedId =  $this->rowsCollection->pluck('id');
        } else {
            $this->rowsSelectedId = [];
        }
    }
    // ----------------------------------------
    public function updatedRowsSelectedId()
    {
        $this->selectAll = false;
    }
    // ----------------------------------------

    public function updatedPerPage($value)
    {
        abort_if(!in_array($value, [10, 25, 50, 100]), Response::HTTP_NOT_FOUND);
        $this->resetPage();

    }
    // ----------------------------------------

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // ----------------------------------------





    // -----------------------------------------

}
