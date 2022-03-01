<?php

namespace Modules\MarketSession\Commands;

use Illuminate\Console\Command;
use Modules\MarketSession\Models\MarketSession;
use Modules\MarketSession\Models\MarketSessionDetail;

class CreateMarketSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create_market_session';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $marketSessionsSingle = MarketSession::with('marketDetail')->where('start_date', '>=', date('Y-m-d 00:00:00'))
                            ->where('start_date', '<=', date('Y-m-d 23:50:59'))
                            ->where('status', 1)->where('type', 'single')->get();
        foreach($marketSessionsSingle as $session)
        {
            if($session->marketDetail->isEmpty())
            {
                $marketSessionDetail = new MarketSessionDetail();
                $marketSessionDetail->market_id = $session->id;
                $marketSessionDetail->start_time = $session->start_date;
                $marketSessionDetail->wheel_slot = 0;
                $marketSessionDetail->save();
            }
        }

        $marketSessionsMonthly = MarketSession::with('marketDetail')
                                ->where('type', 'monthly')
                                ->where('date_interval', 'like', '%'.date('j'))
                                ->where('status', 1)->get();

        foreach($marketSessionsMonthly as $monthly)
        {
            $detail = MarketSessionDetail::where('market_id', $monthly->id)
                    ->where('start_time', date('Y-m-d '.date('H:i:s', strtotime($monthly->start_date))))->first();
            if(!$detail)
            {
                $marketSessionDetail = new MarketSessionDetail();
                $marketSessionDetail->market_id = $monthly->id;
                $marketSessionDetail->start_time = date('Y-m-d '.date('H:i:s', strtotime($monthly->start_date)));
                $marketSessionDetail->wheel_slot = 0;
                $marketSessionDetail->save();
            }
        }

        $marketSessionsWeekly = MarketSession::where('type', 'weekly')
                                ->where('date_interval', 'like', '%'.date('N').'%')
                                ->where('status', 1)->get();

        foreach($marketSessionsWeekly as $weekly)
        {
            $detail = MarketSessionDetail::where('market_id', $weekly->id)
                    ->where('start_time', date('Y-m-d '.date('H:i:s', strtotime($weekly->start_date))))->first();
            if(!$detail)
            {
                $marketSessionDetail = new MarketSessionDetail();
                $marketSessionDetail->market_id = $weekly->id;
                $marketSessionDetail->start_time = date('Y-m-d '.date('H:i:s', strtotime($weekly->start_date)));
                $marketSessionDetail->wheel_slot = 0;
                $marketSessionDetail->save();
            }
        }
    }
}
