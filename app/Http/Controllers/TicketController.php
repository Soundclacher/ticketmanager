<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\Mailer;
class TicketController extends Controller
{
    // Получение всех тикетов
    // Заприваченный
    // Может получать квери filter для фильтрации тикетов
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

    // Публичный, для отрисовки формы создания заявки
    public function create()
    {
        return view('ticket.create');
    }

    // Публичный, для получения данных с формы создания
    // И создания заявки
    // Все параметры получает с формы в реквест
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

    // Приватный
    // По полученному в params id ищет нужный тикет
    public function show(string $id)
    {
        $ticket = DB::table('tickets')->find($id);
        return view('ticket.show', ['ticket' => $ticket]);
    }

    // Приватный
    // По полученному в params id ищет тикет
    // Добавляет полученный из формы коммент
    // И меняет статус на Resolved
    // Отрисовывает страницу с успехом
    public function update(Request $request, string $id, string $email)
    {
        $comment = $request->input('comment');
        $ticket = DB::table('tickets')->where('id', $id)->update(['status' => 'Resolved', 'comment' => $comment]);

        $mailer = new Mailer();

        $mailer->send(
            $email,
            'admin@admin.ru',
            "Оповещение по заявке №$id",
            "Ваша заявка была обработана: $comment"
        );

        return view('ticket.update', ['success' => $ticket, 'ticket' => $id, 'comment' => $comment]);
    }
    // Приватный
    // Отправляет пользователю, оставившему заявку, сообщение
    public function send(Request $request, $id, $email)
    {
        $text = $request->input('answer');

        $mailer = new Mailer();

        $mailer->send(
            $email,
            'admin@admin.ru',
            "Вопрос по заявке №$id",
            $text
        );

        return view('ticket.answer', ['text' => $text]);
    }
}
