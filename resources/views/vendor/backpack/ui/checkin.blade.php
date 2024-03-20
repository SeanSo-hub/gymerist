@extends(backpack_view('blank'))

@section('content')

  <style>

    .table-header tr:nth-child(even) {
      background-color: #E9EDF2;
    }

  </style>

<form action="" method="GET">
  @csrf
  <div class="form-group">
    <label for="from_date">Date From</label>
    <input type="date" id="from_date" name="from_date" class="form-control">
  </div>
  <div class="form-group">
    <label for="to_date">Date To</label>
    <input type="date" id="to_date" name="to_date" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary">Filter</button>
</form>
  
  <div>
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
            @foreach($checkins as $checkin)
              <tr>
                <td>{{ $checkin->fullname }}</td>
                <td>{{ $checkin->date ? \Carbon\Carbon::parse($checkin->date)->format('F j, Y') : '' }}</td>
                <td>{{ $checkin->date ? \Carbon\Carbon::parse($checkin->date)->format('H:i') : '' }}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
      <div></div>
      {{ $checkins->links()}}  
      @else
      <p>No checkins found.</p>
    @endif
  </div>

@endsection