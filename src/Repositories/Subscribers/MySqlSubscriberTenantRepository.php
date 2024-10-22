<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Repositories\Subscribers;

use Carbon\CarbonPeriod;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MySqlSubscriberTenantRepository extends BaseSubscriberTenantRepository
{
    /**
     * @inheritDoc
     */
    public function getGrowthChartData(CarbonPeriod $period, int $workspaceId): array
    {
        $startingValue = DB::table('subscribers')
            ->where('workspace_id', $workspaceId)
            ->where(function (Builder $q) use ($period) {
                $q->where('unsubscribed_at', '>=', $period->getStartDate())
                    ->orWhereNull('unsubscribed_at');
            })
            ->where('created_at', '<', $period->getStartDate())
            ->count();

        //custom sqlite query
        $createdAtFormat = env('DB_CONNECTION') === 'sqlite' ?
            'strftime("%Y-%m-%d", created_at)' :
            'date_format(created_at, "%d-%m-%Y")';

        $unsubscribedAtFormat = env('DB_CONNECTION') === 'sqlite' ?
            'strftime("%Y-%m-%d", unsubscribed_at)' :
            'date_format(unsubscribed_at, "%d-%m-%Y")';


        $runningTotal = DB::table('subscribers')
            ->selectRaw("$createdAtFormat AS date, count(*) as total")
            ->where('workspace_id', $workspaceId)
            ->where('created_at', '>=', $period->getStartDate())
            ->where('created_at', '<=', $period->getEndDate())
            ->groupBy('date')
            ->get();

        $unsubscribers = DB::table('subscribers')
            ->selectRaw("$unsubscribedAtFormat AS date, count(*) as total")
            ->where('workspace_id', $workspaceId)
            ->where('unsubscribed_at', '>=', $period->getStartDate())
            ->where('unsubscribed_at', '<=', $period->getEndDate())
            ->groupBy('date')
            ->get();

        return [
            'startingValue' => $startingValue,
            'runningTotal' => $runningTotal->flatten()->keyBy('date'),
            'unsubscribers' => $unsubscribers->flatten()->keyBy('date'),
        ];
    }
}
