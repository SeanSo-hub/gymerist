<?php

namespace App\Http\Controllers\Admin\Operations;

use Exception;
use App\Models\Member;
use App\Models\Payment;
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

        $member = Member::find(request()->route('id'));
        $payment = $member->payments()->latest()->first();

        $data = [
            'crud' => $this->crud,
            'title' => CRUD::getTitle() ?? 'Subscribe ' . $this->crud->entity_name,
            'member' => $member,
            'payment' => $payment, 
        ];
        
        // load the view
        return view("crud::operations.subscribe", $data);
    }

    public function postsubscribeForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_type' => 'required|in:cash,gcash',
            'amount' => 'required|numeric',
            'transaction_code' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $entry = $this->crud->getCurrentEntry();

        try {

            $entry->storeSubscriptionInfo($request->get('payment_type'), $request->get('amount'), $request->get('transaction_code'));

            Alert::success('Subscription added')->flash();

            return redirect(url($this->crud->route));
        } catch (Exception $e) {
            Alert::error("Error, " . $e->getMessage())->flash();

            return redirect()->back()->withInput();
        }
    }
}