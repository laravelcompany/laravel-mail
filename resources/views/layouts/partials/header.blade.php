<div class="main-header bg-dark-gray">

    <header class="navbar navbar-expand flex-row justify-content-between pl-4-half pr-4-half py-3 mb-4">

        <button type="button" class="btn btn-light mr-3 btn-sm d-xl-none" data-toggle="modal" data-target="#sidebar-modal">
            <i class="fa fa-bars"></i>
        </button>

        <h1 class="h3 mb-0 text-white">@yield('heading')</h1>

        {!! \LaravelCompany\Mail\Facades\LaravelMail::headerHtmlContent() !!}

    </header>
</div>
<style>
.main-header {
    position: relative;
}
</style>
