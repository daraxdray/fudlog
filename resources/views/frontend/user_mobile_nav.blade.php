@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-2">
        <div class="profile">
            <div class="container">
                <div class="row">
                        <ul class="col-12">
                            <li class="list-group-item">
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
                                            <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2"
                                               data-toggle="dropdown" data-display="static">
                                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                     data-src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}"
                                                     class="mr-2 lazyload"
                                                     alt="{{ \App\Language::where('code', $locale)->first()->name }}"
                                                     height="11">
                                                <span class="opacity-60">{{ \App\Language::where('code', $locale)->first()->name }}</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-left">
                                                @foreach (\App\Language::all() as $key => $language)
                                                    <li>
                                                        <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                                                           class="dropdown-item @if($locale == $language) active @endif">
                                                            <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                 data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}"
                                                                 class="mr-1 lazyload" alt="{{ $language->name }}"
                                                                 height="11">
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
                                            <a href="javascript:void(0)"
                                               class="dropdown-toggle text-reset py-2 opacity-60" data-toggle="dropdown"
                                               data-display="static">
                                                {{ \App\Currency::where('code', $currency_code)->first()->name }} {{ (\App\Currency::where('code', $currency_code)->first()->symbol) }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                                @foreach (\App\Currency::where('status', 1)->get() as $key => $currency)
                                                    <li>
                                                        <a class="dropdown-item @if($currency_code == $currency->code) active @endif"
                                                           href="javascript:void(0)"
                                                           data-currency="{{ $currency->code }}">{{ $currency->name }}
                                                            ({{ $currency->symbol }})</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                </ul>
                            </li>

                            <li class="list-group-item">
                                <a href="{{route('home')}}">
                                    <i class="la la-home la-1x"></i>
                                    <span> Home </span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{route('user.login')}}">
                                    <i class="la la-user-lock la-1x"></i>
                                    <strong>Login</strong>
                                </a>
                            </li>
                            <li class="list-group-item">

                                <a href="{{route('user.registration')}}">
                                    <i class="la la-user-plus la-1x"></i>
                                    <span>Register</span>
                                </a>
                            </li>
                            <li class="list-group-item">

                                <a href="{{ route('terms') }}">
                                    <i class="la la-file-text text-primary la-1x"></i>
                                    <span>{{ translate('Terms') }}</span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ url('/refundpolicy') }}">
                                    <i class="la la-mail-reply la-1x text-primary"></i>
                                    <span>{{ translate('Refund Policy') }}</span>
                                </a>
                            </li>
                            {{-- <li class="list-group-item">
                                <a href="{{ route('supportpolicy') }}">
                                    <i class="la la-support la-1x text-primary"></i>
                                    <span>{{ translate('Support Policy') }}</span>
                                </a>
                            </li> --}}
                            <li class="list-group-item">
                                <a href="{{ route('privacypolicy') }}">
                                    <i class="las la-exclamation-circle la-1x text-primary"></i>
                                    <span>{{ translate('Privacy Policy') }}</span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#contact-us">
                                    <i class="las la-exclamation-circle la-1x text-primary"></i>
                                    <span>{{ translate('Contact Us') }}</span>
                                </a>
                            </li>
                        </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-grey card text-dark">
        <div class="container">
            <div class="row">
                {{-- <div class="col-lg-5 col-xl-4 text-center text-md-left">
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="d-block">
                            @if(get_setting('footer_logo') != null)
                                <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset(get_setting('footer_logo')) }}" alt="{{ env('APP_NAME') }}" height="44">
                            @else
                                <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" height="44">
                            @endif
                        </a>
                        <div class="my-3">
                            @php
                                echo get_setting('about_us_description');
                            @endphp
                        </div>
                        <div class="d-inline-block d-md-block">
                            <form class="form-inline" method="POST" action="{{ route('subscribers.store') }}">
                                @csrf
                                <div class="form-group mb-0">
                                    <input type="email" class="form-control" placeholder="{{ translate('Your Email Address') }}" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    {{ translate('Subscribe') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-3 ml-xl-auto col-md-4 mr-0">
                    <div class="text-center text-md-left mt-4" id="contact-us">
                        <h4 class="fs-13 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                            {{ translate('Contact Info') }}
                        </h4>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                               <span class="d-block opacity-30">{{ translate('Address') }}:</span>
                               <span class="d-block opacity-70">{{ get_setting('contact_address') }}</span>
                            </li>
                            <li class="mb-2">
                               <span class="d-block opacity-30">{{translate('Phone')}}:</span>
                               <span class="d-block opacity-70">{{ get_setting('contact_phone') }}</span>
                            </li>
                            <li class="mb-2">
                               <span class="d-block opacity-30">{{translate('Email')}}:</span>
                               <span class="d-block opacity-70">
                                   <a href="mailto:{{ get_setting('contact_email') }}" class="text-reset">{{ get_setting('contact_email')  }}</a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- <div class="col-lg-2 col-md-4">
                    <div class="text-center text-md-left mt-4">
                        <h4 class="fs-13 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                            {{ get_setting('widget_one') }}
                        </h4>
                        <ul class="list-unstyled">
                            @if ( get_setting('widget_one_labels') !=  null )
                                @foreach (json_decode( get_setting('widget_one_labels'), true) as $key => $value)
                                <li class="mb-2">
                                    <a href="{{ json_decode( get_setting('widget_one_links'), true)[$key] }}" class="opacity-50 hov-opacity-100 text-reset">
                                        {{ $value }}
                                    </a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div> --}}
    
                {{-- <div class="col-md-4 col-lg-2">
                    <div class="text-center text-md-left mt-4">
                        <h4 class="fs-13 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                            {{ translate('My Account') }}
                        </h4>
                        <ul class="list-unstyled">
                            @if (Auth::check())
                                <li class="mb-2">
                                    <a class="opacity-50 hov-opacity-100 text-reset" href="{{ route('logout') }}">
                                        {{ translate('Logout') }}
                                    </a>
                                </li>
                            @else
                                <li class="mb-2">
                                    <a class="opacity-50 hov-opacity-100 text-reset" href="{{ route('user.login') }}">
                                        {{ translate('Login') }}
                                    </a>
                                </li>
                            @endif
                            <li class="mb-2">
                                <a class="opacity-50 hov-opacity-100 text-reset" href="{{ route('purchase_history.index') }}">
                                    {{ translate('Order History') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="opacity-50 hov-opacity-100 text-reset" href="{{ route('wishlists.index') }}">
                                    {{ translate('My Wishlist') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="opacity-50 hov-opacity-100 text-reset" href="{{ route('orders.track') }}">
                                    {{ translate('Track Order') }}
                                </a>
                            </li>
                            @if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated)
                                <li class="mb-2">
                                    <a class="opacity-50 hov-opacity-100 text-light" href="{{ route('affiliate.apply') }}">{{ translate('Networking Associates')}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    @if (get_setting('vendor_system_activation') == 1)
                        <div class="text-center text-md-left mt-4">
                            <a href="{{ route('shops.create') }}">
                            <h4 class="fs-13 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4 text-white">
                                {{ translate('Be a Seller') }}
                            </h4>
                            </a>
                        </div>
                    @endif
                </div> --}}
            </div>
        </div>
    </section>
    
    <!-- FOOTER -->
    {{-- <footer class="pt-3 pb-7 pb-xl-3 bg-black text-light d-none d-sm-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="text-center text-md-left">
                        @php
                            echo get_setting('frontend_copyright_text');
                        @endphp
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="list-inline my-3 my-md-0 social colored text-center">
                        @if ( get_setting('facebook_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('facebook_link') }}" target="_blank" class="facebook"><i class="lab la-facebook-f"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('twitter_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('twitter_link') }}" target="_blank" class="twitter"><i class="lab la-twitter"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('instagram_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('instagram_link') }}" target="_blank" class="instagram"><i class="lab la-instagram"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('youtube_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube"><i class="lab la-youtube"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('linkedin_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('linkedin_link') }}" target="_blank" class="linkedin"><i class="lab la-linkedin-in"></i></a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="text-center text-md-right">
                        <ul class="list-inline mb-0">
                            @if ( get_setting('payment_method_images') !=  null )
                                @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                    <li class="list-inline-item">
                                        <img src="{{ uploaded_asset($value) }}" height="30">
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    
    <div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-white shadow-lg border-top">
        <div class="d-flex justify-content-around align-items-center">
            <a href="{{ route('home') }}" class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['home'],'bg-soft-primary')}}">
                <i class="las la-home la-2x"></i>
            </a>
            <a href="{{ route('categories.all') }}" class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['categories.all'],'bg-soft-primary')}}">
                <span class="d-inline-block position-relative px-2">
                    <i class="las la-list-ul la-2x"></i>
                </span>
            </a>
            <a href="{{ route('cart') }}" class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['cart'],'bg-soft-primary')}}">
                <span class="d-inline-block position-relative px-2">
                    <i class="las la-shopping-cart la-2x"></i>
                    @if(Session::has('cart'))
                        <span class="badge badge-circle badge-primary position-absolute absolute-top-right" id="cart_items_sidenav">{{ count(Session::get('cart'))}}</span>
                    @else
                        <span class="badge badge-circle badge-primary position-absolute absolute-top-right" id="cart_items_sidenav">0</span>
                    @endif
                </span>
            </a>
            @if (Auth::check())
                @if(isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-reset flex-grow-1 text-center py-2">
                        <span class="avatar avatar-sm d-block mx-auto">
                            @if(Auth::user()->photo != null)
                                <img src="{{ custom_asset(Auth::user()->avatar_original)}}">
                            @else
                                <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                            @endif
                        </span>
                    </a>
                @else
                    <a href="javascript:void(0)" class="text-reset flex-grow-1 text-center py-2 mobile-side-nav-thumb" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav">
                        <span class="avatar avatar-sm d-block mx-auto">
                            @if(Auth::user()->photo != null)
                                <img src="{{ custom_asset(Auth::user()->avatar_original)}}">
                            @else
                                <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                            @endif
                        </span>
                    </a>
                @endif
            @else
                <a href="{{ route('mobile.navigation') }}" class="text-reset flex-grow-1 text-center py-2">
                    <span class="avatar avatar-sm d-block mx-auto">
                        <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                    </span>
                </a>
            @endif
        </div>
    </div> --}}
@endsection