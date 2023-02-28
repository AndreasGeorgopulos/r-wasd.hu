<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

/**
 *
 */
trait TModelIndexImage
{
	protected $indexImageConfig;

	/**
	 * @param array $config
	 * @return void
	 */
	public function loadIndexImageConfig(array $config)
	{
		$this->indexImageConfig = $config;
	}

	/**
	 * @param string|null $resize
	 * @return string
	 */
	protected function getIndexImagePath(string $resize = null): string
	{
		if ($resize === null) {
			$resize = 'original';
		}

		$path = public_path($this->indexImageConfig['image_path']) . $this->id . '/' . ($resize ? ($resize . '/') : '');
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}

		return $path;
	}

	/**
	 * @param string|null $resize
	 * @return string|null
	 */
	public function getIndexImageFilePath(string $resize = null): ?string
	{
		if (empty($this->id) || empty($this->index_image_file_name)) {
			return null;
		}

		if (!array_key_exists($resize, $this->indexImageConfig['resizes'])) {
			$resize = null;
		}

		return $this->getIndexImagePath($resize) . $this->index_image_file_name;
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

		return url($this->indexImageConfig['image_path']) . '/' . $this->id . '/' . ($resize ? ($resize . '/') : '/') . $this->index_image_file_name;
	}

	/**
	 * @param UploadedFile|null $uploadedFile
	 * @return void
	 */
	public function saveIndexImageFile(UploadedFile $uploadedFile = null)
	{
		if (!$this->id || $uploadedFile === null) {
			return;
		}

		$this->deleteIndexImageFile();

		$this->index_image_file_name = $uploadedFile->getClientOriginalName();
		$this->save();

		$path = $this->getIndexImagePath();
		$uploadedFile->move($path, $uploadedFile->getClientOriginalName());
	}

	/**
	 * @return void
	 */
	public function deleteIndexImageFile()
	{
		if (empty($this->index_image_file_name)) {
			return;
		}

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
	public function resizeIndexImage()
	{
		$originalFilePath = $this->getIndexImageFilePath();
		foreach ($this->indexImageConfig['resizes'] as $key => $value) {
			if (!$value['enabled']) {
				continue;
			}

			$path = $this->getIndexImagePath($key);
			if (file_exists($path)) {
				unlink($path);
			}
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
}