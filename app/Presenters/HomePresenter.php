<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class HomePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(private readonly \App\Model\GalleryFacade $galleryFacade)
    {
    }

    public function renderDefault(): void
    {
        $this->galleryFacade->loadGalleries();
        $this->template->galleries = $this->galleryFacade->getGalleries();
    }
}
