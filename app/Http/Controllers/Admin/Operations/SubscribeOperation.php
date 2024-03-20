<?php

namespace App\Http\Controllers\Admin\Operations;

use Exception;
use App\Models\Member;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait SubscribeOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupSubscribeRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/subscribe', [
            'as'        => $routeName.'.subscribe',
            'uses'      => $controller.'@subscribe',
            'operation' => 'subscribe',
        ]);

        Route::post($segment.'/{id}/subscribe', [
            'as'        => $routeName.'.subscribe-add',
            'uses'      => $controller.'@postsubscribeForm',
            'operation' => 'subscribe',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupSubscribeDefaults()
    {
        CRUD::allowAccess('subscribe');

        CRUD::operation('subscribe', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'subscribe', 'view', 'crud::buttons.subscribe');
            // CRUD::addButton('line', 'subscribe', 'view', 'crud::buttons.subscribe');

            $this->crud->addButton('line', 'subscribe', 'view', 'crud::buttons.subscribe');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function subscribe()
    {
        CRUD::hasAccessOrFail('subscribe');

        $entry = $this->crud->getCurrentEntry();

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? 'subscribe ' . $this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();
        // load the view
        return view("crud::operations.subscribe", $this->data);
        
    }

    public function postsubscribeForm(Request $request)
    {
        // Run validation
        $validator = Validator::make($request->all(), [
            'amount' => 'required', // Allow amount to be optional
            'subscription_status' => 'required',
            'message' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $entry = $this->crud->getCurrentEntry();

        try {
    
            $entry->update([
                'amount' => $request->get('amount'),
                'subscription_status' => $request->get('subscription_status'),
                'subscription_date' => $request->get('subscription_date'),
                'subscription_end_date' => $request->get('subscription_end_date'), // Assuming you want to store this as well
                'message' => $request->get('message'),
            ]);
        
            Alert::success('Subscription added')->flash();

            return redirect(url($this->crud->route));
        } catch (Exception $e) {
            // Show error message
            Alert::error("Error, " . $e->getMessage())->flash();

            return redirect()->back()->withInput();
        }
    }


}