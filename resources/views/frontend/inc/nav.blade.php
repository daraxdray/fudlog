<style>
    .header_color {
        background-image: linear-gradient(var(--primary), #b02304);
    }
    .menu_text{
        white-space: nowrap;
        overflow: hidden !important;
        text-overflow: ellipsis;
    }
    div::-webkit-scrollbar {
        height: 5px;
    }
    div::-webkit-scrollbar-track {
        border-radius: 2px;
    }
</style>
<!-- Top Bar -->
<div class="top-navbar bg-white border-bottom border-soft-secondary z-1035">
    @if(!isMobile())
    <div style="cursor: pointer; background-image: url({{uploaded_asset(get_setting('banner_header'))}}); width:100%; height:80px;" onclick="window.location.href='{{get_setting('banner_text')}}'">
        {{--<img src="{{''}}" style="width:100%; height:80px; background-repeat: repeat;" alt="top_banner">--}}
    </div>
    @endif
    <div class="container">
        <div class="row border-bottom">
            <div class="col-lg-7 col d-sm-block d-none">
                <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                    @if(get_setting('show_language_switcher') == 'on')
                        <li class="list-inline-item dropdown mr-3" id="lang-change">
                            @php
                                if(Session::has('locale')){
                                    $locale = Session::get('locale', Config::get('app.locale'));
                                }
                                else{
                                    $locale = 'en';
                                }
                            @endphp
                            <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown" data-display="static">
                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}" class="mr-2 lazyload" alt="{{ \App\Language::where('code', $locale)->first()->name }}" height="11">
                                <span class="opacity-60">{{ \App\Language::where('code', $locale)->first()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left">
                                @foreach (\App\Language::all() as $key => $language)
                                    <li>
                                        <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language) active @endif">
                                            <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-1 lazyload" alt="{{ $language->name }}" height="11">
                                            <span class="language">{{ $language->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    @if(get_setting('show_currency_switcher') == 'on')
                        <li class="list-inline-item dropdown" id="currency-change">
                            @php
                                if(Session::has('currency_code')){
                                    $currency_code = Session::get('currency_code');
                                }
                                else{
                                    $currency_code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
                                }
                            @endphp
                            <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-60" data-toggle="dropdown" data-display="static">
                                {{ \App\Currency::where('code', $currency_code)->first()->name }} {{ (\App\Currency::where('code', $currency_code)->first()->symbol) }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                @foreach (\App\Currency::where('status', 1)->get() as $key => $currency)
                                    <li>
                                        <a class="dropdown-item @if($currency_code == $currency->code) active @endif" href="javascript:void(0)" data-currency="{{ $currency->code }}">{{ $currency->name }} ({{ $currency->symbol }})</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="col-5 text-right d-none d-lg-block">
                <ul class="list-inline mb-0">
                    @auth
                    @if(isAdmin())
                        <li class="list-inline-item mr-3">
                            <a href="{{ route('admin.dashboard') }}" class="text-reset py-2 d-inline-block opacity-60">{{ translate('Dashboard')}}</a>
                        </li>
                    @else
                        <li class="list-inline-item mr-3">
                            <a href="{{ route('dashboard') }}" class="text-reset py-2 d-inline-block opacity-60">{{ translate('My Dashboard')}}</a>
                        </li>
                    @endif
                    <li class="list-inline-item">
                        <a href="{{ route('logout') }}" class="text-reset py-2 d-inline-block opacity-60">{{ translate('Logout')}}</a>
                    </li>
                    @else
                        <li class="list-inline-item mr-3">
                            <a href="{{ route('user.login') }}" class="text-reset py-2 d-inline-block opacity-60">{{ translate('Login')}}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('user.registration') }}" class="text-reset py-2 d-inline-block opacity-60">{{ translate('Registration')}}</a>
                        </li>
                        @endauth
                </ul>
            </div>
        </div>
        <div class="row mt-2 p-2">
            <div class="col" style="overflow-x: scroll; overflow-y: hidden; scrollbar-width: 2;">
                <ul class="list-inline d-flex justify-content-lg-start mb-0">
                        <li class="list-inline-item mr-3">
                            <a href="{{route('home')}}" class="text-reset py-2" data-display="static">
                                <i class="la la-home"></i>
                                <span class="opacity-100 menu_text">Home</span>
                            </a>
                        </li>

                        <li class="list-inline-item mr-3">
                            <a href="{{route('contact_doctor')}}" class="text-reset py-2" data-display="static">
                                <i class="las la-stethoscope"></i>
                                <span class="opacity-100 menu_text">Contact Doctor</span>
                            </a>
                        </li>
                        
                        <li class="list-inline-item mr-3">
                            <a href="{{ route('customer_feedback') }}" class="text-reset" data-display="static">
                                <i class="las la-headset"></i>
                                <span class="opacity-100 menu_text">{{ translate('Customer Feedback') }}</span>
                            </a>
                        </li>
                   @if(!isMobile())
                        <li class="list-inline-item mr-3">
                            <a href="{{route('orders.track')}}" class="text-reset py-2" data-display="static">
                                <i class="la la-shipping-fast"></i>
                                <span class="opacity-100 menu_text">Track Order</span>
                            </a>
                        </li> 
                        @endif
                    {{--//travel agent--}}
                    {{--//--}}
                        {{-- <li class="list-inline-item dropdown" id="currency-change"> --}}

                            {{--<a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-60" data-toggle="dropdown" data-display="static">--}}
                                {{--{{ \App\Currency::where('code', $currency_code)->first()->name }} {{ (\App\Currency::where('code', $currency_code)->first()->symbol) }}--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">--}}
                                {{--@foreach (\App\Currency::where('status', 1)->get() as $key => $currency)--}}
                                    {{--<li>--}}
                                        {{--<a class="dropdown-item @if($currency_code == $currency->code) active @endif" href="javascript:void(0)" data-currency="{{ $currency->code }}">{{ $currency->name }} ({{ $currency->symbol }})</a>--}}
                                    {{--</li>--}}
                                {{--@endforeach--}}
                            {{--</ul>--}}
                        {{-- </li> --}}

                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END Top Bar -->
<header class="@if(get_setting('header_stikcy') == 'on') sticky-top @endif z-1020  border-bottom shadow-sm" style="background-color: white; color: var(--primary)">
    <div class="position-relative logo-bar-area ">
        <div class="container">
            <div class="d-flex align-items-center">

                <div class="col-auto col-xl-3 pl-0 pr-3 d-flex align-items-center">
                    <a class="d-block py-20px mr-3 ml-0" href="{{ route('home') }}">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if($header_logo != null)
                            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-30px h-md-40px" height="40">
                        @else
                            <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-30px h-md-40px" height="40">
                        @endif
                    </a>

                    @if(Route::currentRouteName() != 'home')
                        <div class="d-none d-xl-block align-self-stretch category-menu-icon-box ml-auto mr-0">
                            <div class="h-100 d-flex align-items-center" id="category-menu-icon">
                                <div class="dropdown-toggle navbar-light bg-light h-40px w-50px pl-2 rounded border c-pointer">
                                    <span class="navbar-toggler-icon"></span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-lg-none ml-auto mr-0">
                    <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle" data-target=".front-header-search">
                        <i class="las la-search la-flip-horizontal la-2x"></i>
                    </a>
                </div>
                <!--Customize header--->
                <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white class-toggle">
                    <div class="position-relative flex-grow-1">
                        <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                            <div class="d-flex position-relative align-items-center">
                                <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                    <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                                </div>
                                <div class="input-group" style="border-radius: 100px; border: 2px solid white;">
                                    <input type="text" class="border-0 border-lg form-control" id="search" name="q" placeholder="{{translate('I am shopping for...')}}" autocomplete="off">
                                    <div class="input-group-append d-none d-lg-block">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="la la-search la-flip-horizontal fs-18"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">
                            <div class="search-preloader absolute-top-center">
                                <div class="dot-loader"><div></div><div></div><div></div></div>
                            </div>
                            <div class="search-nothing d-none p-3 text-center fs-16">

                            </div>
                            <div id="search-content" class="text-left">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-lg-none ml-3 mr-0">
                    <div class="nav-search-box">
                        <a href="#" class="nav-box-link">
                            <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                        </a>
                    </div>
                </div>

                <div class="d-none d-lg-block ml-3 mr-0">
                    <div class="" id="compare">
                        @include('frontend.partials.compare')
                    </div>
                </div>

                <div class="d-none d-lg-block ml-3 mr-0">
                    <div class="" id="wishlist">
                        @include('frontend.partials.wishlist')
                    </div>
                </div>

                <div class="d-none d-lg-block  align-self-stretch ml-3 mr-0" data-hover="dropdown">
                    <div class="nav-cart-box dropdown h-100" id="cart_items">
                        @include('frontend.partials.cart')
                    </div>
                </div>
                <div class="d-none d-lg-block  align-self-stretch ml-3 mr-0" data-hover="dropdown">
                    <div class="nav-cart-box dropdown h-100">
                            <a href="{{route('orders.track')}}" class="d-flex align-items-center text-reset h-100" data-display="static">
                                <span class="flex-grow-1 ml-1">
                                <i class="la la-shipping-fast la-2x opacity-80"></i>
                                <br>
                                <span class="nav-box-text d-none d-xl-block opacity-70">Track Order</span>
                                </span>
                            </a>
                        </li>
                    </div>
                </div>
            </div>
        </div>
        @if(Route::currentRouteName() != 'home')
            <div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 d-none z-3" id="hover-category-menu">
                <div class="container">
                    <div class="row gutters-10 position-relative">
                        <div class="col-lg-3 position-static">
                            @include('frontend.partials.category_menu')
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
{{-- 
    <div class="d-block d-sm-none" style="overflow: hidden; margin-left: 10px; margin-right: 10px;">
        <form action="{{ route('search') }}" method="GET" class="stop-propagation">
            <div class="d-flex position-relative align-items-center">
                <div class="input-group" style="border-radius: 100px; border: 2px solid white;">
                    <input type="text" class="border-0 border-lg form-control" id="search" name="q" placeholder="{{translate('I am shopping for...')}}" autocomplete="off">
                    <div class="input-group-append d-none d-lg-block">
                        <button class="btn btn-primary" type="submit">
                            <i class="la la-search la-flip-horizontal fs-18"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div> --}}

</header>