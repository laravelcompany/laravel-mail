<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('laravel-mail.messages.index') ? 'active'  : '' }}"
           href="{{ route('laravel-mail.messages.index') }}">{{ __('Sent') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('laravel-mail.messages.draft') ? 'active'  : '' }}"
           href="{{ route('laravel-mail.messages.draft') }}">{{ __('Draft') }}</a>
    </li>
</ul>
