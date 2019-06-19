<div class="hero-wrap js-fullheight" style="background-image: url({{ $sermon_img }});" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="overlay"></div>
            <div class="col-md-10 text-center jtg-animate" data-scrollax=" properties: { translateY: '70%' }">
                @if ($sermon)
                    <h1 class="mb-0">{{ $sermon->name }}</h1>
                @endif
                {{--<h3 class="subheading pb-1">Christ is the Vision Making Disciples is our Mission</h3>--}}

                <p>
                    {{--<a href="{{ route('sermons.show') }}" class="btn btn-history p-0">--}}
                    {{--<i class="fa fa-play-circle-o fa-4x"></i>--}}
                    {{--</a>--}}
                </p>
            </div>
        </div>
    </div>
</div>