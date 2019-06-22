<div class="hero-wrap" style="background-image: url({{ $sermon_img }})" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-lg-6">
                <section class="jtg-vision">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center bg-transparent">
                                <ul class="nav justify-content-center p-2">
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold text-white series-header" href="{{ route('sermons.index') }}"><i class="icon-chevron-left"></i> {{ $sermon->name }}</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-12">
                                <div class="embed-responsive embed-responsive-16by9">
                                    @if ($video_src)
                                        <video-player :video-url="{{ json_encode($video_src) }}"></video-player>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
