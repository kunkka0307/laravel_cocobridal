<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Enums\BookStatus;

/**
 * Class BookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BookCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Book::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/book');
        CRUD::setEntityNameStrings('', '予約');
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
            'label' => '予約ID',
            'type' => 'text',
            'name' => 'id',
        ]);

        $this->crud->addColumn([
            'name' => 'user.user_name',
            'type' => 'text',
            'label' => "ユーザー"
        ]);

        $this->crud->addColumn([
            'name' => 'party.title',
            'type' => 'text',
            'label' => "パーティー"
        ]);

        $this->crud->addColumn([
            'name' => 'amount',
            'type' => 'number',
            'label' => "金額",
            'suffix' => '円'
        ]);

        $this->crud->addColumn([
            'name' => 'status',
            'type' => 'select_from_array',
            'label' => "ステータス",
            'options' => BookStatus::getAllValues()
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(BookRequest::class);

        $this->crud->addField([
            'label' => '予約ID',
            'type' => 'text',
            'name' => 'book_id',
            'attributes' => [
                'readonly'  => 'readonly',
                'disabled' => 'disabled'
            ]
        ]);

        $this->crud->addField([
            'label' => 'ユーザー',
            'type' => 'text',
            'name' => 'user.user_name',
            'attributes' => [
                'readonly'  => 'readonly',
                'disabled' => 'disabled'
            ]
        ]);

        $this->crud->addField([
            'label' => 'パーティー',
            'type' => 'text',
            'name' => 'party.title',
            'attributes' => [
                'readonly'  => 'readonly',
                'disabled' => 'disabled'
            ]
        ]);

        $this->crud->addField([
            'label' => '金額',
            'type' => 'number',
            'name' => 'amount',
            'suffix' => '円',
            'attributes' => [
                'readonly'  => 'readonly',
                'disabled' => 'disabled'
            ]
        ]);

        $this->crud->addField([
            'label' => 'ステータス',
            'type' => 'select_from_array',
            'name' => 'status',
            'options' => BookStatus::getAllValues(),
            'allows_null' => false
        ]);

        $this->crud->removeSaveActions(['save_and_edit', 'save_and_new', 'save_and_preview']);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn([
            'label' => 'ID',
            'type' => 'text',
            'name' => 'id',
        ]);

        $this->crud->addColumn([
            'name' => 'user.user_name',
            'type' => 'text',
            'label' => "ユーザー"
        ]);

        $this->crud->addColumn([
            'name' => 'party.brief',
            'type' => 'text',
            'label' => "パーティー"
        ]);

        $this->crud->addColumn([
            'name' => 'amount',
            'type' => 'number',
            'label' => "金額",
            'suffix' => '円'
        ]);

        $this->crud->addColumn([
            'name' => 'status',
            'type' => 'select_from_array',
            'label' => "ステータス",
            'options' => BookStatus::getAllValues()
        ]);
    }

    public function update()
    {
        $request = $this->crud->validateRequest();

        $status = intval($request->status);
        $book = \App\Models\Book::find($request->id);
        if ($status == BookStatus::CANCEL) {
            if ($book->status != $status) {
                $paymentService = new \App\Services\PaymentService();
                $paymentService->refundPayment($book);
            }
        }

        return $this->traitUpdate();
    }
}
