<div class="main-wrapper col p-0 min-vh-100">

    <div class="modal modal-left fade sidebar" id="sidebar-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable bg-purple-100 mh-100" role="document">
            <div class="modal-content border-0 rounded-0 mh-100">
                <div class="modal-body bg-purple-100 p-0">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="logo text-center mt-4">
                        <a href="{{ route('laravel-mail.dashboard') }}">
                            <svg viewBox="0 0 903.88 648.31" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" id="Layer_1"><path d="M318.88,648.31L903.88,52.7,70.7,0l93.07,243.11,476.73-89.59L225.81,405.18l93.07,243.11Z" fill="#4b1e4e" opacity=".9"></path><path d="M2.5,266.82l100.53-38.49" stroke="#f58140" stroke-width="5" stroke-linecap="round"></path><path d="M49.08,375.35l268.6-102.83" stroke="#f58140" stroke-width="10" stroke-linecap="round"></path><path d="M39.45,510.05l99.58-38.12" stroke="#f58140" stroke-width="5" stroke-linecap="round"></path></svg>
                        </a>
                    </div>

                    @include('laravel-mail::layouts.partials.sidebar')
                </div>
            </div>
        </div>
    </div>

    @include('laravel-mail::layouts.partials.header')


    <div class="main-content pl-4-half pr-4-half pb-4-half">

        @if( ! in_array(request()->route()->getName(), [
            'login',
            'register',
            'password.reset',
        ]))
            @include('laravel-mail::layouts.partials.errors')
        @endif

        @include('laravel-mail::layouts.partials.success')
        @include('laravel-mail::layouts.partials.warning')
        @include('laravel-mail::layouts.partials.error')

        @yield('content')
    </div>

</div>
