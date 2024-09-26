<div {{ $attributes->merge(['class' => 'form-group row form-group-' . $name . ' ' . $wrapperClass  . ' '. $errorClass($name)]) }}>
    <x-laravel-mail.label :name="$name">{{ $label }}</x-laravel-mail.label>
    <div class="col-sm-9">
        {{ $slot }}
    </div>
</div>
