<?php

namespace App\Handler;

use App\Form\Image;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

class ImageHandler extends Handler
{
    /**
     * @return string
     */
    public static function getFormType(): string
    {
        return Image::class;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return "";
    }

    /**
     * @return Response
     */
    public function onSuccess(): Response
    {

    }
}