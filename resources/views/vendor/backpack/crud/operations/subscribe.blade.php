@extends(backpack_view('blank'))

@php
$defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    'Subscription' => false,
];
// if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
$breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

$statuses = [
    'active' => 'Active',
    'expired' => 'Expired',
]; // Modify this array as needed for your statuses
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Members</span>
            <small>Add subscription{!! $member->name !!}.</small>
            @if ($crud->hasAccess('list'))
                <small>
                    <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                        <i
                            class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span>
                    </a>
                </small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 bold-labels">
            @if ($errors->any())
                <div class="alert alert-danger pb-0">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li><i class="la la-info-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action=""> @csrf
                <div class="card">
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="">Name</label>
                            <h1>{{$member->fullname}}</h1>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Code</label>
                            <h1>{{$member->code}}</h1>
                        </div>
                    
                        @if($member->subscription_status === 'active')
                            <div class="form-group col-md-6">
                                <label for="">Subscription Status</label>
                                <h1>{{$member->subscription_status}}</h1>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Subscription expires on</label>
                                <h1>{{ $member->subscription_end_date ? \Carbon\Carbon::parse($member->subscription_end_date)->format('F d, Y') : '-' }}</h1>
                            </div>
                        @else
                            <div class="form-group col-md-6">
                                <label for="dropdown">Payment type</label>
                                <select name="payment_type" class="form-control" id="paymentType" onclick="toggleTransactionCode()">
                                    <option value="">--Select payment type--</option>
                                    <option value="cash">Cash</option>
                                    <option value="gcash">Gcash</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror">
                                @error('amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12" id="transactionCodeField" style="display: none;">
                                <label for="transactionCode">Transaction Code</label>
                                <input type="text" name="transaction_code" id="transactionCode" class="form-control @error('transactionCode') is-invalid @enderror">
                                @error('transactionCode')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif    
                    </div>
                    
                    <script>
                        function toggleTransactionCode() {
                            var paymentType = document.getElementById('paymentType').value;
                            var transactionCodeField = document.getElementById('transactionCodeField');
                            if (paymentType === 'cash') {
                                transactionCodeField.style.display = 'none';
                            } else {
                                transactionCodeField.style.display = 'block';
                            }
                        }
                    </script>
                    
                </div>
                <div id="saveActions" class="form-group d-flex justify-content-end" style="margin-top: 14px" >
                    @if($member->subscription_status === 'active')
                    <a href="{{ url($crud->route) }}" class="btn btn-primary"><span class="la la-arrow-left"></span> &nbsp;back</a>
                    @else
                    <a href="{{ url($crud->route) }}" class="btn btn-default"><span class="la la-ban"></span> &nbsp;Cancel</a>
                    <button type="submit" class="btn btn-primary">Add Subscription</button>
                    @endif
                </div>
            </form>
        </div>

        <div class="form-group col-md-12" id="transactionCodeField" style="display: none;">
            <label for="transactionCode">Payment History</label>
            <input type="text" name="transaction_code" id="transactionCode" class="form-control @error('transactionCode') is-invalid @enderror">
            @error('transactionCode')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endsection
