<nav class="navbar navbar-dark jtg_navbar bg-dark jtg-navbar-light" id="jtg-navbar">
    <div class="container d-flex align-items-stretch">
        <div class="col-3 d-flex align-items-center">
            <a class="navbar-brand" href="/">
                JTG Manila <span>Church</span>
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
                    <li class="nav-item active"><a href="/" class="nav-link">Home</a></li>
                @else
                    <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
                @endif
                @if(url()->current() == url()->route('frontend.about.vision'))
                    <li class="nav-item active"><a href="{{ route('frontend.about.vision') }}" class="nav-link">About</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('frontend.about.vision') }}" class="nav-link">About</a></li>
                @endif
                {{--<li class="nav-item"><a href="#" class="nav-link">Ministries</a></li>--}}
                @if(url()->current() == url()->route('series.index'))
                    <li class="nav-item active"><a href="{{ route('series.index') }}" class="nav-link">Series</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('series.index') }}" class="nav-link">Series</a></li>
                @endif
                @if(url()->current() == url()->route('events.index'))
                    <li class="nav-item active"><a href="{{ route('events.index') }}" class="nav-link">Events</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('events.index') }}" class="nav-link">Events</a></li>
                @endif
                @if(url()->current() == url()->route('frontend.contact'))
                    <li class="nav-item active"><a href="{{ route('frontend.contact') }}" class="nav-link">Connect with us</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('frontend.contact') }}" class="nav-link">Connect with us</a></li>
                @endif
                @guest
                    @if(url()->current() == url()->route('register'))
                        <li class="nav-item active"><a href="{{ route('register') }}" class="nav-link">Be part of JTG Manila Church</a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Be part of JTG Manila Church</a></li>
                    @endif

                    @if(url()->current() == url()->route('login'))
                        <li class="nav-item active"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    @endif
                @else
                    @if(url()->current() == url()->route('backend.index'))
                        <li class="nav-item active"><a href="{{ route('backend.index') }}" class="nav-link">Account</a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('backend.index') }}" class="nav-link">Account</a></li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>
