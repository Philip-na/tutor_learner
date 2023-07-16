<?php

require_once MODULE_PATH . 'database_models/page.php';
require_once MODULE_PATH . 'database_models/Courses.php';
require_once MODULE_PATH . 'database_models/User.php';
require_once MODULE_PATH . 'database_models/Router.php';
require_once MODULE_PATH . 'database_models/Sessions.php';
require_once MODULE_PATH . 'database_models/Ratings.php';
require_once MODULE_PATH . 'database_models/Topics.php';
require_once MODULE_PATH . 'database_models/Submissions.php';
require_once MODULE_PATH . 'database_models/Enrollement.php';
require_once MODULE_PATH . 'database_models/Sessionatedence.php';
DatabaseConnection::connect('localhost','tutor_learner','root',''); 
$dbh = DatabaseConnection::getInstance();
$dbc = $dbh->getConnection();