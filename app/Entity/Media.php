<?php

namespace App\Entity;

use App\Enums\MediaType;
use Nette\Application\LinkGenerator;

class Media
{
    private string $path;
    private string $name;
    private string $extension;
    private ?MediaType $type;

    private LinkGenerator $linkGenerator;

    /**
     * @param string $path
     * @param string $name
     * @param string $extension
     * @param MediaType $type
     */
    public function __construct(string $path, string $name, string $extension,private int $galleryId,$linkGenerator)
    {
        $this->path = $path;
        $this->name = $name;
        $this->extension = $extension;
        $this->linkGenerator = $linkGenerator;
        $this->parseTypeByExtension();
    }


    private function parseTypeByExtension()
    {
        switch (strtolower($this->extension)) {
            case "jpg":
            case "png":
            case "jpeg":
            case "gif":
                $this->type = MediaType::IMAGE;
                break;
            case "mp4":
            case "avi":
            case "mov":
                $this->type = MediaType::VIDEO;
                break;
            default:
                $this->type = null;
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function getFullname():string{
        return $this->name . "." . $this->extension;
    }

    public function getContentType(): string
    {
        switch ($this->type) {
            case MediaType::IMAGE:
                return "image/" . $this->extension;
            case MediaType::VIDEO:
                return "video/" . $this->extension;
            default:
                return "application/octet-stream";
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return MediaType
     */
    public function getType(): MediaType
    {
        return $this->type;
    }

    public function isVideo():bool{
        return $this->type === MediaType::VIDEO;
    }

    public function getApiUrl():string{
        return $this->linkGenerator->link('Api:media', [$this->galleryId, 'fileName' => $this->getFullname()]);
    }

}