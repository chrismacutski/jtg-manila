<div class="hero-wrap js-fullheight" style="background-image: url('{{ '/' . $banner_img }}');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-10 text-center jtg-animate" data-scrollax=" properties: { translateY: '70%' }">
                @if ($event)
                    <h1 class="mb-0">{{ $event->name }}</h1>
                    <h3 class="subheading mb-4 pb-1">{{ $event->description }}</h3>
                @endif

                <div class="mouse">
                    <a href="#" class="mouse-icon">
                        <div class="mouse-wheel"><span class="ion-ios-arrow-down"></span></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>