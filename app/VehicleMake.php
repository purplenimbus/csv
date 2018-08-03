<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid as Uuid;

class VehicleMake extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'makes';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
	
	protected $hidden = [
        'id','created_at','updated_at'
    ];

	/**
	 *  Setup model event hooks
	 */
	public static function boot()
	{
		parent::boot();
		self::creating(function ($model) {
			$model->uuid = (string) Uuid::generate(4);
		});
	}
	
	/**
     * Get the comments for the blog post.
     */
    public function models()
    {
        return $this->hasMany('App\VehicleModel','make_id');
    }
}
