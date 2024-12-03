@php
    $locale = app()->getLocale();
@endphp

@extends('layouts.master')
@section('title', 'Home')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/home.css?v=' . time()) }}" />
@endsection

@section('content')

{{-- Home Section 01 --}}
<div class="section-01 container">
    <h1 class="border-start">@lang('public.home')</h1>
</div>

{{-- Home Section 02 --}}
<div class="section-02 container">
    <h2 class="border-start">@lang('public.home')</h2>
</div>

{{-- Home Section 03 --}}
<div class="section-03 container">
    <h3 class="border-start">@lang('public.home')</h3>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/js/home.js?v=0.25') }}" defer></script>
@endsection