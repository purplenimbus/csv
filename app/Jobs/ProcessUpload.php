<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;

use App\Upload;
use App\NimbusWP;

use App\Notifications\UploadProcessed;

class ProcessUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	var $file_path;
	var $file_name;
	
	function __construct($file_path,$file_name){
		
		$this->file_path = $file_path;
		$this->file_name = $file_name;
	}
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		try{
			$api = new NimbusWP(env('NIMBUS_MEDIA_API_ENPOINT'));
			
			$res = $api->process($this->file_path,$this->file_name);
			
		}catch(Exception $e){
			//do something	
		}
    }
}
