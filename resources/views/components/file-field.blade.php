<x-laravel-mail.field-wrapper :name="$name" :label="$label">
    <input type="file" name="{{ $name }}" {{ $attributes->merge(['id' => 'id-field-' .  str_replace('[]', '', $name), 'class' => 'form-control']) }}>
</x-laravel-mail.field-wrapper>
