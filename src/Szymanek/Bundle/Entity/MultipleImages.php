<?php

namespace Szymanek\Bundle\Entity;

class MultipleImages
{
    private $files;

    public function getFiles()
    {
        return $this->files;
    }

    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }
}