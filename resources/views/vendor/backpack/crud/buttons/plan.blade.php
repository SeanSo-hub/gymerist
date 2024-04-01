@if ($crud->hasAccess('plan'))
    <a href="{{ url($crud->route . '/' . $entry->getKey() . '/plan') }}" class="btn btn-sm btn-link"><i
            class="la la-plus"></i> Plan</a>
@endif
