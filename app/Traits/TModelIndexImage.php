<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Trait
 * <p>
 * Index képek kezelése
 */
trait TModelIndexImage
{
	public $indexImageConfig;

	/**
	 * @param array $config
	 * @return void
	 */
	public function loadIndexImageConfig(array $config): void
	{
		$this->indexImageConfig = $config;
	}

	/**
	 * @param string|null $resize
	 * @param bool $createdFolder
	 * @return string
	 */
	protected function getIndexImagePath(string $resize = null, bool $createdFolder = true): string
	{
		if ($resize === null) {
			$resize = 'original';
		}

		$path = public_path($this->indexImageConfig['image_path']) . $this->id . '/' . ($resize ? ($resize . '/') : '');
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
	public function getIndexImageFilePath(string $resize = null, bool $createdFolder = true): ?string
	{
		if (empty($this->id) || empty($this->index_image_file_name)) {
			return null;
		}

		if (!array_key_exists($resize, $this->indexImageConfig['resizes'])) {
			$resize = null;
		}

		return $this->getIndexImagePath($resize, $createdFolder) . $this->index_image_file_name;
	}

	/**
	 * @param string|null $resize
	 * @return string|null
	 */
	public function getIndexImageFileUrl(string $resize = null): ?string
	{
		if (empty($this->id) || empty($this->index_image_file_name)) {
			return null;
		}

		if ($resize === null) {
			$resize = 'original';
		}

		return url($this->indexImageConfig['image_path']) . '/' . $this->id . '/' . ($resize ? ($resize . '/') : '/') . $this->index_image_file_name . '?ts=' . time();
	}

	/**
	 * @param UploadedFile|null $uploadedFile
	 * @return void
	 */
	public function saveIndexImageFile(UploadedFile $uploadedFile = null): void
	{
		if (!$this->id || $uploadedFile === null) {
			return;
		}

		// korábbi file törlése
		$this->deleteIndexImageFile();

		$this->index_image_file_name = $uploadedFile->getClientOriginalName();
		$this->save();

		$path = $this->getIndexImagePath();
		$uploadedFile->move($path, $uploadedFile->getClientOriginalName());

		$this->resizeIndexImage();
	}

	/**
	 * @return void
	 */
	public function deleteIndexImageFile(): void
	{
		if (empty($this->index_image_file_name)) {
			return;
		}

		$this->deleteResizedImages();

		$path = $this->getIndexImageFilePath();
		if (file_exists($path)) {
			unlink($path);
		}

		$this->index_image_file_name = null;
		$this->save();
	}

	/**
	 * @return void
	 */
	public function resizeIndexImage(): void
	{
		if (!$this->hasIndexImage()) {
			return;
		}

		$this->deleteResizedImages();

		$originalFilename = $this->index_image_file_name;
		$originalFilePath = $this->getIndexImageFilePath();
		$watermarkSource = $this->indexImageConfig['watermark_path'];

		$enabledResizes = collect($this->indexImageConfig['resizes'])->where('enabled', true)->toArray();
		foreach ($enabledResizes as $key => $config) {
			$path = $this->getIndexImagePath($key, false);
			if (file_exists($path)) {
				unlink($path);
			}

			$path = $this->getIndexImagePath($key, true);

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
	public function hasIndexImage(): bool
	{
		if (empty($this->id) || empty($this->index_image_file_name)) {
			return false;
		}

		return (bool) file_exists($this->getIndexImageFilePath());
	}

	/**
	 * @return void
	 */
	final protected function deleteResizedImages(): void
	{
		// Delete all files and folders except original
		$dirname = $this->indexImageConfig['image_path'] . $this->id;
		if (!$this->hasIndexImage()) {
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