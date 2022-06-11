<?php

namespace App\Jobs;

use App\Http\Controllers\FileController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ForceDelete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels , FileController;

    protected Model $model;
    protected $filePath;
    protected $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Model $model, $filePath = null , $image = null)
    {
        $this->model = $model;
        $this->filePath = Str::startsWith($filePath , '/') ? substr($filePath , 1) : $filePath;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->model->deleted_at) {
            if(isset($this->filePath) && !empty($this->filePath)) {
                if (File::exists(public_path(). '/' .$this->filePath)) {
                    $deletedFile = unlink(public_path(). '/' . $this->filePath);
                } else {
                    Log::info('file doesnt exists');
                }
            }

            if (isset($this->image) && !empty($this->image)) {
                $deletedMorph = $this->image->forceDelete();
            }

            $deletedModel = $this->model->forceDelete();
            Log::info("the model : {$deletedModel} the file: $deletedFile the Image: $deletedMorph");
        } else {
            Log::info('model restored');
        }
    }
}
