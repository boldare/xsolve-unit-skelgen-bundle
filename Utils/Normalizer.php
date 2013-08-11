<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

class Normalizer
{
    public function normalize($filename)
    {
        $fileInfo = new SplFileInfo($filename);

        return $fileInfo->getRealPath();
    }
}
