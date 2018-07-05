<?php 
/**
 * Simplepress RSS 2.0 Feed
 *
 * @author Manuel Zarat
 * @version 0.2.0
 * @link https://github.com/zarat/simplepress   
 * @since 06/2018 
 */
header("Content-type: text/xml");
require_once "load.php";
echo "<?xml version=\"1.0\" encoding=\"utf-8\" " . "?" . ">";
echo "<rss version=\"2.0\">";
$system = new system(); 
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$channel_url = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$item_url = str_replace(basename(__file__), '', $channel_url);
echo "<channel>";
echo "<title>" . $system->settings('site_title') . " > Updates</title>";
echo "<link>" . $channel_url . "</link>";
echo "<description>" . html_entity_decode($system->settings('site_description')) . "</description>";
$query = "SELECT item.id, item.title, item.content, item.status, item.date, 
GROUP_CONCAT( ( SELECT taxonomy FROM term_taxonomy WHERE id=tr.taxonomy_id ), '_', ( t.id ) ) AS type_int, 
GROUP_CONCAT( ( SELECT taxonomy FROM term_taxonomy WHERE id=tr.taxonomy_id ), '_', ( t.name ) ) AS type_str
FROM item 
INNER JOIN term_relation tr ON tr.object_id=item.id 
INNER JOIN term t on t.id=tr.term_id
WHERE item.status=1
GROUP BY item.id 
HAVING type_str LIKE ('%type_post%')
ORDER BY item.date DESC";
$rss = $system->fetch_all_assoc( $system->query( $query ) );
    
foreach($rss as $row)    {
    
    echo "<item>";
    echo "<title>" . strip_tags( html_entity_decode( $row['title'] ) ) . "</title>";
    
    /**
     * Links muesen kodiert werden um im RSS richtig dargestellt zu werden
     */
    echo "<link>" . htmlspecialchars($item_url . "?id=" . $row['id']) . "</link>";
    
    /**
     * Inhalt kuerzen, wenn laenger als n Zeichen, Woerter dabei ganz lassen!
     */
    $content = strip_tags( html_entity_decode( $row['content'] ) );
    if ( strlen( $content ) > 240 ) {
        $content = preg_replace("/[^ ]*$/", '', substr( $content, 0, 240) ); 
    } 
    echo "<description>" . htmlspecialchars($content) . "</description>";
    
    /** 
     * moderne RSS Feeds haben RFC822 konformes Datum! 
     */
    echo "<pubDate>" . date('r', $row['date']) . "</pubDate>";
    echo "</item>";
}
echo "</channel>";
echo "</rss>";
?>
