<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Calendar;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $event_list = [];
        $event_list[] = Calendar::event(
            "Valentine's Day", //event title
            false, //full day event?
            '2019-12-14', //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
            '2019-12-14', //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg), yyyy-mm-dd
            1, //optional event ID
            [
                'url' => 'http://fullcalendar.io',
                //any other full-calendar supported parameters
            ]
        );

        $calendar = Calendar::addEvents($event_list)->setOptions([
            'firstDay'      => 1,
            'editable'      => false,
            'themeSystem'   =>'bootstrap4',
            'locale'        => 'es',

            'customButtons' => [
                'myCustomButton' => [
                  'text' => 'custom!',
                ]
            ],
            'buttonText'=> array(
                'today'=> 'Hoy',
                'month'=> 'Mes',
                'week' => 'Semana',
                'day' => 'Día'
            ),


            'defaultView' => 'month',
            'header' => array(
                'left' => 'prev,next today myCustomButton', 
                'center' => 'title', 
                'right' => 'month,agendaWeek,agendaDay'
                )
            ]);
        return view('home',compact('calendar'));
    }
}
