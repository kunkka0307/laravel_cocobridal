<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PartyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PartyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PartyCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Party::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/party');
        CRUD::setEntityNameStrings('', 'パーティー');
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
            'name' => 'eyecatch',
            'type' => 'image',
            'label' => "アイキャッチ画像",
            'width' => '80px',
            'height' => '80px'
        ]);

        $this->crud->addColumn([
            'name' => 'room.title',
            'type' => 'text',
            'label' => "会場"
        ]);

        $this->crud->addColumn([
            'name' => 'open_date',
            'type' => 'date',
            'label' => "開始日",
            'format' => 'YYYY-MM-DD'
        ]);

        $this->crud->addColumn([
            'name' => 'open_time',
            'type' => 'datetime',
            'label' => "開始時間",
            'format' => 'HH:mm'
        ]);

        $this->crud->addColumn([
            'name' => 'close_time',
            'type' => 'datetime',
            'label' => "終了時間",
            'format' => 'HH:mm'
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
        CRUD::setValidation(PartyRequest::class);

        $this->crud->addField([
            'name' => 'title',
            'type' => 'text',
            'label' => "タイトル"
        ]);

        $this->crud->addField([
            'name' => 'eyecatch',
            'type' => 'image',
            'label' => "アイキャッチ画像",
            'crop' => true,
            'aspect_ratio' => 1.78,
        ]);

        $this->crud->addField([
            'name' => 'male_limit',
            'type' => 'number',
            'label' => "男性座席数",
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([
            'name' => 'female_limit',
            'type' => 'number',
            'label' => "女性座席数",
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([
            'name' => 'male_price',
            'type' => 'number',
            'label' => "男性料金",
            'suffix' => '円',
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([
            'name' => 'female_price',
            'type' => 'number',
            'label' => "男性料金",
            'suffix' => '円',
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([
            'name' => 'room_id',
            'type' => 'select',
            'label' => "会場",
            'entity' => 'room',
            'model' => '\App\Models\Room',
            'attribute' => 'title'
        ]);

        $this->crud->addField([
            'name' => 'content',
            'type' => 'wysiwyg',
            'label' => "詳細",
        ]);

        $this->crud->addField([
            'name' => 'open_date',
            'type' => 'date',
            'label' => "開始日",
            'wrapper' => ['class' => 'form-group col-md-4'],
        ]);

        $this->crud->addField([
            'name' => 'open_time',
            'type' => 'time',
            'label' => "開始時間",
            'wrapper' => ['class' => 'form-group col-md-4'],
        ]);

        $this->crud->addField([
            'name' => 'close_time',
            'type' => 'time',
            'label' => "終了時間",
            'wrapper' => ['class' => 'form-group col-md-4'],
        ]);

        $this->crud->addField([
            'name' => 'male_high_age',
            'type' => 'number',
            'label' => "男性年齢上限",
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([
            'name' => 'male_low_age',
            'type' => 'number',
            'label' => "男性年齢下限",
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([
            'name' => 'female_high_age',
            'type' => 'number',
            'label' => "女性年齢上限",
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([
            'name' => 'female_low_age',
            'type' => 'number',
            'label' => "女性年齢下限",
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([
            'name' => 'value_sense',
            'type' => 'number',
            'label' => "価値観",
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([
            'label'     => "タグ",
            'type'      => 'select2_multiple',
            'name'      => 'tags', // the method that defines the relationship in your Model

            // optional
            'entity'    => 'tags', // the method that defines the relationship in your Model
            'model'     => "App\Models\Tag", // foreign key model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?

            // also optional
            'options'   => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
        ]);

        $this->crud->addField([
            'name'      => 'flows',
            'label'     => '流れ',
            'type'      => 'repeatable',
            'fields'    => [
                [
                    'name'    => 'title',
                    'type'    => 'text',
                    'label'   => 'タイトル',
                ],
                [
                    'name'    => 'start_time',
                    'type'    => 'time',
                    'label'   => '開始時間',
                    'wrapper' => ['class' => 'form-group col-md-4'],
                ],
                [
                    'name'    => 'comment',
                    'type'    => 'textarea',
                    'label'   => 'コメント',
                ],
            ],
            'new_item_label'    => '追加',
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
            'label' => "タイトル"
        ]);

        $this->crud->addColumn([
            'name' => 'eyecatch',
            'type' => 'image',
            'label' => "アイキャッチ画像",
            'width' => '200px',
            'height' => '200px'
        ]);

        $this->crud->addColumn([
            'name' => 'male_limit',
            'type' => 'number',
            'label' => "男性座席数"
        ]);

        $this->crud->addColumn([
            'name' => 'female_limit',
            'type' => 'number',
            'label' => "女性座席数"
        ]);

        $this->crud->addColumn([
            'name' => 'male_price',
            'type' => 'number',
            'label' => "男性料金",
            'suffix' => '円'
        ]);

        $this->crud->addColumn([
            'name' => 'female_price',
            'type' => 'number',
            'label' => "女性料金",
            'suffix' => '円'
        ]);

        $this->crud->addColumn([
            'name' => 'room.title',
            'type' => 'text',
            'label' => "会場"
        ]);

        $this->crud->addColumn([
            'name' => 'content',
            'label' => "詳細",
            'escaped' => true,
            'limit' => 1000
        ]);

        $this->crud->addColumn([
            'name' => 'open_date',
            'type' => 'date',
            'label' => "開始日",
            'format' => 'YYYY-MM-DD'
        ]);

        $this->crud->addColumn([
            'name' => 'open_time',
            'type' => 'datetime',
            'label' => "開始時間",
            'format' => 'HH:mm'
        ]);

        $this->crud->addColumn([
            'name' => 'close_time',
            'type' => 'datetime',
            'label' => "終了時間",
            'format' => 'HH:mm'
        ]);

        $this->crud->addColumn([
            'name' => 'male_high_age',
            'type' => 'number',
            'label' => "男性年齢上限"
        ]);

        $this->crud->addColumn([
            'name' => 'male_low_age',
            'type' => 'number',
            'label' => "男性年齢下限"
        ]);

        $this->crud->addColumn([
            'name' => 'female_high_age',
            'type' => 'number',
            'label' => "女性年齢上限"
        ]);

        $this->crud->addColumn([
            'name' => 'female_low_age',
            'type' => 'number',
            'label' => "女性年齢下限"
        ]);

        $this->crud->addColumn([
            'name' => 'value_sense',
            'type' => 'number',
            'label' => "価値観"
        ]);

        $this->crud->addColumn([
            'label'     => 'タグ', // Table column heading
            'type'      => 'select_multiple',
            'name'      => 'tags', // the method that defines the relationship in your Model
            'entity'    => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model'     => 'App\Models\Tag', // foreign key model
        ]);

        $this->crud->addColumn([
            'name'  => 'flows', 
            'label' => '流れ', 
            'type'  => 'table', 
            'columns' => [
                'title'        => 'タイトル',
                'start_time' => '開始時間',
                'comment'       => 'コメント',
            ],
            'wrapper'       => ['class' => 'white-space']
        ]);
    }
}
