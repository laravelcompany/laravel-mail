@extends('laravel-mail::layouts.app')

@section('title', __('Inbox'))

@section('heading')
    {{ __('Inbox') }}
@endsection

@section('content')

    <h1>{{ __('Inbox') }}</h1>
    <p>{{  __('You have no messages.') }}</p>
@endsection
