@auth('backpack')
    @php
        $user = auth()->guard('backpack')->user();
        if ($user && strpos($user->capabilities, '') !== false) {
            $capabilities = explode(',', $user->capabilities);
        }
    @endphp

    @isset($capabilities)
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
                {{ trans('backpack::base.dashboard') }}</a></li>

        @if (in_array('1', $capabilities))
            <x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
        @endif

        @if (in_array('2', $capabilities))
            <x-backpack::menu-item title="Members" icon="la la-user-friends" :link="backpack_url('member')" />
        @endif

        @if (in_array('3', $capabilities))
            <x-backpack::menu-item title="Payments" icon="la la-coins" :link="backpack_url('payment')" />
        @endif

        <li class="nav-item dropdown {{ request()->is('reports/*') ? 'active' : '' }}">
            <a id="navbarDropdownDashboard" class="nav-link dropdown-toggle" href="#" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="la la-chart-bar"></i> Reports
            </a>
            
            <div class="dropdown-menu" aria-labelledby="navbarDropdownDashboard">

                @if (in_array('4', $capabilities))
                    <a class="dropdown-item" href="{{ route('checkins.index') }}"> <i class="la la-user-check"></i> Daily
                        Checkins</a>
                @endif

                @if (in_array('4', $capabilities))
                    <a class="dropdown-item" href="{{ route('members.index') }}"> <i class="la la-user-friends"></i> Members</a>
                @endif

                @if (in_array('4', $capabilities))
                    <a class="dropdown-item" href="{{ route('payments.index') }}"> <i class="la la-coins"></i> Payments</a>
                @endif

                @if (in_array('4', $capabilities))
                    <a class="dropdown-item" href="{{ route('cashflow.index') }}"> <i class="la la-money-bill-wave"></i> Cash
                        Flow</a>
                @endif

            </div>
        </li>
    @endisset
@endauth
