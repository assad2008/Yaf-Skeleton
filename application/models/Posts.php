<?php

use Illuminate\Database\Eloquent\Model;

class Posts extends Model {
	protected $table = 'wp_posts';
	protected $primaryKey = "ID";
	public $timestamps = false;
}
