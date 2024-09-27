<?php
namespace LaravelCompany\Mail\Triggers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use LaravelCompany\Mail\DataBuses\DataBus;
use LaravelCompany\Mail\DataBuses\DataBussable;
use LaravelCompany\Mail\Fields\Fieldable;
use LaravelCompany\Mail\Jobs\ProcessWorkflow;
use LaravelCompany\Mail\Loggers\WorkflowLog;

//todo move the function for new builder in a base model or something
class Trigger extends Model
{
    use DataBussable, Fieldable;

    protected $table = 'triggers';

    public $family = 'trigger';

    public static $icon = '<i class="fas fa-question"></i>';

    protected $fillable = [
        'workflow_id',
        'parent_id',
        'type',
        'name',
        'data',
        'node_id',
        'pos_x',
        'pos_y',
    ];

    public static $output = [];
    public static $fields = [];
    public static $fields_definitions = [];

    protected $casts = [
        'data_fields' => 'array',
    ];

    public static $commonFields = [
        'Description' => 'description',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('workflows.db_prefix').$this->table;
        parent::__construct($attributes);
    }

    public function children()
    {
        return $this->morphMany(\LaravelCompany\Mail\Tasks\Task::class, 'parentable');
    }

    /**
     * Return Collection of models by type.
     *
     * @param  array  $attributes
     * @param  null  $connection
     * @return \App\Models\Action
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $entryClassName = '\\'.Arr::get((array) $attributes, 'type');

        if (class_exists($entryClassName)
            && is_subclass_of($entryClassName, self::class)
        ) {
            $model = new $entryClassName();
        } else {
            $model = $this->newInstance();
        }

        $model->exists = true;
        $model->setRawAttributes((array) $attributes, true);
        $model->setConnection($connection ?: $this->connection);

        return $model;
    }

    public function start(Model $model, array $data = [])
    {
        $log = WorkflowLog::createHelper($this->workflow, $model, $this);
        $dataBus = new DataBus($data);

        try {
            $this->checkConditions($model, $dataBus);
        } catch (\Exception $e) {
            $log->setError($e->getMessage(), $dataBus);
            exit;
        }

        ProcessWorkflow::dispatch($model, $dataBus, $this, $log);
    }

    /**
     * @throws \Exception
     */
    public function checkConditions(Model $model, DataBus $data): bool
    {
        //TODO: This needs to get smoother :(
        if (empty($this->conditions)) {
            return true;
        }

        $conditions = json_decode($this->conditions);

        foreach ($conditions->rules as $rule) {
            $ruleDetails = explode('-', $rule->id);
            $DataBus = $ruleDetails[0];
            $field = $ruleDetails[1];

            $result = config('workflows.data_resources')[$DataBus]::checkCondition($model, $data, $field, $rule->operator, $rule->value);

            if (! $result) {
                throw new \Exception('The Condition for Task '.$this->name.' with the field '.$rule->field.' '.$rule->operator.' '.$rule->value.' failed.');
            }
        }

        return true;
    }

    public function getSettings()
    {
        return view('laravel-mail::layouts.settings_overlay', [
            'element' => $this,
        ]);
    }

    public static function getTranslation(): string
    {
        return __(static::getTranslationKey());
    }

    public static function getTranslationKey(): string
    {
       return __((new \ReflectionClass(new static))->getShortName());
    }
}
