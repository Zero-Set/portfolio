<?php
require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\BigQuery\BigQueryClient;

$projectId='<change code>';

$bigQuery = new BigQueryClient([
    'projectId' => $projectId,
]); 

$query = <<<ENDSQL
SELECT
CONCAT(
  'https://stackoverflow.com/questions/',
  CAST(id as STRING)) as url,
  view_count
FROM `bigquery-public-data.stackoverflow.posts_questions`
WHERE tags like '%google-bigquery%'
ORDER BY view_count DESC
LIMIT 10;
ENDSQL;
$queryJobConfig = $bigQuery->query($query);
$queryResults = $bigQuery->runQuery($queryJobConfig);

if ($queryResults->isComplete()) {
    $i = 0;
    $rows = $queryResults->rows();
    foreach ($rows as $row) {
        printf('--- Row %s ---' . PHP_EOL, ++$i);
        printf('url: %s, %s views' . PHP_EOL, $row['url'], $row['view_count']);
    }
    printf('Found %s row(s)' . PHP_EOL, $i);
} else {
    throw new Exception('The query failed to complete');
}


