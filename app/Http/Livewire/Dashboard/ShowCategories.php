<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Dashboard\CategoriesExport;
use App\Http\Livewire\Dashboard\Traits\DataTableTrait;

class ShowCategories extends Component
{

    use WithPagination,DataTableTrait;

    protected $listeners = ['delete' => 'destroy'];

    protected $paginationTheme = 'bootstrap';
    protected $columns_can_order =  ['id','name','slug','created_at'];
    public $exportExtensions = ['csv', 'xlsx', 'pdf'];




    public function mount()
    {

        $this->rowsCollection = collect(); //set rows as collection to export data
    }


    // ----------------------------------------
    public function export($ext)
    {

        abort_if(!in_array($ext, $this->exportExtensions), Response::HTTP_NOT_FOUND);
        // $file_name=$this->fileNameExport ?? strtolower(class_basename(get_class($this))) . '.' . $ext;
        $file_name='categories.' . $ext;
        return Excel::download(new CategoriesExport($this->rowsCollection), $file_name);
    }


    // ----------------------------------------

    public function render()
    {


        $orderBy = $this->orderBy;
        $dir = $this->order_dir;
        $search = $this->search;

        $categories = Category::when($orderBy, function ($query) use ($orderBy, $dir) {
            $query->orderBy($orderBy, $dir);
        })
            ->when($search, function ($query) use ($search) {
                $query
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('id', $search)
                    ->orWhere(function($query) use ($search){
                         $query->whereDate('created_at', 'like', '%' . $search . '%');
                    })
                ->orWhereRaw("(CASE WHEN is_active = 1 THEN 'active' ELSE 'deactive' END) like '$search%'");

            })
            // ->get();
            ->paginate($this->perPage);



        $this->rowsCollection = $categories->getCollection();

        return view('livewire.dashboard.categories', [
            'categories' => $categories
        ]);
    }

    // ----------------------------------------



    // ----------------------------------------------

    public function confirmDelete()
    {
        $this->dispatchBrowserEvent(
            'alert_confirm',
            [
                'title' => 'warning',
                'type' => 'warning',
                'message' => 'are you shore!'
            ]
        );


    }

    // ----------------------------------------------
    public function destroy()
    {



        abort_if(!admin()->hasPermissionTo('delete_users') > 0, Response::HTTP_FORBIDDEN);

        abort_if(!count($this->rowsSelectedId) > 0, Response::HTTP_NOT_FOUND);

        if (count($this->rowsSelectedId) > 10) {

            $this->dispatchBrowserEvent(
                'alert',
                [
                    'title' => 'faild',
                    'type' => 'warning',
                    'message' => 'can delete in once 10 records '
                ]
            );

            return;
        }

        Category::destroy($this->rowsSelectedId);

        $this->dispatchBrowserEvent(
            'alert',
            [
                'title' => 'deleted',
                'type' => 'success',
                'message' => 'deleted Successfully!'
            ]
        );

        $this->reset(['rowsSelectedId', 'selectAll']);
    }
    // ----------------------------------------------
}
