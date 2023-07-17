<?php

namespace App\Model;

use App\Entity\Gallery;
use Nette\Application\LinkGenerator;

final class GalleryFacade
{
    private string $rootDir;
    /**
     * @var Gallery[]
     */
    private array $galleries;

    public function __construct(private readonly LinkGenerator $linkGenerator,string $rootDir = "C:\\Users\\patri\\Pictures\\testGallery")
    {
        $this->rootDir = $rootDir;
    }

    private function checkIfFolderExists(string $path): bool
    {
        return file_exists($path);
    }

    public function loadGalleries():void
    {
        if (!$this->checkIfFolderExists($this->rootDir)) {
            throw new \Exception("Root directory does not exist");
        }

        $galleries = [];
        $folders = scandir($this->rootDir);
        foreach ($folders as $folder) {
            if ($folder === "." || $folder === "..") {
                continue;
            }
            $galleries[] = new Gallery($folder, $this->rootDir . "/" . $folder);
            $galleries[count($galleries) - 1]->setLinkGenerator($this->linkGenerator);
        }
        $this->galleries = $galleries;
    }

    public function getGallery(int $id){
        foreach ($this->galleries as $gallery){
            if ($gallery->getId() === $id){
                return $gallery;
            }
        }
        throw new \Exception("Gallery with id $id does not exist");
    }

    /**
     * @return array
     */
    public function getGalleries(): array
    {
        return $this->galleries;
    }
}