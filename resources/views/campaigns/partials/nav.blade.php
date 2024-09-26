<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('laravel-mail.campaigns.index') ? 'active'  : '' }}"
           href="{{ route('laravel-mail.campaigns.index') }}">{{ __('Draft') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('laravel-mail.campaigns.sent') ? 'active'  : '' }}"
           href="{{ route('laravel-mail.campaigns.sent') }}">{{ __('Sent') }}</a>
    </li>
</ul>
