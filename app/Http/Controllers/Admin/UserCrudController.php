<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Profile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('', '会員');
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
            'label' => 'ID',
            'type' => 'text',
            'name' => 'user_id',
        ]);

        $this->crud->addColumn([
            'label' => '会員名',
            'type' => 'text',
            'name' => 'user.user_name',
        ]);

        $this->crud->addColumn([
            'label' => '性別',
            'type' => 'text',
            'name' => 'gender_label',
        ]);

        $this->crud->addColumn([
            'label' => '生年月日',
            'type' => 'text',
            'name' => 'birthday_label',
        ]);

        $this->crud->addColumn([
            'label' => '携帯電話番号',
            'type' => 'text',
            'name' => 'phone',
        ]);

        $this->crud->orderBy('created_at', 'desc');

        // $this->crud->addClause('where', 'role_id', '=', \App\Enums\UserRole::USER);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::addField(['name' => 'email', 'type' => 'email', 'label' => 'メールアドレス']); 
        CRUD::addField(['name' => 'password', 'type' => 'text', 'label' => 'パスワード']); 
        CRUD::addField(['name' => 'firstname', 'type' => 'text', 'label' => '姓']); 
        CRUD::addField(['name' => 'lastname', 'type' => 'text', 'label' => '名']);  
        CRUD::addField(['name' => 'furi_firstname', 'type' => 'text', 'label' => 'せい']); 
        CRUD::addField(['name' => 'furi_lastname', 'type' => 'text', 'label' => 'めい']); 
        CRUD::addField(['name' => 'gender', 'type' => 'select_from_array', 'label' => '性別', 'options' => config('values.genders'), 'default' => 'male', 'allows_null' => false]); 
        CRUD::addField(['name' => 'birthday', 'type' => 'date', 'label' => '生年月日']); 
        CRUD::addField(['name' => 'phone', 'type' => 'text', 'label' => '携帯電話番号']);
        CRUD::addField(['name' => 'pref', 'type' => 'text', 'label' => '都道府県']);
        CRUD::addField(['name' => 'comment', 'type' => 'textarea', 'label' => '自己紹介', 'rows' => 5]);
        CRUD::addField(['name' => 'job', 'type' => 'select_from_array', 'label' => '職業', 'options' => config('values.jobs')]); 
        CRUD::addField(['name' => 'height', 'type' => 'text', 'label' => '身長', 'suffix' => 'cm']);
        CRUD::addField(['name' => 'income', 'type' => 'select_from_array', 'label' => '年収', 'options' => config('values.incomes')]); 
        CRUD::addField(['name' => 'holiday', 'type' => 'select_from_array', 'label' => '休日', 'options' => config('values.holidays')]); 
        CRUD::addField(['name' => 'hobby', 'type' => 'select_from_array', 'label' => '趣味', 'options' => config('values.hobbys')]); 
        CRUD::addField(['name' => 'dwelling', 'type' => 'select_from_array', 'label' => '現在の住居', 'options' => config('values.dwellings')]); 
        CRUD::addField(['name' => 'drink', 'type' => 'select_from_array', 'label' => 'お酒', 'options' => config('values.drinks')]); 
        CRUD::addField(['name' => 'smoking', 'type' => 'select_from_array', 'label' => '喫煙', 'options' => config('values.smokings')]); 
        CRUD::addField(['name' => 'cooking', 'type' => 'select_from_array', 'label' => '料理', 'options' => config('values.cookings')]); 
        CRUD::addField(['name' => 'best_cooking', 'type' => 'text', 'label' => '得意料理']);
        CRUD::addField(['name' => 'birthplace', 'type' => 'select_from_array', 'label' => '出身地', 'options' => config('values.birthplaces')]); 
        CRUD::addField(['name' => 'bloodtype', 'type' => 'select_from_array', 'label' => '血液型', 'options' => config('values.bloodtypes')]); 
        CRUD::addField(['name' => 'family', 'type' => 'select_from_array', 'label' => '続柄', 'options' => config('values.familys')]); 
        CRUD::addField(['name' => 'marriage_history', 'type' => 'select_from_array', 'label' => '婚姻歴', 'options' => config('values.marriage_historys')]); 

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */

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

        CRUD::addField(['name' => 'user_id', 'type' => 'hidden']); 
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn([
            'label' => 'ID',
            'type' => 'text',
            'name' => 'user_id',
        ]);

        $this->crud->addColumn([
            'label' => '姓',
            'type' => 'text',
            'name' => 'firstname',
        ]);

        $this->crud->addColumn([
            'label' => '名',
            'type' => 'text',
            'name' => 'lastname',
        ]);

        $this->crud->addColumn([
            'label' => 'せい',
            'type' => 'text',
            'name' => 'furi_firstname',
        ]);

        $this->crud->addColumn([
            'label' => 'めい',
            'type' => 'text',
            'name' => 'furi_lastname',
        ]);

        $this->crud->addColumn([
            'label' => '性別',
            'type' => 'text',
            'name' => 'gender_label',
        ]);

        $this->crud->addColumn([
            'label' => '生年月日',
            'type' => 'text',
            'name' => 'birthday_label',
        ]);

        $this->crud->addColumn([
            'label' => '携帯電話番号',
            'type' => 'text',
            'name' => 'phone',
        ]);

        $this->crud->addColumn([
            'label' => '都道府県',
            'type' => 'text',
            'name' => 'pref',
        ]);

        $this->crud->addColumn([
            'label' => '自己紹介',
            'name' => 'comment',
            'escape' => true
        ]);

        $this->crud->addColumn([
            'label' => '職業',
            'type' => 'text',
            'name' => 'job_label',
        ]);

        $this->crud->addColumn([
            'label' => '身長',
            'type' => 'text',
            'name' => 'height',
        ]);

        $this->crud->addColumn([
            'label' => '年収',
            'type' => 'text',
            'name' => 'income_label',
        ]);

        $this->crud->addColumn([
            'label' => '休日',
            'type' => 'text',
            'name' => 'holiday_label',
        ]);

        $this->crud->addColumn([
            'label' => '趣味',
            'type' => 'text',
            'name' => 'hobby_label',
        ]);

        $this->crud->addColumn([
            'label' => '現在の住居',
            'type' => 'text',
            'name' => 'dwelling_label',
        ]);

        $this->crud->addColumn([
            'label' => 'お酒',
            'type' => 'text',
            'name' => 'drink_label',
        ]);

        $this->crud->addColumn([
            'label' => '喫煙',
            'type' => 'text',
            'name' => 'smoking_label',
        ]);

        $this->crud->addColumn([
            'label' => '料理',
            'type' => 'text',
            'name' => 'cooking_label',
        ]);

        $this->crud->addColumn([
            'label' => '得意料理',
            'type' => 'text',
            'name' => 'best_cooking',
        ]);

        $this->crud->addColumn([
            'label' => '出身地',
            'type' => 'text',
            'name' => 'birthplace_label',
        ]);

        $this->crud->addColumn([
            'label' => '血液型',
            'type' => 'text',
            'name' => 'bloodtype_label',
        ]);

        $this->crud->addColumn([
            'label' => '続柄',
            'type' => 'text',
            'name' => 'family_label',
        ]);

        $this->crud->addColumn([
            'label' => '婚姻歴',
            'type' => 'text',
            'name' => 'marriage_history_label',
        ]);
    }

    public function update()
    {
        $request = $this->crud->validateRequest();

        $password = $request->get('password');
        if (isset($password)) {
            $user = \App\Models\User::find($request->get('user_id'));
            if (isset($user)) {
                $user->update([
                    'password'          => bcrypt($password)
                ]);

                $params = $request->except(['_token']);
                $params['password'] = null;

                $user->profile->update($params);

                \Alert::success(trans('backpack::crud.update_success'))->flash();

                return redirect(route('admin.user.edit', $user->profile));
            }
        }

        return $this->traitUpdate();
    }
}
