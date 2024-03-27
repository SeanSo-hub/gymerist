<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Capabilities
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('backpack')->user();

        if ($user && $this->hasCapability($user, $request)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }

    protected function hasCapability($user, $request)
    {
        $capabilities = explode(',', $user->capabilities);
        $routeName = $request->route()->getName();

        if ($request->route()->getName() === 'dashboard') {
            return true;
        }

        switch ($routeName) {
            case 'user.index':
            case 'user.create':
            case 'user.store':
            case 'user.show':
            case 'user.edit':
            case 'user.update':
            case 'user.destroy':
            case 'user.search':
                return in_array('1', $capabilities); // Add New User
            case 'member.index':
            case 'member.create':
            case 'member.store':
            case 'member.show':
            case 'member.edit':
            case 'member.update':
            case 'member.destroy':
            case 'member.search':
            case 'member.subscribe':
            case 'member.subscribe-add':
                return in_array('2', $capabilities); // View Payment
            case 'payment.index':
            case 'payment.create':
            case 'payment.store':
            case 'payment.show':
            case 'payment.edit':
            case 'payment.update':
            case 'payment.destroy':
            case 'payment.search':
                return in_array('3', $capabilities); // Accept Payments
            case 'checkins.index':
            case 'checkins.filter':
                return in_array('4', $capabilities); // View Reports
            case 'members.index':
            case 'members.filter':
                return in_array('5', $capabilities); // View Report Members
            case 'payments.index':
            case 'payments.filter':
                return in_array('6', $capabilities); // View Members
            case 'cashflow.index':
            case 'cashflow.filter':
                return in_array('7', $capabilities); // View Report Payments
            default:
                return false; // Default Route
        }
    }
}
