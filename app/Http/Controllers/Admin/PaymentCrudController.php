<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Http\Requests\PaymentRequest;
use Backpack\CRUD\app\Library\Widget;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PaymentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PaymentCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Member::class);
        CRUD::setModel(\App\Models\Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payment');
        CRUD::setEntityNameStrings('payment', 'payments');
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
            'label' => "Name",
            'entity' => 'member',
            'attribute' => 'fullname'
        ]);

        CRUD::setFromDb();

        $this->crud->removeColumn('member_id');
        $this->crud->removeColumn('date');
        $this->crud->removeColumn('plan_start_date');
        $this->crud->removeColumn('payment_type');
        $this->crud->removeColumn('transaction_code');
        // $this->crud->removeColumn('amount');

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
        CRUD::addField([
            'name' => 'member_id',
            'type' => 'select',
            'label' => 'Fullname',
            'entity' => 'member',
            'attribute' => 'fullname',

            'options'   => (function ($query) {
                return $query->where('subscription_status', 'active')->get();
            }),
        ]);

        CRUD::field('amount')
            ->type('number')
            ->label('Amount');

        CRUD::addfield([
            'name'        => 'payment_type',
            'label'       => "Payment type",
            'type'        => 'enum',
            'options'     => [
                'cash' => 'Cash',
                'gcash' => 'GCash'
            ],
            'allows_null' => false,
            'default'     => 'cash',

        ]);

        CRUD::field([  
            'name'        => 'plan_type',
            'label'       => "Plan type",
            'type'        => 'enum',
            'options'     => [
                'session' => 'Session',
                'monthly' => 'Monthly', 
                'quarterly' => 'Quarterly',
                'half-year' => 'Half year',
                'annual' => 'Annual',],
            'allows_null' => false,
            'default'     => 'Session',
        ]);

        Widget::add()->type('script')->content(asset('assets/js/admin/transaction.js'));



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

    // public function checkPaymentStatus() {
    //     $paymentType = Payment::where('payment_type');

    //     if ($paymentType === 'session') {

    //     }
    // }
}
