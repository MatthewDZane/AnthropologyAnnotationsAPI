<?php
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri);

$validAnnotationEndPoints = array("groups", "byId", "byGroup", "byUrl");

// Verify that uri is valid
if (!isset($uri[3]) || $uri[3] != 'annotations' || 
    (isset($uri[4]) && !in_array($uri[4], $validAnnotationEndPoints))) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/AnnotationController.php";

$objFeedController = new AnnotationController();
if (isset($uri[4])) {
    switch ($uri[4]) {
        case "groups":
            $objFeedController->performGroupsAction();
            break;
        case "byGroup":
            $objFeedController->getAnnotationsbyGroup();
            break;
        case "byID":
            $objFeedController->getAnnotationbyID();
            break;
        case "byUrl":
            $objFeedController->getAnnotationsbyURL();
            break;
    }
}
else {
    $objFeedController->performAnnotationsAction();
}
?>