<style>
    .filter {
        background-color: gray;
        color: white;
        text-decoration: none;
        padding: 10px;
        transition: all .2s
    }
    .filter:visited {
        text-decoration: none;
        color: white;
    }
    .filter:hover {
        opacity: .6;
        transition: all .2s
    }

</style>

<a class="filter" href="/tickets?filter=" class="all">All</a>
<a class="filter" href="/tickets?filter=Active" class="active">Active</a>
<a class="filter" href="/tickets?filter=Resolved" class="resolved">Resolved</a>
<a class="filter" href="/tickets?date=asc" class="asc">Date ASC</a>
<a class="filter" href="/tickets?date=desc" class="desc">Date DESC</a>

<div class="tickets">
    @foreach($tickets as $ticket)
        <a href="{{ route('tickets.show', ['id' => $ticket->id])  }}}">
            <p>{{ $ticket->name }}</p>
            <p>{{ $ticket->email }}</p>
            <p>{{ $ticket->status }}</p>
            <p>{{ $ticket->message }}</p>
        </a>
        <hr>
    @endforeach
</div>


{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', win => {--}}
{{--        const container = document.querySelector('.tickets');--}}
{{--        const tickets = document.querySelectorAll()--}}
{{--    })--}}
{{--</script>--}}
