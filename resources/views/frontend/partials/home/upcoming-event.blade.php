<section class="jtg-intro py-2" style="background-color: #e40d42">
    <div class="overlay"></div>
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-md-6 jtg-animate">
                {{--<h2 class="subheading">Upcoming Event</h2>--}}
                <h2><a href="{{ route('events.show', $upcoming_event) }}">{{ $upcoming_event->name }}</a></h2>
                <h4 class="text-white">{{ $upcoming_event->starting_at->format('M d, Y') }}</h4>

            </div>
            <div class="col-md-6 pl-md-5 jtg-animate">
                <timer :date="{{ json_encode($upcoming_event->starting_at->timestamp) }}"
                       :event="{{ json_encode($upcoming_event) }}"></timer>
            </div>
        </div>
    </div>
</section>
