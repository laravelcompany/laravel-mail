<div class="sidebar-inner mx-3">
    <ul class="nav flex-column mt-4">
        <li class="nav-item {{ request()->routeIs('laravel-mail.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laravel-mail.dashboard') }}">
                <i class="fa-fw fas fa-home mr-2"></i><span>{{ __('Dashboard') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*campaigns*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laravel-mail.campaigns.index') }}">
                <i class="fa-fw fas fa-envelope mr-2"></i><span>{{ __('Campaigns') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*templates*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laravel-mail.templates.index') }}">
                <i class="fa-fw fas fa-file-alt mr-2"></i><span>{{ __('Templates') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*subscribers*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laravel-mail.subscribers.index') }}">
                <i class="fa-fw fas fa-user mr-2"></i><span>{{ __('Subscribers') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*messages*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laravel-mail.messages.index') }}">
                <i class="fa-fw fas fa-paper-plane mr-2"></i><span>{{ __('Messages') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*email-services*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laravel-mail.email_services.index') }}">
                <i class="fa-fw fas fa-envelope mr-2"></i><span>{{ __('Email Services') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*workflows*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laravel-mail.workflows.index') }}">
                <i class="fa-fw fas fa-robot mr-2"></i><span>{{ __('Workflows') }}</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('*workflows*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laravel-mail.inbox.index') }}">
                <i class="fa-fw fas fa-envelope mr-2"></i><span>{{ __('Inbox') }}</span>
            </a>
        </li>
        {!! \LaravelCompany\Mail\Facades\LaravelMail::sidebarHtmlContent() !!}

    </ul>
</div>
