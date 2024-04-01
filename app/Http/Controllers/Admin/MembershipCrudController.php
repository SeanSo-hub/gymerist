<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MembershipRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MembershipCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MembershipCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Membership::class);
        CRUD::setModel(\App\Models\Member::class);
        CRUD::setModel(\App\Models\Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/membership');
        CRUD::setEntityNameStrings('membership', 'memberships');
        
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */


    protected function setupListOperation()
    {   
        CRUD::addcolumn([
            'name' => 'fullname', 
            'label' => "Fullname", 
            'attribute' => 'fullname',
            'entity' => 'member'
        ]);

        CRUD::addcolumn([
            'name' => 'subscription_status', 
            'label' => "Subscription Status", 
            'attribute' => 'subscription_status',
            'entity' => 'member'
        ]);

        CRUD::addcolumn([
            'name' => 'plan_status', 
            'label' => "Plan Status", 
        ]);

        CRUD::setFromDb(); 

        $this->crud->removeColumn('plan_start_date');    
        $this->crud->removeColumn('firstname');
        $this->crud->removeColumn('lastname');
        $this->crud->removeColumn('code');
        $this->crud->removeColumn('contact_number');
        $this->crud->removeColumn('email');
        $this->crud->removeColumn('amount');
        $this->crud->removeColumn('member_id'); 
        $this->crud->removeColumn('payment_type'); 
        $this->crud->removeColumn('transaction_code');


        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
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
        CRUD::setValidation(MembershipRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
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

}
