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
            <li class="breadcrumb-item active"><a href="">Daily Checkins</a></li>
        </ol>
    </nav>

    <h1 class="text-capitalize ms-3" bp-section="page-heading">Daily Checkins</h1>

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

        <div class="form-group" id="month_filter" style="display: none;"> 
            <label for="month">Month</label>
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

        <div class="form-group" id="year_filter" style="display: none;"> 
            <label for="year">Year</label>
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
                    @if (isset($checkins) && $checkins->count() > 0)
                        <table class="table table-striped">
                            <thead class="table-header">
                                <tr>
                                    <th scope="col">Fullname</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checkins as $checkin)
                                    <tr>
                                        <td>{{ $checkin->member->fullname }}</td>
                                        <td>{{ $checkin->date ? \Carbon\Carbon::parse($checkin->date)->format('F j, Y') : '' }}
                                        </td>
                                        <td>{{ $checkin->date ? \Carbon\Carbon::parse($checkin->date)->format('H:i') : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $checkins->links() }}
                    @else
                        <p>No checkins found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="{{ URL::asset('assets/js/admin/filter.js') }}"></script>

@endsection
