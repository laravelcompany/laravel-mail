<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Tasks;

class Execute extends Task
{
    public static array $fields = [
        'Command' => 'command',
    ];

    public static array $output = [
        'Command Output' => 'command_output',
    ];

    public static $icon = '<i class="fas fa-terminal"></i>';

    public function execute(): void
    {
        chdir(base_path());

        $this->setData('command_output', shell_exec($this->getData('command')));
    }
}
