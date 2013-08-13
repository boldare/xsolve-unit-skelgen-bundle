<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

class PathTools
{
    public function normalize($path)
    {
        return realpath($path);
    }

    public function isFile($path)
    {
        return is_file($path);
    }
}
