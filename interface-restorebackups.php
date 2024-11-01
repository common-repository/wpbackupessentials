<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<h2>Restore Backups</h2>
You can use the quick restore links via <a href="?page=wpbackupessentials&section=listbackups">List Backups</a> or follow the instructions below for the most safest method.<br />
<br />
Restoring backups must be carefully done according to the following instructions<br />
1. Find the backup archive you want to restore. Archives ending in wpfiles.tar.gz are your Wordpress files. Archives ending in wpdb.tar.gz is the Wordpress Database.<br />
2. Extract the archive file ending in wpfiles.tar.gz to the server directory you want to restore all your Wordpress files to.<br />
3. Extract the archive file ending in wpdb.tar.gz to your personal computer to obtain the sql file within the archive file (if you're using Windows, use WinRAR to be able to extract the archive). Then go to your cPanel phpMyAdmin utility and import it into the database or create an entirely new database and import the sql file into that database.<br />
4. If you created an entirely new database, you'll need to edit your wp-config.php and ensure you set the correct settings for DB_NAME, DB_USER and DB_PASSWORD<br />
5. If you site url has changed, you'll also need to go to the wp_options table in your database and change the values for 'site_url' and 'home'<br />
6. Your site should be successfully restored if you did all the above<br />
OR use the WP Backup Essentials migrate script which does all of the work for you!<br />
<br />

</body>
</html>