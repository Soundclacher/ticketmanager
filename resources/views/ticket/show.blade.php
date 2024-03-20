@if($ticket)

    <p>{{$ticket->message}}</p>

    <form method="POST" action="{{ route('tickets.update', ['id' => $ticket->id, 'email' => $ticket->email]) }}">
        @method('PUT')
        @csrf

        <input type="text" id="comment" name="comment" placeholder="Введите коммент" required>
        <input type="submit" value="Готово">
    </form>


    <form method="POST" action="{{route('tickets.send', ['id' => $ticket->id, 'email' => $ticket->email])}}">
        @csrf
        <input name="answer" placeholder="Введите текст сообщения">

        </input>
        <input type="submit" value="Задать вопрос пользователю">
    </form>
@else
    <p>Ticket Not Found</p>
@endif


