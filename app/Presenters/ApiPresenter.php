<?php

namespace App\Presenters;

use App\Model\GalleryFacade;
use Nette\Application\Responses\TextResponse;
use Nette\Application\UI\Presenter;

class ApiPresenter extends Presenter
{

    public function __construct(private readonly GalleryFacade $galleryFacade)
    {
    }

    public function actionMedia(int $id, string $fileName)
    {
        $this->galleryFacade->loadGalleries();
        $gallery = $this->galleryFacade->getGallery($id);
        $gallery->loadMedia();
        $media = $gallery->getMedia();

        foreach ($media as $medium) {
            if ($medium->getFullname() === $fileName) {
                $this->sendResponse(new \Nette\Application\Responses\FileResponse($medium->getPath(), $medium->getName(), $medium->getContentType(), forceDownload: false));
                $this->terminate();

            }
        }
        $this->sendResponse(new TextResponse("File not found", 404));
    }

}