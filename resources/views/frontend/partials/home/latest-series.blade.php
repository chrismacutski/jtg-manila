{{--<section class="jtg-section2" style="background-image: url('images/bg_series.jpg');">--}}
    {{--<div class="container">--}}
        {{--<div class="row justify-content-center mb-3 pb-3">--}}
            {{--<div class="col-md-12 text-center heading-section heading-section-light jtg-animate">--}}
                {{--<ul class="nav">--}}
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link active font-weight-bold text-white" href="{{ route('series.index') }}">SERIES ARCHIVE</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link font-weight-bold text-white" href="{{ route('sermons.index') }}">RECENT MESSAGE</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row d-flex sermon-wrap3">--}}
            {{--<div class="col-md-6 d-flex align-items-stretch jtg-animate">--}}
                {{--<div class="img" style="background-image: url(images/bg_primary.jpg);"></div>--}}
            {{--</div>--}}
            {{--<div class="overlay"></div>--}}

            {{--<div class="col-md-6 py-4 text jtg-animate">--}}
                {{--<h2 class="mb-4"><a href="{{ route('sermons.show') }}">Heart Beat</a></h2>--}}
                {{--<div class="meta">--}}
                    {{--<p>--}}
                        {{--<span>Speaker: <a href="#" class="ptr">Blenn Ramos</a></span>--}}
                        {{--<span><a href="#">On Sunday 13 Jan, 2019</a></span>--}}
                    {{--</p>--}}
                {{--</div>--}}
                {{--<p class="text-white" style="white-space: pre-line">You were created to know God relationally. This is more than head knowledge. The incarnation and the cross show us the infinite lengths God is willing to go to have a close, intimate relationship with us. He doesn’t just love us. John 3:16 says “God so loved” us. Following Jesus means knowing and being known by a God who is wild about us.--}}

                    {{--We consider it a great privilege to help kids and students know God as well. Church on the Move has always dedicated generous resources and passionate leadership to introduce kids and students the real Jesus.</p>--}}
                {{--<p class="mt-4 btn-customize">--}}
                    {{--<a href="{{ route('sermons.show') }}" type="button" class="btn btn-transparent px-4 py-2 mr-md-2">--}}
                        {{--<span class="icon-play"></span> WATCH MESSAGE--}}
                    {{--</a>--}}
                    {{--<a href="{{ route('sermons.show') }}" type="button" class="btn btn-transparent px-4 py-2 mr-md-2">--}}
                        {{--<span class="icon-download"></span> DOWNLOAD MESSAGE--}}
                    {{--</a>--}}
                {{--</p>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</section>--}}

<section class="jtg-series-section bg-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center heading-section heading-section jtg-animate d-flex justify-content-between">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" href="{{ route('sermons.index') }}">LATEST MESSAGES</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            @foreach($sermons as $value)
                <div class="col-md-4 jtg-animate">
                    <div class="jtg-series">
                        <a href="{{ route('sermons.show', $value) }}" class="img popup-vimeo mb-3 d-flex justify-content-center align-items-center" style="background-image: url('{{ '/' . $value->image_src }}');">
                            <div class="icon d-flex justify-content-center align-items-center">
                                <span class="icon-play"></span>
                            </div>
                        </a>
                        <div class="text">
                            <h3><a href="#">{{ $value->name }}</a></h3>
                            <span class="position">Speaker: {{ $value->speaker->fullname }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>