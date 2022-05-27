<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoomRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RoomCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RoomCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Room::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/room');
        CRUD::setEntityNameStrings('', '会場');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'label' => 'タイトル',
            'type' => 'text',
            'name' => 'title',
        ]);

        $this->crud->addColumn([
            'label' => '郵便番号',
            'type' => 'text',
            'name' => 'zipcode',
        ]);

        $this->crud->addColumn([
            'label' => '住所',
            'type' => 'text',
            'name' => 'address',
        ]);

        $this->crud->addColumn([
            'label' => 'アクセス',
            'type' => 'text',
            'name' => 'access',
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RoomRequest::class);

        $this->crud->addField([
            'name' => 'title',
            'type' => 'text',
            'label' => "タグ名"
        ]);

        $this->crud->addField([
            'name' => 'zipcode',
            'type' => 'text',
            'label' => "郵便番号"
        ]);

        $this->crud->addField([
            'name' => 'address',
            'type' => 'text',
            'label' => "住所"
        ]);

        $this->crud->addField([
            'name' => 'access',
            'type' => 'text',
            'label' => "アクセス"
        ]);

        $this->crud->addField([
            'name' => 'lat',
            'type' => 'text',
            'label' => "緯度"
        ]);

        $this->crud->addField([
            'name' => 'lang',
            'type' => 'text',
            'label' => "軽度"
        ]);

        $this->crud->addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => "コメント"
        ]);
        $this->crud->removeSaveActions(['save_and_edit', 'save_and_new', 'save_and_preview']);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn([
            'name' => 'title',
            'type' => 'text',
            'label' => "タグ名"
        ]);

        $this->crud->addColumn([
            'name' => 'zipcode',
            'type' => 'text',
            'label' => "郵便番号"
        ]);

        $this->crud->addColumn([
            'name' => 'address',
            'type' => 'text',
            'label' => "住所"
        ]);

        $this->crud->addColumn([
            'name' => 'access',
            'type' => 'text',
            'label' => "アクセス"
        ]);

        $this->crud->addColumn([
            'name' => 'lat',
            'type' => 'text',
            'label' => "緯度"
        ]);

        $this->crud->addColumn([
            'name' => 'lang',
            'type' => 'text',
            'label' => "軽度"
        ]);

        $this->crud->addColumn([
            'name' => 'comment',
            'type' => 'text',
            'label' => "コメント"
        ]);
    }
}
