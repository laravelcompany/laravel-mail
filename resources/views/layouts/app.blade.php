@extends('laravel-mail::layouts.base')

@section('htmlBody')
    <div class="container-fluid">
        <div class="row">

            <div class="sidebar col-lg-2 bg-purple-100 min-vh-100 d-none d-xl-block">

                <div class="mt-4">
                    <div class="logo text-center">
                        <a href="{{ route('laravel-mail.dashboard') }}">
                            <svg style="width: 25%; height: auto;" viewBox="0 0 903.88 648.31" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" id="Layer_1">
                                <path d="M318.88,648.31L903.88,52.7,70.7,0l93.07,243.11,476.73-89.59L225.81,405.18l93.07,243.11Z" fill="#b4e1b1" opacity=".9"></path>
                                <path d="M2.5,266.82l100.53-38.49" stroke="#f58140" stroke-width="5" stroke-linecap="round"></path>
                                <path d="M49.08,375.35l268.6-102.83" stroke="#f58140" stroke-width="10" stroke-linecap="round"></path>
                                <path d="M39.45,510.05l99.58-38.12" stroke="#f58140" stroke-width="5" stroke-linecap="round"></path>
                            </svg>                        </a>
                    </div>
                </div>

                <div class="mt-5">
                    @include('laravel-mail::layouts.partials.sidebar')
                </div>
            </div>

            @include('laravel-mail::layouts.main')
        </div>
    </div>
@endsection
