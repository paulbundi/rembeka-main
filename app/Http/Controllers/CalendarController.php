<?php

namespace App\Http\Controllers;

class CalendarController extends Controller
{
    /**
     * show stylist calendar
     *
     * @return void
     */
    public function __invoke()
    {
        return view('dashboard.page', ['page' => 'calendar-index']);
    }
}
