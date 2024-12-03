@php
    $locale = app()->getLocale();
@endphp

@extends('layouts.master')
@section('title', 'Contact')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/contact.css?v=' . time()) }}" />
@endsection

@section('content')

{{-- Contact Section 01 --}}
<div class="section-01 container">
    <h1 class="border-start">@lang('public.contact')</h1>
</div>

{{-- Contact Section 02 --}}
<div class="section-02 container">
    <h2 class="border-start">@lang('public.contact')</h2>
</div>

{{-- Contact Section 03 --}}
<div class="section-03 container">
    <h3 class="border-start">@lang('public.contact')</h3>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/js/contact.js?v=0.25') }}" defer></script>
@endsection