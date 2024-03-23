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
            flex-grow: 1;
        }

        .filter-btn {
            margin-left: 5px;
        }
    </style>

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="d-flex justify-content-end me-3 mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Admin</a></li>
            <li class="breadcrumb-item"><a href="">Reports</a></li>
            <li class="breadcrumb-item active"><a href="">Members</a></li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="text-capitalize ms-3" bp-section="page-heading">Members</h1>

    <form class="container-fluid" action="{{ route('checkins.filter') }}" method="GET">
        @csrf
        <div class="form-group">
            <label for="filter_by">Filter By</label>
            <select id="filter_by" name="filter_by" class="form-control">
                <option value="">-- Select Filter --</option>
                <option value="custom">Custom</option>
                <option value="month">Month</option>
                <option value="year">Year</option>
            </select>
        </div>
        <div class="form-group" id="custom_filter" style="display: none;">
            <div class="input-group">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control">
            </div>  
            <div class="input-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control">
            </div> 
        </div>
        <div class="form-group" id="month_filter" style="display: none;"> <label for="month">Month</label>
            <select id="month" name="month" class="form-control">
                <option value="">-- Select Month --</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>

        <div class="form-group" id="year_filter" style="display: none;"> <label for="year">Year</label>
            <input type="number" min="2000" id="year" name="year" class="form-control">
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
                    @if (isset($members) && $members->count() > 0)
                        <table class="table table-striped">
                            <thead class="table-header">
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Fullname</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Annual Status</th>
                                    <th scope="col">Annual end Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>{{ $member->code }}</td>
                                        <td>{{ $member->fullname }}</td>
                                        <td>{{ $member->contact_number }}</td>
                                        <td>{{ $member->subscription_status }}</td>
                                        <td>{{ $member->subscription_end_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $members->links() }}
                    @else
                        <p>No checkins found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="{{ URL::asset('assets/js/admin/filter.js') }}"></script>

@endsection
