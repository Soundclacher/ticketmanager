@if(!!$ticket)
    <p>Ваша заявка №{{$ticket}} успешно создана</p>

    <a href="{{route('tickets.create')}}">Создать ещё одну заявку</a>
@else

    <p>При создании заявки произошла ошибка!</p>

@endif