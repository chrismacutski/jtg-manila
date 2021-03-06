<nav class="navbar navbar-dark jtg_navbar bg-dark jtg-navbar-light scrolled awake" id="jtg-navbar">
    <div class="container d-flex align-items-stretch">
        <div class="col-3 d-flex align-items-center">
            <a class="navbar-brand" href="/">
                <img src="/images/jtg-banner.png" width="50px" height="50px" style="margin-top: 10px; margin-right: 5px"/>JTG Manila<span style="font-size: 24px; margin-top: -23px; padding-left: 53px;">Church</span>
            </a>
        </div>
        <div class="col-9 d-flex align-items-center text-right">
            <ul class="jtg-social mt-2 mr-3">
                {{--<li class="jtg-animate"><a href="#"><span class="icon-twitter"></span></a></li>--}}
                {{--<li class="jtg-animate"><a href="https://www.facebook.com/jesusthegospelmanilachurch/" target="_blank"><span class="icon-facebook"></span></a></li>--}}
            </ul>

            <button class="navbar-toggler d-flex align-items-center" type="button" data-toggle="collapse" data-target="#jtg-nav" aria-controls="jtg-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="pt-1 mr-1">Menu</span> <span class="oi oi-menu"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="jtg-nav">
            <ul class="navbar-nav ml-auto">
                @if(url()->current() == url('/'))
                    <li class="nav-item active"><a href="/" class="nav-link">HOME</a></li>
                @else
                    <li class="nav-item"><a href="/" class="nav-link">HOME</a></li>
                @endif
                @if(url()->current() == url()->route('frontend.about.history'))
                    <li class="nav-item active"><a href="{{ route('frontend.about.history') }}" class="nav-link">ABOUT</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('frontend.about.history') }}" class="nav-link">ABOUT</a></li>
                @endif
                {{--<li class="nav-item"><a href="#" class="nav-link">Ministries</a></li>--}}
                @if(url()->current() == url()->route('series.index'))
                    <li class="nav-item active"><a href="{{ route('series.index') }}" class="nav-link">SERIES</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('series.index') }}" class="nav-link">SERIES</a></li>
                @endif
                @if(url()->current() == url()->route('events.index'))
                    <li class="nav-item active"><a href="{{ route('events.index') }}" class="nav-link">EVENTS</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('events.index') }}" class="nav-link">EVENTS</a></li>
                @endif

                @if(url()->current() == url()->route('frontend.give'))
                    <li class="nav-item active"><a href="{{ route('frontend.give') }}" class="nav-link">GIVING</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('frontend.give') }}" class="nav-link">GIVING</a></li>
                @endif

                @if(url()->current() == url()->route('frontend.contact'))
                    <li class="nav-item active"><a href="{{ route('frontend.contact') }}" class="nav-link">CONNECT WITH US</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('frontend.contact') }}" class="nav-link">CONNECT WITH US</a></li>
                @endif
                @guest
                    @if(url()->current() == url()->route('login'))
                        <li class="nav-item active"><a href="{{ route('login') }}" class="nav-link">LOGIN</a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">LOGIN</a></li>
                    @endif
                @else
                    @if(url()->current() == url()->route('backend.index'))
                        <li class="nav-item active"><a href="{{ route('backend.index') }}" class="nav-link">ACCOUNT</a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('backend.index') }}" class="nav-link">ACCOUNT</a></li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>
