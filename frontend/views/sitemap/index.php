<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($urls as $url): ?>
    <url>
        <loc><?php echo $host; ?><?php echo $url; ?></loc>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
    <?php endforeach; ?>
</urlset>