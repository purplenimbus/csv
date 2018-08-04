<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Upload;
use App\Notifications\UploadProcessed;
use App\Wordpress\NimbusWP;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

use Illuminate\Support\Facades\Auth;

class WordpressController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	var $http;
	var $wordpress_url;
	var $guzzle;
	
	function __construct(){
		$this->guzzle = new GuzzleClient();
		$this->NIMBUS = new NimbusWP(env('NIMBUS_MEDIA_API_ENPOINT'));
	}
	
	
	public function processFile(Request $request){
		try{
			//validate file?
			
			$upload = new Upload;
						
			$file = $request->file('files')[0];
			
			$payload = [
				'title' => $file->getClientOriginalName(),
				'files' => $file
			];
			
			if(Auth::user()->uuid){
				$payload['meta'] = [
					'user_uuid' => Auth::user()->uuid
				];	
			}	
			
			$options = [
				'headers'	=>	[	
					'Content-Disposition' => 'attachment; filename='.$file->getClientOriginalName(),
					//'Content-type' => $file->getClientMimeType()
				],
				'form_params' => $payload
				//'body' => file_get_contents($file->path())
			];
			
			//var_dump($file->getClientMimeType());
			
			$response = $this->NIMBUS->API('POST','media',$options);
						
			if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
				
				$upload->processed = true;
				
				$payload = json_decode($response->getBody()->getContents());
							
				$upload->url = $payload->guid->rendered;
				
				$upload->meta = [
					'wpId' => $payload->id
				];
				
				if(Auth::user()->uuid){
					$upload->user_uuid = Auth::user()->uuid; //move to middelware or model?
				}
				
				$upload->save();
				
				if(Auth::user()->uuid){
					Auth::user()->notify(new UploadProcessed($upload));
				}
							
				$data = ['uuid' => $upload->uuid,'status' => 'processed','url' => $upload->url];
				
				 \Log::info('Processed '.$file->getClientOriginalName());
				
			}else{
				$data = ['message' => 'somethings wrong', 'errors' => $response->getReasonPhrase()];
			}

			return response()->json($data,$response->getStatusCode());
		}catch(Exception $e){
			return response()->json(['status' => $e->getMessage() ],500);	
		}
	}
}
