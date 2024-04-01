<?php

namespace App\Http\Controllers\Admin;

use App\Models\Capability;
use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Library\Widget;
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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); 

        CRUD::addColumn([
            'name' => 'capabilities',
            'label' => 'Capabilities',
            'type' => 'text',
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
        CRUD::setValidation(UserRequest::class);
        CRUD::setFromDb(); 

        CRUD::addField([
            'name' => 'capabilities',
            'label' => 'Capabilities',
            'type' => 'hidden',
        ]);

        $labels = [
            'View Users and Members',   
            'Add Payments',   
            'View Payments',     
            'Reports - Checkins',        
            'Reports - Members',        
            'Reports - Payments',          
            'Reports - Cash Flow',         
        ];

        for ($i = 0; $i < count($labels); $i++) {
            CRUD::addField([
                'name' => 'capabilities'.$i,
                'label' => $labels[$i],
                'type' => 'checkbox',
                'attributes' => [
                    'class' => 'capability-checkbox',
                    'value' => $i + 1
                ]
            ]);

        }

        Widget::add()->type('script')->content(asset('assets/js/admin/checkbox.js'));

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

    public function setupShowOperation()
    {
        $userCount = \App\Models\User::count();

        Widget::add()->to('after_content')->type('div')->class('row')->content([

            Widget::make()
                ->type('progress')
                ->class('card border-0 text-white bg-primary')
                ->progressClass('progress-bar')
                ->value($userCount)
                ->description('Registered users.')
                ->progress(100 * (int)$userCount / 1000)
                ->hint(1000 - $userCount . ' more until next milestone.'),

            Widget::make(
                [
                    'type'       => 'card',
                    'class'   => 'card bg-dark text-white',
                    'wrapper' => ['class' => 'col-sm-3 col-md-3'],
                    'content'    => [
                        'header' => 'Example Widget',
                        'body'   => 'Widget placed at "before_content" secion in same row',
                    ]
                ]
            ),
        ]);

        Widget::add()->type('script')->stack('after_scripts')->content('https://code.jquery.com/ui/1.12.0/jquery-ui.min.js');
        Widget::add()->type('style')->stack('after_styles')->content('https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.58/dist/themes/light.css');
    }
}
