<?php 
date_default_timezone_set('Africa/Lagos');

define("APP_URL", "http://localhost/afit/");

define("ADMIN_USER_KEY", "admin");

define("SUPER_ADMIN_USER_KEY", "super_admin");

define ("ADMIN_USERNAME", "admin");

define("USER_KEY", "user");

define("ADMIN_LANDING_PAGE", "../admin/");

define("ADMIN_LANDING_PAGE_BASE", "admin/");

define("UPLOADS_FOLDER", "../uploads/");

define("UPLOADS_BASE_FOLDER", "uploads/");

define("DEFAULT_PHOTO_PATH", "../app-assets/images/icon-user-default.png");

define("DASHBOARD", "dashboard");

define("MAX_FILE_SIZE", 10240000);

define("HIGH_PRIORITY", "high");

define("LOW_PRIORITY", "low");

define("MEDIUM_PRIORITY", "medium");

define("CRITICAL_PRIORITY", "critical");

define("COMPLETED_PROJECT", 1);

define("OVERDUE_PROJECT", 3);

define("ONGOING_PROJECT", 2);

define("PENDING_PROJECT", 0);

define("ATTENTION_REQUIRED", 2);

define("CONFIRMED", 1);

define("PENDING_CONFIRMATION", 0);

define("DEFAULT_MILESTONE_TEXT", "In progress");

define("OPEN_ATTENTION", 1);

define("NO_ATTENTION", 0);

define("CLOSED_ATTENTION", 2);

define("JOURNAL", "journal");

define("CONFERENCE", "conference");

define("BOOK_CHAPTER", "book_chapter");

define("BOOK", "book");

define("PATENT", "patent");

define("PROJECT_TYPE", "project");

define("TASK_TYPE", "task");

$colours = array('#1E9FF2','#ff3300', '#ff9900', '#009900', '#669900', '#ff0000');

$role_list =  array(SUPER_ADMIN_USER_KEY=>"Super Admin",ADMIN_USER_KEY=>"Admin");

define("TEST_SECRET_KEY", "sk_test_2625d1e12e6c604a2a9d71dba45394a5c566e8d8");

define("LIVE_SECRET_KEY", "sk_live_28b1c25bde0676d6b129c517d0420ed55cef1f95");

define("SECRET_KEY", TEST_SECRET_KEY);

?>