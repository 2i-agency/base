<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\Bounded;
use Chunker\Base\Models\Traits\HasEditors;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
	use HasEditors, Bounded;

	protected $fillable = [
		'name',
		'alias'
	];


	/*
	 * Подготовка псевдонима
	 */
	public function setAliasAttribute($alias)
	{
		$this->attributes['alias'] = str_slug(trim($alias));
	}
}
