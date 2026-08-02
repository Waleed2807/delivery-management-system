<?php
// Copy this file to config.php (which is gitignored) and fill in your real
// database credentials. Require it at the very top of index.php / any entry
// point so the environment variables are set before Database.php reads them.

putenv('DB_USERNAME=your_db_username');
putenv('DB_PASSWORD=your_db_password');
putenv('DB_HOST=localhost');
putenv('DB_NAME=delivery_system');
