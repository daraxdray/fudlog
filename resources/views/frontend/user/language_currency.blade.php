@extends('frontend.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.inc.user_side_nav')
            <div class="aiz-user-panel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Language & Currency') }}</h5>
                    </div>
                        <div class="card-body">
                            <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
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
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('modal')

@endsection

@section('script')

@endsection
