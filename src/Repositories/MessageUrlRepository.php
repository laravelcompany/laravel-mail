<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Repositories;

use LaravelCompany\Mail\Models\MessageUrl;

class MessageUrlRepository extends BaseEloquentRepository
{
    protected $modelName = MessageUrl::class;

    /**
     * Get many records by a field and value
     *
     * @param array $parameters
     * @param array $relations
     * @return mixed
     * @throws \Exception
     */
    public function getBy(array $parameters, array $relations = [])
    {
        $instance = $this->getQueryBuilder()
            ->with($relations);

        foreach ($parameters as $field => $value) {
            $instance->where($field, $value);
        }

        return $instance->orderBy('click_count', 'desc')->get();
    }
}
