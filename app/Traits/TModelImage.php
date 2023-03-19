<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Trait
 * <p>
 * Model képek kezelése
 */
trait TModelImage
{
	public $imageConfig;

	/**
	 * @param array $config
	 * @return void
	 */
	public function loadImageConfig(array $config): void
	{
		$this->imageConfig = $config;
	}

	/**
	 * @param string|null $resize
	 * @param bool $createdFolder
	 * @return string
	 */
	protected function getImagePath(string $resize = null, bool $createdFolder = true): string
	{
		if ($resize === null) {
			$resize = 'original';
		}

		$path = public_path($this->imageConfig['image_path']) . $this->product_id . '/' . $this->id . '/' . ($resize ? ($resize . '/') : '');
		if (!file_exists($path) && $createdFolder) {
			mkdir($path, 0777, true);
		}

		return $path;
	}

	/**
	 * @param string|null $resize
	 * @param bool $createdFolder
	 * @return string|null
	 */
	public function getImageFilePath(string $resize = null, bool $createdFolder = true): ?string
	{
		if (empty($this->id) || empty($this->file_name)) {
			return null;
		}

		if (!array_key_exists($resize, $this->imageConfig['resizes'])) {
			$resize = null;
		}

		return $this->getImagePath($resize, $createdFolder) . $this->file_name;
	}

	/**
	 * @param string|null $resize
	 * @return string|null
	 */
	public function getImageFileUrl(string $resize = null): ?string
	{
		if (empty($this->id) || empty($this->file_name)) {
			return null;
		}

		if ($resize === null) {
			$resize = 'original';
		}

		return url($this->imageConfig['image_path']) . '/' . $this->product_id . '/' . $this->id . '/' . ($resize ? ($resize . '/') : '/') . $this->file_name . '?ts=' . time();
	}

	/**
	 * @param UploadedFile|null $uploadedFile
	 * @return void
	 */
	public function saveImageFile(UploadedFile $uploadedFile = null): void
	{
		if (!$this->id || $uploadedFile === null) {
			return;
		}

		// korábbi file törlése
		$this->deleteImageFile();

		$this->file_name = $uploadedFile->getClientOriginalName();
		$this->file_type = $uploadedFile->getClientMimeType();
		$this->save();

		$path = $this->getImagePath();
		$uploadedFile->move($path, $uploadedFile->getClientOriginalName());

		$this->resizeImage();
	}

	/**
	 * @return void
	 * @throws \Exception
	 */
	public function deleteImageFile(): void
	{
		if (empty($this->file_name)) {
			return;
		}

		$this->deleteResizedImages();

		$filePath = $this->getImageFilePath();
		$dirPath = str_replace('/original/' . $this->file_name, '', $filePath);
		if (file_exists($filePath)) {
			File::delete($filePath);
			File::deleteDirectory($dirPath);
		}

		$this->delete();
	}

	/**
	 * @return void
	 */
	public function resizeImage(): void
	{
		if (!$this->hasImage()) {
			return;
		}

		$this->deleteResizedImages();

		$originalFilename = $this->file_name;
		$originalFilePath = $this->getImageFilePath();
		$watermarkSource = $this->imageConfig['watermark_path'];

		$enabledResizes = collect($this->imageConfig['resizes'])->where('enabled', true)->toArray();
		foreach ($enabledResizes as $key => $config) {
			$path = $this->getImagePath($key, false);
			if (file_exists($path)) {
				unlink($path);
			}

			$path = $this->getImagePath($key, true);

			// Make image from original
			$image = Image::make($originalFilePath);

			// Resize image
			$image->resize($config['width'], $config['height'], function ($constraint) use($config) {
				if ($config['aspect_ratio'] === true) {
					$constraint->aspectRatio();
				}
			});

			// Add watermark if function is enabled
			if (isset($config['watermark']) && $config['watermark']['enabled'] === true) {
				$image->insert($watermarkSource, $config['watermark']['position'], $config['watermark']['pos_x'], $config['watermark']['pos_y']);
			}

			// Save resized image
			$image->save($path . $originalFilename);

			/*Image::make($originalFilePath)
				->resize($config['width'], $config['height'], function ($constraint) use($config) {
					if ($config['aspect_ratio'] === true) {
						$constraint->aspectRatio();
					}
				})
				//->insert($watermarkSource, 'bottom-left', 0, 0)
				->save($path . $originalFilename);*/
		}
	}

	/**
	 * @return bool
	 */
	public function hasImage(): bool
	{
		if (empty($this->id) || empty($this->file_name)) {
			return false;
		}

		return (bool) file_exists($this->getImageFilePath());
	}

	/**
	 * @return void
	 */
	final protected function deleteResizedImages(): void
	{
		// Delete all files and folders except original
		$dirname = $this->imageConfig['image_path'] . $this->product_id . '/' . $this->id;
		if (!$this->hasImage()) {
			return;
		}

		foreach (scandir($dirname) as $file) {
			if (in_array($file, ['.', '..', 'original'])) {
				continue;
			}

			$path = $dirname . '/' . $file;
			if (is_dir($path)) {
				File::deleteDirectory($path);
			} else {
				File::delete($path);
			}
		}
	}
}