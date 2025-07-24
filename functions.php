<?php

function getFolders($path, $protected = []) 
{
    $result = [];
    $folders = scandir($path);
    $nb = count($folders);
    for ($i = 0; $i < $nb; $i++) {
        if ($folders[$i] != "." && $folders[$i] != ".." && !in_array($folders[$i], $protected) && is_dir($path . "/" . $folders[$i])) {
            $result[] = $folders[$i];
        }
    }
    return $result;
}

function getFiles($path)
{
    $result = [];
    $files = scandir($path);
    $nb = count($files);
    for ($i = 0; $i < $nb; $i++) {
        $file = $path . '/' . $files[$i];
        if (is_file($file)) {
            $result[] = $files[$i];
        }
    }
    return $result;
}


function dig($path, $bomb = [])
{
    static $result = [];
    $result[] = $path;

    $currentPath = $path;
    $currentFolders = getFolders($currentPath, $bomb);
    $nb = count($currentFolders);
    for ($i = 0; $i < $nb; $i++) {
        $currentPath = $path . "/" . $currentFolders[$i];
        $result[] = $currentPath;
        if (is_dir($currentPath)) {
            dig($currentPath,$bomb);
        }
    }

    return $result;
}

function collectTunnel($tunnel)
{
    $result = [];

    $nb = count($tunnel);
    for ($i = 0; $i < $nb; $i++) {
        $files = getFiles($tunnel[$i]);
        $result[$tunnel[$i]] = $files;
    }

    return $result;
}

///////

function getSize($path) {
    if (is_file($path)) {
        return filesize($path);
    }

    if (is_dir($path)) {
        $totalSize = 0;
        foreach (new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
        ) as $file) {
            $totalSize += $file->getSize();
        }
        return $totalSize;
    }

    return 0;
}

function formatSize($bytes) {
    $units = ['o', 'Ko', 'Mo', 'Go', 'To'];
    for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}


function getCreationDate($path) {
    if (!file_exists($path)) {
        return false;
    }

    $timestamp = filectime($path);
    return date("Y-m-d H:i:s", $timestamp);
}

function getLastModificationDate($path) {
    if (!file_exists($path)) {
        return false;
    }

    if (is_file($path)) {
        $timestamp = filemtime($path); // date dernière modification fichier
        return date("Y-m-d H:i:s", $timestamp);
    }

    if (is_dir($path)) {
        $lastMod = 0;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            $fileModTime = $file->getMTime();
            if ($fileModTime > $lastMod) {
                $lastMod = $fileModTime;
            }
        }

        if ($lastMod === 0) {
            // dossier vide, on peut retourner la date du dossier lui-même
            $lastMod = filemtime($path);
        }

        return date("Y-m-d H:i:s", $lastMod);
    }

    return false;
}
