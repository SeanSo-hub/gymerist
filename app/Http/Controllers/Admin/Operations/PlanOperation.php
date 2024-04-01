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

trait PlanOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupPlanRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/plan', [
            'as'        => $routeName.'.plan',
            'uses'      => $controller.'@plan',
            'operation' => 'plan',
        ]);
        
        Route::post($segment.'/{id}/plan', [
            'as'        => $routeName.'.plan-add',
            'uses'      => $controller.'@postPlanForm',
            'operation' => 'plan',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupPlanDefaults()
    {
        CRUD::allowAccess('plan');

        CRUD::operation('plan', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'plan', 'view', 'crud::buttons.plan');
            CRUD::addButton('line', 'plan', 'view', 'crud::buttons.plan');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function plan()
    {
        CRUD::hasAccessOrFail('plan');

        $member = Member::find(request()->route('id'));
        $payment = $member->payments()->latest()->first();

        // prepare the fields you need to show
        $data = [
            'crud' => $this->crud,
            'title' => CRUD::getTitle() ?? 'Plan ' . $this->crud->entity_name,
            'member' => $member,
            'payment' => $payment,
        ];

        // load the view
        return view('crud::operations.plan', $data);
    }

    public function postPlanForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_type' => 'required|in:session,monthly,quarterly,half-year,annual',
            'payment_type' => 'required|in:cash,gcash',
            'amount' => 'required|numeric',
            'transaction_code' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $memberId = $request->route('id');

        $member = Member::find($memberId);

        if (!$member) {
            return redirect()->back()->withInput()->withErrors(['member_id' => 'Member not found']);
        }

        $existingSessionPayment = $member->payments()->where('plan_type', 'session')->first();

        if ($existingSessionPayment) {
            return redirect()->back()->withInput()->withErrors(['payment_type' => 'A session payment currently exists for this member.']);
        }

        try {
            $payment = new Payment();
            $payment->plan_type = $request->get('plan_type');
            $payment->payment_type = $request->get('payment_type');
            $payment->amount = $request->get('amount');
            $payment->transaction_code = $request->get('transaction_code');
            $payment->member()->associate($member);
            $payment->save();

            Alert::success('Plan added')->flash();

            return redirect(url($this->crud->route));
        } catch (Exception $e) {
            Alert::error("Error, " . $e->getMessage())->flash();
            return redirect()->back()->withInput();
        }
    }


}