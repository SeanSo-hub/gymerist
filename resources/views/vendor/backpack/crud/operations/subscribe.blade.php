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
            <small>Add subscription{!! $entry->name !!}.</small>
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
    <div class="row">
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
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" value="{{ $entry->amount ?? old('amount') }}" id="amount" class="form-control @error('amount') is-invalid @enderror">
                            @error('amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status">Subscription status</label>
                            <select name="subscription_status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="{{ $entry->amount ?? old('amount') }}">-</option>
                                @foreach ($statuses as $statusValue => $statusText)
                                    <option value="{{ $statusValue }}" {{ ('subscription_status') == $statusValue ? 'selected' : '' }}>
                                        {{ $statusText }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="subscription_date" id="start_date" value="" class="form-control @error('start_date') is-invalid @enderror" onchange="calculateEndDate()">
                            @error('start_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">End Date</label>
                            <input type="date" name="subscription_end_date" id="end_date" value="" class="form-control">
                        </div>

                        <script>
                            function calculateEndDate() {
                                const startDate = new Date(document.getElementById('start_date').value);
                                startDate.setFullYear(startDate.getFullYear() + 1); // Add one year
                                const endDate = startDate.toISOString().split('T')[0];
                                document.getElementById('end_date').value = endDate;
                            }
                        </script>
                                                
                        <div class="form-group col-sm-12">
                            <label>Message (Optional)</label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div id="saveActions" class="form-group" style="margin-top: 14px">
                    <button type="submit" class="btn btn-primary">Add Subscription</button>
                    <a href="{{ url($crud->route) }}" class="btn btn-default"><span class="la la-ban"></span> &nbsp;Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
