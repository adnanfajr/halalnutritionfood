<?php
$url = "http://localhost:8983/solr/halal/bm25f/?q=apakah%20good%20halal";  //The url from where you are getting the contents
$content = file_get_contents($url);
$json = json_decode($content, true);

print 'Query : ';
print $json['responseHeader']['params']['q'];
print '<br>';
print '<br>';

foreach($json['response']['docs'] as $item) {
    print_r($item['food_name'][0]);
    print ' - ';
    print_r($item['food_man'][0]);
    print '<br>';
}
?>