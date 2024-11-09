<?php

namespace Softexpert\Mercado\utils;

class File
{
    private $files = [];
    public function __construct($filesGlobal, $filesData)
    {
        if (count($filesGlobal) > 0) {
            foreach ($filesGlobal as $key => $value) {
                $this->files[$key] = $value;
            }
        }

        if (count((array) $filesData) > 0) {
            foreach ((array) $filesData as $key => $value) {
                if ($this->isValidBase64Image($value)) {
                    $filename = time() . ".".$this->getExtFrom64($value);
                    
                    $imageData = base64_decode($value);
                    $tempPath = sys_get_temp_dir() . '/' . $filename;

                    file_put_contents($tempPath, $imageData);

                    $this->files[$key] = [
                        'name' => $filename,
                        'type' => mime_content_type($tempPath),
                        'tmp_name' => $tempPath,
                        'error' => 0,
                        'size' => filesize($tempPath),
                    ];

                    // unlink($tempPath);
                }
            }
        }
    }

    private function isValidBase64Image($base64)
    {
        $decoded = base64_decode($base64, true);
        if ($decoded && @getimagesizefromstring($decoded)) {
            return true;
        }

        return false;
    }

    function getExtFrom64($base64String)
    {
        $decodedData = base64_decode($base64String, true);

        if ($decodedData === false) {
            return null;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $decodedData);
        finfo_close($finfo);

        $mimeToExt = [
            'image/jpeg' => 'jpeg',
            'image/png' => 'png',
            'image/jpg' => 'jpg'
        ];

        return $mimeToExt[$mimeType] ?? null;
    }

    public function getAll()
    {
        return $this->files;
    }
}