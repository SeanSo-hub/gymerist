@extends(backpack_view('blank'))

@section('content')
    <style>
        form {
            display: flex;
            flex-wrap: wrap;
            align-items: end;
            margin-bottom: 20px;
        }

        .form-group {
            margin-left: 5px;
            margin-right: 5px;
            flex-grow: 1;
        }

        .input-group {
            display: flex;
            margin-left: 5px;
            align-content: space-between;
            flex-grow: 1;
        }

        .group {
            flex-grow: 1;
        }

        .filter-btn {
            margin-left: 5px;
        }
    </style>

    <nav aria-label="breadcrumb" class="d-flex justify-content-end me-3 mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Admin</a></li>
            <li class="breadcrumb-item"><a href="">Reports</a></li>
            <li class="breadcrumb-item active"><a href="">Cash flow</a></li>
        </ol>
    </nav>

    <h1 class="text-capitalize ms-3" bp-section="page-heading">Cash flow</h1>

    <form class="container-fluid" action="{{ route('cashflow.filter') }}" method="GET">
        @csrf

        <div class="form-group">
            <label for="filter_by">Filter By</label>
            <select id="filter_by" name="filter_by" class="form-select">
                <option value="">-- Select Filter --</option>
                <option value="custom">Custom</option>
                <option value="day">This day</option>
                <option value="week">This week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
                <option value="cash">Cash</option>
                <option value="gcash">Gcash</option>
                <option value="total_plan">Total Plan Revenue</option>
            </select>
        </div>

        <div class="form-group" id="custom_filter" style="display: none;">
            <div class="input-group">
                <div class="group d-flex flex-column me-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control">
                </div>
                <div class="group d-flex flex-column">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control">
                </div>
            </div>
        </div>

        <div class="filter-btn">
            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear</button>
        </div>
    </form>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    @isset($total)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total</div>
                                    <div class="ms-auto lh-1">
                                        <span class="badge bg-success">Total</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 mb-0 me-2">₱ {{ $total }}</div>
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL::asset('assets/js/admin/filter.js') }}"></script>
@endsection
