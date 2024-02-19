<?php

namespace App\Jobs\Enquiries;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransmitToHubSpotJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(Enquiry $enquiry) /** @phpstan-ignore-line  */
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // todo: the logic for this job
    }
}
