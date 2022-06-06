<?php

namespace App\Console\Commands;

use App\Http\Controllers\FileController;
use App\Models\Banner;
use Hekmatinasser\Verta\Verta;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BannerDeadline extends Command
{
    use FileController;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'banner:deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(Cache::get('banner')) {
            $now = new Verta();
            $banner = Banner::all()->first();
            $deadline = Verta::parse($banner->discount_deadline);
            if ($now->gt($deadline)) {
                $product = $banner->product;

                $product->update([
                    'price' => $banner->last_price
                ]);

                $this->deleteFile('images/banner/'.$banner->image);
                $result = $banner->delete();
                Cache::forget('banner');
                Log::info("$banner deleted ($result)");
            } else {
                Log::info("$banner Could not be deleted");
            }
        } else {
            Log::info('there is no banner');
        }
    }
}
