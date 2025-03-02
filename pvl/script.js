import MapBuilder from './class/MapBuilder.min.js';
import FileViewer from './class/FileViewer.min.js';

const reader = new FileViewer("file-reader-space", "file-reader", "close-file-reader");
const map = new MapBuilder("map.php", "folders", "back", "loading");
map.addReader(reader);
map.rename("LOCALHOST");
map.setFileIcon("assets/file.svg");
map.setFolderIcon("assets/folder2.svg");

map.build();