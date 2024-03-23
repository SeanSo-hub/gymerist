@extends(backpack_view('blank'))

@php

    $userCount = \App\Models\User::count();
    $memberCount = \App\Models\Member::count();
    $activeCount = \App\Models\Payment::count();


    $totalRevenue = App\Models\Member::getTotalRevenue();
    $totalSubscription = App\Models\Member::getTotalSubscription();
    $totalCash = App\Models\Payment::getTotalAmountForCash();
    $totalGCash = App\Models\Payment::getTotalAmountForGCash();


    //add div row using 'div' widget and make other widgets inside it to be in a row
    Widget::add()
        ->to('before_content')
        ->type('div')
        ->class('row justify-content-center')
        ->content([
            //widget made using fluent syntax
            Widget::make()
                ->type('progress')
                ->class('card mb-3')
                ->statusBorder('start') // start|top|bottom
                ->accentColor('success') // primary|secondary|warning|danger|info
                ->ribbon(['top', 'la-user']) // ['top|right|bottom']
                ->progressClass('progress-bar')
                ->value($userCount)
                ->description('Admin users.'),

            Widget::make()
                ->type('progress')
                ->class('card mb-3')
                ->statusBorder('start') // start|top|bottom
                ->accentColor('danger') // primary|secondary|warning|danger|info
                ->ribbon(['top', 'la-user-friends']) // ['top|right|bottom']
                ->progressClass('progress-bar')
                ->value($memberCount)
                ->description('Registered members.'),

            Widget::make()
                ->type('progress')
                ->class('card mb-3')
                ->statusBorder('start') // start|top|bottom
                ->accentColor('info') // primary|secondary|warning|danger|info
                ->ribbon(['top', 'la-check']) // ['top|right|bottom']
                ->progressClass('progress-bar')
                ->value($activeCount)
                ->description('Active users.'),

            Widget::make()
                ->type('progress')
                ->class('card mb-3')
                ->statusBorder('start') // start|top|bottom
                ->accentColor('warning') // primary|secondary|warning|danger|info
                ->ribbon(['top', 'la-coins']) // ['top|right|bottom']
                ->progressClass('progress-bar')
                ->value($totalCash)
                ->description('Total Revenue on Cash Payments.'),

            Widget::make()
                ->type('progress')
                ->class('card mb-3')
                ->statusBorder('start') // start|top|bottom
                ->accentColor('warning') // primary|secondary|warning|danger|info
                ->ribbon(['top', 'la-coins']) // ['top|right|bottom']
                ->progressClass('progress-bar')
                ->value($totalGCash)
                ->description('Total Revenue on Gcash Payments.'),

            Widget::make()
                ->type('progress')
                ->class('card mb-3')
                ->statusBorder('start') // start|top|bottom
                ->accentColor('warning') // primary|secondary|warning|danger|info
                ->ribbon(['top', 'la-coins']) // ['top|right|bottom']
                ->progressClass('progress-bar')
                ->value($totalSubscription)
                ->description('Total Revenue on Subscription'),

            Widget::make()
                ->type('progress')
                ->class('card mb-3')
                ->statusBorder('start') // start|top|bottom
                ->accentColor('warning') // primary|secondary|warning|danger|info
                ->ribbon(['top', 'la-coins']) // ['top|right|bottom']
                ->progressClass('progress-bar')
                ->value($totalRevenue)
                ->description('Total Revenue'),
        ]);

    //you can also add Script & CSS to your page using 'script' & 'style' widget
    Widget::add()
        ->type('script')
        ->stack('after_scripts')
        ->content('https://code.jquery.com/ui/1.12.0/jquery-ui.min.js');
    Widget::add()
        ->type('style')
        ->stack('after_styles')
        ->content('https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.58/dist/themes/light.css');

@endphp

@section('content')
    @php

    @endphp
@endsection
