<x-laravel-mail.text-field name="settings[key]" :label="__('API Key')" :value="Arr::get($settings ?? [], 'key')" autocomplete="off" />
<x-laravel-mail.text-field name="settings[message_stream]" :label="__('Message Stream')" :value="Arr::get($settings ?? [], 'message_stream')" autocomplete="off" />
