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
