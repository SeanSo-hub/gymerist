 @if ($crud->hasAccess('subscribe'))
     <a href="{{ url($crud->route . '/' . $entry->getKey() . '/subscribe') }}" class="btn btn-sm btn-link">
         <i class="la la-plus"></i> Subscription</a>
 @endif
