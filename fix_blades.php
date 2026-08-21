<?php
$dir = new RecursiveDirectoryIterator("resources/views");
$iterator = new RecursiveIteratorIterator($dir);

$replacements = [
    "/\b->nama\b/" => "->nama_trans",
    "/\b->deskripsi\b/" => "->deskripsi_trans",
    "/\b->judul\b/" => "->judul_trans",
    "/\b->konten\b/" => "->konten_trans",
    "/\b->nama_usaha\b/" => "->nama_usaha_trans",
    "/\b->nama_wisata\b/" => "->nama_wisata_trans",
    "/\b->sejarah\b/" => "->sejarah_trans",
    "/\b->keunikan\b/" => "->keunikan_trans",
];

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === "php" && strpos($file->getPathname(), "admin") === false && strpos($file->getPathname(), "layouts") === false) {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        $original = $content;
        
        foreach ($replacements as $pattern => $replacement) {
            $content = preg_replace($pattern, $replacement, $content);
        }
        
        if ($content !== $original) {
            file_put_contents($path, $content);
            echo "Updated $path\n";
        }
    }
}

