<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Interface
 * <p>
 * Index képek kezelése
 */
interface IModelIndexImage
{
	/**
	 * @param array $config
	 * @return void
	 */
	public function loadIndexImageConfig(array $config): void;

	/**
	 * @param string|null $resize
	 * @param bool $createdFolder
	 * @return string|null
	 */
	public function getIndexImageFilePath(string $resize = null, bool $createdFolder = true): ?string;

	/**
	 * @param string|null $resize
	 * @return string|null
	 */
	public function getIndexImageFileUrl(string $resize = null): ?string;

	/**
	 * @param UploadedFile|null $uploadedFile
	 * @return void
	 */
	public function saveIndexImageFile(UploadedFile $uploadedFile = null): void;

	/**
	 * @return void
	 */
	public function deleteIndexImageFile(): void;

	/**
	 * @return void
	 */
	public function resizeIndexImage(): void;

	/**
	 * @return bool
	 */
	public function hasIndexImage(): bool;
}