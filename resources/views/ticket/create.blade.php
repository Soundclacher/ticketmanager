<form method="POST" action="{{route('tickets.store')}}">
    @csrf
    <input name="name" type="text" required>
    <input name="email" type="text" required>
    <input name="message" type="text" required>
    <input type="submit" value="Отправить">
</form>
