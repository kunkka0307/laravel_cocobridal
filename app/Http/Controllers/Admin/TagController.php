<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class TagController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup() 
    {
        $this->crud->setModel("App\Models\Tag");
        $this->crud->setRoute("admin/tag");
        $this->crud->setEntityNameStrings('', 'タグ');
    }

    public function setupListOperation()
    {
        $this->crud->addColumn([
            'label' => 'ID',
            'type' => 'text',
            'name' => 'id',
        ]);
        $this->crud->addColumn([
            'label' => 'タグ名',
            'type' => 'text',
            'name' => 'title',
        ]);
    }

    public function setupCreateOperation()
    {
        $this->crud->setValidation(\App\Http\Requests\TagCrudRequest::class);

        $this->crud->addField([
            'name' => 'title',
            'type' => 'text',
            'label' => "タグ名"
        ]);
        $this->crud->removeSaveActions(['save_and_edit', 'save_and_new', 'save_and_preview']);
    }

    public function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn([
            'label' => 'タグ名',
            'type' => 'text',
            'name' => 'title',
        ]);
    }
}
