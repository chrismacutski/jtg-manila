<section class="jtg-event-section pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center heading-section heading-section jtg-animate d-flex justify-content-between">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" href="{{ route('events.index') }}">UPCOMING EVENTS</a>
                    </li>
                </ul>
                {{--<p><a href="{{ route('events.index') }}" class="btn btn-primary btn-outline-primary p-3">MORE EVENTS</a></p>--}}
            </div>
        </div>
        <div class="row">
            @foreach($upcoming_events as $event)
                <div class="col-md-4 d-flex jtg-animate">
                    <div class="jtg-event-entry align-self-stretch">
                        <a href="{{ route('events.show', $event) }}" class="block-20" style="background-image: url('{{ '/' . $event->image_src }}'">
                        </a>
                        <div class="text p-4 d-block">
                            <h3 class="heading mb-1 text-center"><a href="{{ route('events.show', $upcoming_event) }}">{{ $event->name }}</a></h3>
                            <p class="time-loc text-center">
                            <h6 class="mr-2 font-weight-bold text-center">
                                @if ($event->starting_at->format('Y-m-d') == $event->ending_at->format('Y-m-d'))
                                    {{ $event->starting_at->format('M d') }} @ {{ $event->starting_at->format('g:iA') }} - {{ $event->starting_at->format('g:iA') }}
                                @else
                                    {{ $event->starting_at->format('M d') }} - {{ $event->ending_at->format('M d Y') }}
                                @endif
                                <br>
                                @if ($event->address)
                                    <span class="small">{{ $event->address }}</span>
                                @endif
                            </h6>
                            </p>
                            <p>{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-0">
            <div class="col text-center jtg-animate">
                <p><a href="{{ route('events.index') }}" class="btn btn-primary btn-outline-primary p-3">VIEW ALL EVENTS</a></p>
            </div>
        </div>
    </div>
</section>
