import MapBuilder from './class/MapBuilder.min.js';
import FileViewer from './class/FileViewer.min.js';
import FileListner from './class/FileListner.min.js';

const map = new MapBuilder("map.php", "folders", "back", "loading");
const reader = new FileViewer("file-reader-space", "file-reader", "close-file-reader");
const fileListener = new FileListner("files.php", "list", "file-info-space");

map.addReader(reader);
map.addListner(fileListener);
map.rename("LOCALHOST");
map.setFileIcon("assets/file.svg");
map.setFolderIcon("assets/folder2.svg");
fileListener.setPathArgsName("path");

map.build();
