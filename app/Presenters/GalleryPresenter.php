<?php

namespace App\Presenters;

use App\Model\GalleryFacade;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\Presenter;

class GalleryPresenter extends Presenter
{
    public function __construct(private GalleryFacade $galleryFacade)
    {
    }

    public function renderShow(int $id): void
    {
        $this->galleryFacade->loadGalleries();
        $gallery = $this->galleryFacade->getGallery($id);
            $gallery->loadMedia();
        $this->template->gallery = $gallery;
    }
}