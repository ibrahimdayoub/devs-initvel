@php
    $locale = app()->getLocale();
@endphp

<div class="header container">
    <div>
    </div>
    <ul>
        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home', ['lang' => $locale]) }}">@lang('public.home')</a>
        </li>
        <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
            <a href="{{ route('about', ['lang' => $locale]) }}">@lang('public.about')</a>
        </li>
        <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
            <a href="{{ route('contact', ['lang' => $locale]) }}">@lang('public.contact')</a>
        </li>
        <ul class="langs">
            @foreach ($langs as $lang)
                <li class="lang" lang={{$lang}}>
                    <a href="{{ route('change-lang', ['lang' => $lang]) }}?current={{ request()->path() }}">{{$lang}}</a>
                </li>
            @endforeach
        </ul>
    </ul>
</div>