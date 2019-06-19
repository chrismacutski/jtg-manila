<div class="hero-wrap js-fullheight">
    <home-banner-slider :images="{{
                    json_encode([
                        url('/images/1.jpg'),
                        url('/images/2.jpg'),
                        url('/images/3.jpg'),
                        url('/images/4.jpg'),
                    ])
                }}"></home-banner-slider>
</div>
{{--<div class="hero-wrap js-fullheight" style="background-image: url({{ $banner_img }});" data-stellar-background-ratio="0.5">--}}
    {{--<div class="overlay"></div>--}}
    {{--<div class="container">--}}
        {{--<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">--}}
            {{--<div class="col-md-10 text-center jtg-animate" data-scrollax=" properties: { translateY: '70%' }">--}}
                {{--<h1 class="mb-0">JTG MANILA CHURCH</h1>--}}
                {{--<h3 class="subheading mb-4 pb-1">Where Christ is REAL and Disciples are MADE</h3>--}}
                {{--<p>--}}
                    {{--<a href="{{ route('series.index') }}" class="btn btn-transparent py-3 px-4"><span>Latest Series</span></a>--}}
                    {{--<a href="{{ route('frontend.about.vision') }}" class="btn btn-transparent py-3 px-4"><span>About</span></a>--}}
                {{--</p>--}}
                {{--<div class="mouse">--}}
                    {{--<a href="#" class="mouse-icon">--}}
                        {{--<div class="mouse-wheel"><span class="ion-ios-arrow-down"></span></div>--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}