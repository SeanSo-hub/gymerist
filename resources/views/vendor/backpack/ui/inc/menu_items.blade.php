{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Members" icon="la la-user-friends" :link="backpack_url('member')" />
<x-backpack::menu-item title="Payments" icon="la la-coins" :link="backpack_url('payment')" />
<x-backpack::menu-item title="Memberships" icon="la la-users-cog" :link="backpack_url('membership')" />
<x-backpack::menu-item title="Checkins" icon="la la-users-cog" :link="backpack_url('checkin')" />
<li class="nav-item dropdown {{ request()->is('reports/*') ? 'active' : '' }}">
    <a id="navbarDropdownDashboard" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="la la-chart-bar"></i> Reports
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownDashboard">
        <a class="dropdown-item" href="{{ route('checkin')}}"> <i class="la la-user-check"></i> Daily Checkins</a>
        <a class="dropdown-item" href="#"> <i class="la la-user-friends"></i> Members</a>
        <a class="dropdown-item" href="#"> <i class="la la-coins"></i> Payments</a>
    </div>
</li>