<?php

function getFolders($path, $protected = [])
{
    $result = [];

    if (!is_dir($path) || !is_readable($path))
        return $result;

    $folders = scandir($path);
    if ($folders === false)
        return $result;

    foreach ($folders as $folder) {
        if ($folder === "." || $folder === "..")
            continue;
        $fullPath = $path . "/" . $folder;
        if (!in_array($folder, $protected) && is_dir($fullPath) && is_readable($fullPath)) {
            $result[] = $folder;
        }
    }

    return $result;
}

function getFiles($path)
{
    $result = [];
    if (!is_dir($path) || !is_readable($path))
        return $result;

    $files = scandir($path);
    if ($files === false)
        return $result;

    foreach ($files as $file) {
        $fullPath = $path . '/' . $file;
        if (is_file($fullPath) && is_readable($fullPath)) {
            $result[] = $file;
        }
    }

    return $result;
}

function dig($path, $bomb = [])
{
    static $result = [];

    if (!is_dir($path) || !is_readable($path))
        return $result;

    $result[] = $path;
    $currentFolders = getFolders($path, $bomb);

    foreach ($currentFolders as $folder) {
        $currentPath = $path . "/" . $folder;
        $result[] = $currentPath;
        dig($currentPath, $bomb);
    }

    return $result;
}

function collectTunnel($tunnel)
{
    $result = [];

    foreach ($tunnel as $folder) {
        $result[$folder] = getFiles($folder);
    }

    return $result;
}

function getSize($path)
{
    if (!file_exists($path) || !is_readable($path))
        return 0;

    if (is_file($path))
        return filesize($path);

    if (is_dir($path)) {
        $totalSize = 0;
        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
            );
            foreach ($iterator as $file) {
                if ($file->isReadable()) {
                    $totalSize += $file->getSize();
                }
            }
        } catch (Exception $e) {
        }
        return $totalSize;
    }

    return 0;
}

function formatSize($bytes)
{
    $units = ['o', 'Ko', 'Mo', 'Go', 'To'];
    for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}

function getCreationDate($path)
{
    if (!file_exists($path) || !is_readable($path))
        return false;
    return date("Y-m-d H:i:s", filectime($path));
}

function getLastModificationDate($path)
{
    if (!file_exists($path) || !is_readable($path))
        return false;

    if (is_file($path))
        return date("Y-m-d H:i:s", filemtime($path));

    $lastMod = filemtime($path) ?: 0;
    if (is_dir($path)) {
        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
            );
            foreach ($iterator as $file) {
                if ($file->isReadable()) {
                    $fileModTime = $file->getMTime();
                    if ($fileModTime > $lastMod)
                        $lastMod = $fileModTime;
                }
            }
        } catch (Exception $e) {
        }
    }

    return date("Y-m-d H:i:s", $lastMod);
}
