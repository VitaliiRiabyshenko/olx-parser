<?php
  
namespace App\Console\Commands;
  
use Carbon\Carbon;
use App\Contracts\Parser;
use App\Models\Announcement;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\AnnouncementChangedPrice;
  
class CheckChangedAnnouncement extends Command
{
    private $parser;

    public function __construct(Parser $parser)
    {
        parent::__construct();
        $this->parser = $parser;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'announcement:check-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for price changes in the announcement';
  
    /**
     * Execute the console command.
     */
    public function handle()
    {
        info("Cron Job running at ". now());
      
        $lastUpdatedTime = Carbon::now()->subMinutes(20);

        $announcements = Announcement::with(['users' => function($q) {
                $q->whereNotNull('email_verified_at');
            }])
            ->whereHas('users', function($q) {
                $q->whereNotNull('email_verified_at');
            })
            ->where('updated_at', '<=', $lastUpdatedTime)
            ->get();

        foreach ($announcements as $announcement) {
            $oldPrice = $announcement->price;
            $newPrice = $this->parser->parser($announcement->url);

            if ($oldPrice != $newPrice) {
                $announcement->price = $newPrice;
                $announcement->update();
                foreach ($announcement->users as $user) {
                    Mail::to($user->email)->send(new AnnouncementChangedPrice([
                        'url' => $announcement->url,
                        'oldPrice' => $oldPrice,
                        'newPrice' => $newPrice
                    ]));
                }
            }
        }
    }
}
