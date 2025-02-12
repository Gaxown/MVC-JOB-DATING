<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=mvc_job_dating user=postgres password=admin");
if ($dbconn) {
    echo "Connected successfully";
} else {
    echo "Connection failed";
}
