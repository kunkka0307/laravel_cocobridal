<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PageCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Page::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/page');
        CRUD::setEntityNameStrings('', '固定ページ');
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
            'name' => 'title',
            'type' => 'text',
            'label' => "タイトル"
        ]);

        $this->crud->addColumn([
            'name' => 'content',
            'type' => 'textarea',
            'label' => "内容",
            'limit' => 100
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PageRequest::class);

        $this->crud->addField([
            'name' => 'title',
            'type' => 'text',
            'label' => "タイトル"
        ]);

        $this->crud->addField([
            'name' => 'slug',
            'type' => 'text',
            'label' => "Slug",
            'prefix' => config('app.url') . "/page/"
        ]);

        $this->crud->addField([
            'name' => 'description',
            'type' => 'text',
            'label' => "ディスクリプション"
        ]);

        $this->crud->addField([
            'name' => 'content',
            'type' => 'wysiwyg',
            'label' => "内容"
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

        $this->crud->addField([
            'name' => 'id',
            'type' => 'hidden'
        ]);
    }
}
