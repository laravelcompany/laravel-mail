<x-laravel-mail.text-field name="settings[key]" :label="__('Mailjet Key')" :value="Arr::get($settings ?? [], 'key')" autocomplete="off" />
<x-laravel-mail.text-field name="settings[secret]" :label="__('Mailjet Secret')" :value="Arr::get($settings ?? [], 'secret')" autocomplete="off" />
<x-laravel-mail.select-field name="settings[zone]" :label="__('Zone')" :options="['Default' => 'Default', 'US' => 'US']" :value="Arr::get($settings ?? [], 'zone')" />
