<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request->query()['filter'] ?? '';
        $date = $request->query()['date'] ?? '';

        // Фильтер по статусу
        if ($filter) {
            $tickets = DB::table('tickets')->get()->where('status', $filter);
        } else {
            $tickets = DB::table('tickets')->get();
        }

        // Сортировка по времени
        if ($date) {
            // Приводим к массиву для сортировки
            $tickets = $tickets->toArray();
            uasort( $tickets, function ($a, $b) use ($date) {
                // Приводим к таймстемпу
                $aTime = Carbon::createFromTimeString($a->created_at)->timestamp;
                $bTime = Carbon::createFromTimeString($b->created_at)->timestamp;
                if ($aTime == $bTime) {
                    return 0;
                }

                // Условие фильтра сортировки по времени
                if ($date == 'asc') {
                    return ($aTime < $bTime) ? -1 : 1;
                } else if ($date == 'desc') {
                    return ($aTime < $bTime) ? 1 : -1;
                }
            });
        }

        return view('ticket.index', ['tickets' => $tickets]);
    }

    public function create()
    {
        return view('ticket.create');
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('message');

        $ticket = DB::table('tickets')->insertGetId([
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return view('ticket.store', ['ticket' => $ticket]);
    }

    public function show(string $id)
    {
        $ticket = DB::table('tickets')->find($id);
        return view('ticket.show', ['ticket' => $ticket]);
    }

    public function update(Request $request, string $id)
    {
        //
    }
}
