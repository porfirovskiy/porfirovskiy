<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <?php foreach ($images as $img): ?>
        <url>
          <loc><?php echo $host . $img['url']; ?></loc>
          <image:image>
            <image:loc><?php echo $host . '/' . $img['path']; ?></image:loc>
            <image:title><?php echo $img['name']; ?></image:title>
            <image:caption><?php echo $img['name']; ?></image:caption>
          </image:image>
        </url> 
    <?php endforeach; ?>
</urlset>