<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexVideo extends Model implements IModelRules
{
	protected $table = 'index_videos';

	protected $fillable = ['sort', 'filename', 'is_active'];

	protected $casts = [
		'is_active' => 'bool',
	];

	/**
	 * @return string
	 */
	public function getSrc(): string
	{
		return asset('images/' . $this->filename);
	}

	/**
	 * A model validálásakor használt mező szabályok
	 *
	 * @return array
	 */
	public static function rules(): array
	{
		return [];
	}

	/**
	 * A model validálásakor használt mező feliratok
	 *
	 * @return array
	 */
	public static function niceNames(): array
	{
		return [];
	}

	/**
	 * A model validálásakor használt egyedi üzenetek
	 *
	 * @return array
	 */
	public static function customMessages(): array
	{
		return [];
	}

	/**
	 * @return mixed
	 */
	public static function getActiveVideos()
	{
		return static::where('is_active', 1)
			->orderBy('sort', 'asc')
			->get();
	}

	/**
	 * @return int
	 */
	public static function getNextSort(): int
	{
		return static::all()->max('sort') + 1;
	}

	public function getPath($fullPath = false)
	{
		return public_path('images/') . ($fullPath ? $this->filename : '');
	}
}
