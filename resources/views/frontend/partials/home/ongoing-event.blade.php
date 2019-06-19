<section class="jtg-intro2 py-2" style="background-image: url('{{ $on_going_event->image_src }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-md-6 jtg-animate">
                <h2 class="subheading">Ongoing Event</h2>
                <h2><a href="{{ route('events.show', $on_going_event) }}">{{ $on_going_event->name }}</a></h2>
                <h4 class="text-white">{{ $on_going_event->starting_at->format('M d, Y') }}</h4>

            </div>
        </div>
    </div>
</section>
