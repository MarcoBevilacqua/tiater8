<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;

class ExpireOldSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscriptions older than a year are marked with the expired status';

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
        //set subscriptions older than 366 days to expired
        $oldSubscriptions = Subscription::whereNotNull('customer_id')
            ->whereDate('created_at', '<', now()->subYear()->subDay()->format('Y-m-d H:i:s'))
            ->where('status', '!=', Subscription::EXPIRED)
            ->take(10)
            ->get();

        if($oldSubscriptions->count() === 0) {
            $this->line("No subs found older than a year, exiting...");
            //return 0;
        }

        $this->line("{$oldSubscriptions} sub(s) older than a year will be set to expired");

        $oldSubscriptions = Subscription::whereNotNull('customer_id')
            ->whereDate('created_at', '<', now()->subYear()->subDay()->format('Y-m-d H:i:s'))
            ->where('status', '!=', Subscription::EXPIRED)
            ->take(10)
            ->update([
                'status' => Subscription::EXPIRED
            ]);

        $this->line("{$oldSubscriptions} sub(s) older than a year are now expired");
        return 0;
    }
}
