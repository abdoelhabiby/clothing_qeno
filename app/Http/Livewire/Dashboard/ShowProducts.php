<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Dashboard\ProductsExport;
use App\Http\Livewire\Dashboard\Traits\DataTableTrait;

class ShowProducts extends Component
{

    use WithPagination, DataTableTrait;

    protected $listeners = ['delete' => 'destroy'];

    protected $paginationTheme = 'bootstrap';
    protected $columns_can_order =  ['id', 'name', 'slug', 'sku', 'created_at', 'quantity', 'price', 'is_active'];
    public $exportExtensions = ['csv', 'xlsx', 'pdf'];
    public $currentPage;

    public $test = false;




    public function mount()
    {

        $this->rowsCollection = collect(); //set rows as collection to export data
    }


    // ----------------------------------------
    public function export($ext)
    {

        abort_if(!in_array($ext, $this->exportExtensions), Response::HTTP_NOT_FOUND);
        // $file_name=$this->fileNameExport ?? strtolower(class_basename(get_class($this))) . '.' . $ext;
        $file_name = 'products_page_'. $this->currentPage .'.' . $ext;
        return Excel::download(new ProductsExport($this->rowsCollection), $file_name);
    }


    // ----------------------------------------

    public function render()
    {


        $orderBy = $this->orderBy;
        $dir = $this->order_dir;
        $search = $this->search;

        $products = Product::when($orderBy, function ($query) use ($orderBy, $dir) {
            $query->orderBy($orderBy, $dir);
        })
            ->when($search, function ($query) use ($search) {
                $query
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('quantity', 'like', $search)
                    ->orWhere('id', $search)
                    ->orWhere('price', 'like', $search)
                    ->orWhereRaw("(CASE WHEN is_active = 1 THEN 'active' ELSE 'deactive' END) like '$search%'")
                    ->orWhereHas('vendor', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->with(['vendor:id,name'])
            // ->get();
            ->paginate($this->perPage);

        $this->currentPage = $products->currentPage();
        $this->rowsCollection = $products->getCollection();

        return view('livewire.dashboard.products', [
            'products' => $products
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



        abort_if(!admin()->hasPermissionTo('delete_products') > 0, Response::HTTP_FORBIDDEN);

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

        Product::destroy($this->rowsSelectedId);

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
