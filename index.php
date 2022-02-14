<?php
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri);

$validEndPoints = array("annotations" => array("byId", "byGroup", "byUrl"),
                        "groups" => array("byGroupName"));

// Verify that uri is valid
if (!isset($uri[3]) || !isset($validEndPoints[$uri[3]]) || 
    (isset($uri[4]) && !in_array($uri[4], $validEndPoints[$uri[3]]))) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/AnnotationController.php";

$objFeedController = new AnnotationController();
switch ($uri[3]) {
    case "annotations":
        if (isset($uri[4])) {
            switch ($uri[4]) {
                case "byGroup":
                    $objFeedController->getAnnotationsbyGroup();
                    break;
                case "byId":
                    $objFeedController->performAnnotationbyIDAction();
                    break;
                case "byUrl":
                    $objFeedController->getAnnotationsbyURL();
                    break;
            }
        }
        else {
            $objFeedController->performAnnotationsAction();
        }
        break;
    case "groups":
        if (isset($uri[4])) {
            switch ($uri[4]) {
                case "byGroupName":
                    $objFeedController->performGroupsByGroupNameAction();
                    break;
            }
        }
        else {
            $objFeedController->performGroupsAction();
        }
        break;
}

?>