<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Carbon;
use App\Http\Requests\CheckinRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CheckinCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CheckinCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Checkin::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/checkin');
        CRUD::setEntityNameStrings('checkin', 'checkins');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // set columns from db columns.
        CRUD::column([
            'name' => 'fullname', // The db column name
            'label' => "Fullname", // Table column heading
            'type' => 'Text',
            'attribute' => 'fullname'
        ]);
        CRUD::column([
            'name' => 'date',
            'label' => "Date",  // Update label to reflect both
            'type' => 'date', // Use 'text' for custom display

        ]);
        CRUD::column([
            'name' => 'time', 
            'label' => "Time", 
            'type' => 'text',
            'value' => function ($entity) {
                // Get the date value from the entity
                $date = $entity->date;

                // Check if date is not empty before converting to Carbon
                if (!empty($date)) {
                    $carbon = new Carbon($date);
                    // Format the time with AM/PM indicator
                    return $carbon->format('h:i:s A'); // 'A' represents AM/PM
                } else {
                    // Handle empty date case (optional)
                    return ''; // or any default value for empty date
                }
            },
        ]);


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
        CRUD::setValidation(CheckinRequest::class);
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
