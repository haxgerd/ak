<?php
function getFileRowCount($filename)
{
    $file = fopen($filename, "r");
    $rowCount = 0;

    while (!feof($file)) {
        fgets($file);
        $rowCount++;
    }

    fclose($file);

    return $rowCount;
}

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$domain = $_SERVER['HTTP_HOST'];
$dir = rtrim(dirname($_SERVER['PHP_SELF']), '/');
$file = 'list.txt';
$urlPrefix = '/';
$urlSuffix = '.html';

$jumlahBaris = getFileRowCount($file);
$sitemapFile = fopen("sitemap.xml", "w");
fwrite($sitemapFile, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
fwrite($sitemapFile, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

$fileLines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($fileLines as $index => $judul) {
    $sitemapLink = $protocol . '://' . $domain . $dir . $urlPrefix . urlencode($judul) . $urlSuffix;
    fwrite($sitemapFile, '  <url>' . PHP_EOL);
    fwrite($sitemapFile, '    <loc>' . $sitemapLink . '</loc>' . PHP_EOL);
    fwrite($sitemapFile, '  </url>' . PHP_EOL);
}

fwrite($sitemapFile, '</urlset>' . PHP_EOL);
fclose($sitemapFile);

echo "Sitemap telah berhasil dibuat!";
?>
