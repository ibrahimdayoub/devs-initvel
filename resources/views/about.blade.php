@php
    $locale = app()->getLocale();
@endphp

@extends('layouts.master')
@section('title', 'About')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/about.css?v=' . time()) }}" />
@endsection

@section('content')

{{-- About Section 01 --}}
<div class="section-01 container">
    <h1 class="border-start">@lang('public.about')</h1>
</div>

{{-- About Section 02 --}}
<div class="section-02 container">
    <h2 class="border-start">@lang('public.about')</h2>
</div>

{{-- About Section 03 --}}
<div class="section-03 container">
    <h3 class="border-start">@lang('public.about')</h3>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/js/about.js?v=0.25') }}" defer></script>
@endsection