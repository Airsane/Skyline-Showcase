<?php

namespace App\Entity;

use Nette\Application\LinkGenerator;

class Gallery
{
    private string $name;
    /**
     * @var Media[]
     */
    private array $media;

    private string $path;

    private static int $idTotal = 0;

    private int $id;

    private LinkGenerator $linkGenerator;

    /**
     * @param LinkGenerator $linkGenerator
     */
    public function setLinkGenerator(LinkGenerator $linkGenerator): void
    {
        $this->linkGenerator = $linkGenerator;
    }

    /**
     * @param string $name
     * @param string $path
     */
    public function __construct(string $name, string $path)
    {
        $this->name = $name;
        $this->path = $path;
        $this->media = [];
        $this->id = self::$idTotal++;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getMedia(): array
    {
        return $this->media;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }


    /**
     * @return Media[]
     */
    public function getVideos():array
    {
        $videos = [];
        foreach ($this->media as $media) {
            if ($media->isVideo()) {
                $videos[] = $media;
            }
        }
        return $videos;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        $images = [];
        foreach ($this->media as $media) {
            if (!$media->isVideo()) {
                $images[] = $media;
            }
        }
        return $images;
    }

    public function loadMedia(): void
    {
        $media = [];
        $files = scandir($this->path);
        foreach ($files as $file) {
            if ($file === "." || $file === "..") {
                continue;
            }
            $path = $this->path . "/" . $file;
            $name = pathinfo($path, PATHINFO_FILENAME);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $media[] = new Media($path, $name, $extension,$this->id,$this->linkGenerator);
        }
        $this->media = $media;
    }


}