<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;


class UploaderService
{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function upload($file, $directory)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        try {
            $file->move(
                $directory,
                $newFilename
            );
        } catch (FileException $e) {
            var_dump($e);
        }

        return $newFilename;
    }

    public function base64ToImage($base64_string, $path)
    {
        $filename = uniqid(rand(), true) . '.png';
        $data = explode(',', $base64_string);
        $status = file_put_contents($path . "/" . $filename, base64_decode($data[1]));

        return ($status ? $filename : null);
    }
}
