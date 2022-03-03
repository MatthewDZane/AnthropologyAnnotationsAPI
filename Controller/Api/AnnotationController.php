<?php
class AnnotationController extends BaseController
{
    public function performAnnotationbyIDAction() {
        $responseData = "";
        $strErrorDescription = "";
        $strErrorHeader = "";
        $requestMethod = strtoupper($_SERVER["REQUEST_METHOD"]);
        $arrQueryStringParams = $this->getQueryStringParams();

        $userModel = new UserModel();
        if ($requestMethod == 'GET') {
            if ($arrQueryStringParams && 
                array_key_exists("id", $arrQueryStringParams)) {
                $id = $arrQueryStringParams["id"];
                try {
                    $annotation = $userModel->selectAnnotationById($id);

                    if ($annotation == null) {
                        $responseData = json_encode(array("message" => "There is no annotation with the given id."));
                    }
                    else {
                        $responseData = json_encode($annotation);
                    }
                } catch (Error $e) {
                    $strErrorDescription = $e->getMessage();
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            }
            else {
                $strErrorDescription = "Missing 'id' parameter.";
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        }
        else if ($requestMethod == "PUT") {
            $putData = file_get_contents("php://input");
            if ($putData) {
                $jsonData = json_decode($putData);
                if ($jsonData && property_exists($jsonData, "id") && 
                    Annotation::isValidJson($jsonData)) {
                    $annotation = Annotation::jsonToAnnotation($jsonData);

                    if ($userModel->updateAnnotation($annotation)) {
                        $annotation = $userModel->selectAnnotationById(
                                                    $annotation->getId());  
                        if ($annotation == null) {
                            $strErrorDescription = "There is not an annotation with the given id.";
                            $strErrorHeader = 'HTTP/1.1 400 Bad Request';
                        }
                        else {                          
                            $responseData = json_encode(array("message" => "The " . 
                                            "annotation was updated successfully.",
                                            "updated_annotation" => $annotation));
                        }
                    }
                    else {
                        $strErrorDescription = $userModel->getLastError();
                        $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
                    }
                }
                else {
                    $strErrorDescription = "JSON is missing one or more " . 
                                           "required parameters.";
                    $strErrorHeader = 'HTTP/1.1 400 Bad Request';
                }
            }
            else {
                $strErrorDescription = "JSON is missing";
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        } 
        else {
            $strErrorDescription = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        $this->outputData($responseData, $strErrorDescription, $strErrorHeader);
    }

    public function getAnnotationsbyGroup() {
        $responseData = "";
        $strErrorDescription = "";
        $strErrorHeader = "";
        $requestMethod = strtoupper($_SERVER["REQUEST_METHOD"]);
        $arrQueryStringParams = $this->getQueryStringParams();

            $userModel = new UserModel();
            if ($requestMethod == "GET") {
                if ($arrQueryStringParams && 
                    array_key_exists("group_name", $arrQueryStringParams)) {
                    $groupName = $arrQueryStringParams["group_name"];
                    try {
                        $groups = $userModel->selectAnnotationsByGroup($groupName);
                        $responseData = json_encode($groups);
                    } catch (Error $e) {
                        $strErrorDescription = $e->getMessage();
                        $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
                    }
                }
                else {
                    $strErrorDescription = "Missing 'group_name' parameter.";
                    $strErrorHeader = "HTTP/1.1 400 Bad Request";
                }
            }
            else {
                $strErrorDescription = "Method not supported";
                $strErrorHeader = "HTTP/1.1 422 Unprocessable Entity";
            }

        $this->outputData($responseData, $strErrorDescription, $strErrorHeader);
    }

    public function getAnnotationsbyURL() {
        $responseData = "";
        $strErrorDescription = "";
        $strErrorHeader = "";
        $requestMethod = strtoupper($_SERVER["REQUEST_METHOD"]);
        $arrQueryStringParams = $this->getQueryStringParams();

        $userModel = new UserModel();
        if ($requestMethod == 'GET') {
            if ($arrQueryStringParams && 
                array_key_exists("url", $arrQueryStringParams)) {
                $url = $arrQueryStringParams["url"];
                try {
                    $annotations = $userModel->selectAnnotationsByURL($url);
                    $responseData = json_encode($annotations);
                } catch (Error $e) {
                    $strErrorDescription = $e->getMessage();
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            }
            else {
                $strErrorDescription = "Missing 'url' parameter.";
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        }
        else {
            $strErrorDescription = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        $this->outputData($responseData, $strErrorDescription, $strErrorHeader);
    }

    public function performAnnotationsAction() {
        $responseData = "";
        $strErrorDescription = "";
        $strErrorHeader = "";
        $requestMethod = strtoupper($_SERVER["REQUEST_METHOD"]);

        $userModel = new UserModel();
        if ($requestMethod == "GET") {
            try {
                $annotations = $userModel->selectAllAnnotations();
                $responseData = json_encode($annotations);
            } catch (Error $e) {
                $strErrorDescription = $e->getMessage();
                $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
            }
        }
        else if ($requestMethod == "POST") {
            $postData = file_get_contents("php://input");
            if ($postData) {
                $jsonData = json_decode($postData);
                if ($jsonData && Annotation::isValidJson($jsonData)) {
                    $annotation = Annotation::jsonToAnnotation($jsonData);

                    if ($userModel->insertAnnotation($annotation)) {
                        $annotation = $userModel->selectAnnotationsByLastInsertId();   
                        $responseData = json_encode(array("message" => "The " . 
                                        "annotation was inserted successfully.",
                                        "inserted_annotation" => $annotation));
                    }
                    else {
                        $strErrorDescription = $userModel->getLastError();
                        $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
                    }
                }
                else {
                    $strErrorDescription = "JSON is missing one or more " . 
                                           "required parameters.";
                    $strErrorHeader = 'HTTP/1.1 400 Bad Request';
                }
            }
            else {
                $strErrorDescription = "JSON is missing";
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        } 
        else {
            $strErrorDescription = "Method not supported";
            $strErrorHeader = "HTTP/1.1 422 Unprocessable Entity";
        }

        $this->outputData($responseData, $strErrorDescription, $strErrorHeader);
    }

    public function performGroupsByGroupNameAction() {
        $responseData = "";
        $strErrorDescription = "";
        $strErrorHeader = "";
        $requestMethod = strtoupper($_SERVER["REQUEST_METHOD"]);
        $arrQueryStringParams = $this->getQueryStringParams();

        $userModel = new UserModel();
        if ($requestMethod == "GET") {
            if ($arrQueryStringParams && 
                array_key_exists("group_name", $arrQueryStringParams)) {
                $groupName = $arrQueryStringParams["group_name"];
                try {
                    $group = $userModel->selectGroup($groupName);

                    if ($group == null) {
                        $responseData = json_encode(array("message" => "There is no group with the given name."));
                    }
                    else {
                        $responseData = json_encode($group);
                    }
                } catch (Error $e) {
                    $strErrorDescription = $e->getMessage();
                    $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
                }
            }
            else {
                $strErrorDescription = "Missing 'group_name' parameter.";
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        }
        else if ($requestMethod == "PUT") {
            $putData = file_get_contents("php://input");
            if ($putData) {
                $jsonData = json_decode($putData);
                if ($jsonData && 
                    property_exists($jsonData, "current_group_name") &&
                    property_exists($jsonData, "group") &&
                    Group::isValidJson($jsonData->group)) {
                    
                    $currentGroupName = $jsonData->current_group_name;
                    $groupToUpdate = $userModel->selectGroup($currentGroupName);  
                    if ($groupToUpdate != null) {
                        $group = Group::jsonToGroup($jsonData->group);
                        if ($userModel->updateGroup($currentGroupName, 
                                                    $group)) {
                            $group = $userModel->selectGroup($group->getGroupName());   
                            $responseData = json_encode(array("message" => "The " . 
                                            "group was updated successfully.",
                                            "updated_group" => $group));
                        }
                        else {
                            $strErrorDescription = $userModel->getLastError();
                            $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
                        }
                    }
                    else {
                        $strErrorDescription = "The group named " . 
                                                $currentGroupName . 
                                                " is not a group";
                        $strErrorHeader = "HTTP/1.1 400 Bad Request";
                    }
                }
                else {
                    $strErrorDescription = "JSON is missing one or more " . 
                                           "required parameters.";
                    $strErrorHeader = 'HTTP/1.1 400 Bad Request';
                }
            }
            else {
                $strErrorDescription = "JSON is missing";
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        } 
        else {
            $strErrorDescription = "Method not supported";
            $strErrorHeader = "HTTP/1.1 422 Unprocessable Entity";
        }

        $this->outputData($responseData, $strErrorDescription, $strErrorHeader);
    }


    public function performGroupsAction() {
        $responseData = "";
        $strErrorDescription = "";
        $strErrorHeader = "";
        $requestMethod = strtoupper($_SERVER["REQUEST_METHOD"]);
        $arrQueryStringParams = $this->getQueryStringParams();

        $userModel = new UserModel();
        if ($requestMethod == "GET") {
            try {
                $groups = $userModel->selectAllGroups();
                $responseData = json_encode($groups);
            } catch (Error $e) {
                $strErrorDescription = $e->getMessage();
                $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
            }
        }
        else if ($requestMethod == "POST") {
            $postData = file_get_contents("php://input");
            if ($postData) {
                $jsonData = json_decode($postData);
                if ($jsonData && Group::isValidJson($jsonData)) {
                    $group = Group::jsonToGroup($jsonData);

                    if ($userModel->insertGroup($group)) {
                        $group = $userModel->selectGroup($group->getGroupName());   
                        $responseData = json_encode(array("message" => "The " . 
                                        "group was inserted successfully.",
                                        "inserted_group" => $group));
                    }
                    else {
                        $strErrorDescription = $userModel->getLastError();
                        $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
                    }
                }
                else {
                    $strErrorDescription = "JSON is missing one or more " . 
                                           "required parameters.";
                    $strErrorHeader = 'HTTP/1.1 400 Bad Request';
                }
            }
            else {
                $strErrorDescription = "JSON is missing";
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        } 
        else {
            $strErrorDescription = "Method not supported";
            $strErrorHeader = "HTTP/1.1 422 Unprocessable Entity";
        }

        $this->outputData($responseData, $strErrorDescription, $strErrorHeader);
    }

    public function performHelp() {
        $responseData = "";
        $strErrorDescription = "";
        $strErrorHeader = "";
        $requestMethod = strtoupper($_SERVER["REQUEST_METHOD"]);
        $arrQueryStringParams = $this->getQueryStringParams();

        $userModel = new UserModel();
        if ($requestMethod == "GET") {
            $endpoint = "";
            if ($arrQueryStringParams && 
                array_key_exists("endpoint", $arrQueryStringParams)) {
                $endpoint = $arrQueryStringParams["endpoint"];  
            }
            
            try {
                $responseData = $userModel->getHelp($endpoint);
            } catch (Exception $e) {
                $strErrorDescription = $e->getMessage();
                $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
            }
        }
        else {
            $strErrorDescription = "Method not supported";
            $strErrorHeader = "HTTP/1.1 422 Unprocessable Entity";
        }

        $this->outputData($responseData, $strErrorDescription, $strErrorHeader);
 
    }

    private function outputData($responseData, $strErrorDescription,
                                $strErrorHeader) {
        if (!$strErrorDescription) {
            $this->sendOutput($responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDescription)), 
                array('Content-Type: application/json', $strErrorHeader));
        }
    }
}