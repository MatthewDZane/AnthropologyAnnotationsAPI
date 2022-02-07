<?php
class AnnotationController extends BaseController
{
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
                $strErrorDescription = $e->getMessage() . "
                            Something went wrong! Please contact support.";
                $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
            }
        }
        else if ($requestMethod == "POST") {
            
        } 
        else {
            $strErrorDescription = "Method not supported";
            $strErrorHeader = "HTTP/1.1 422 Unprocessable Entity";
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
                        $strErrorDescription = $e->getMessage() .
                                "Something went wrong! Please contact support.";
                        $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
                    }
                }
                else {
                    $strErrorDescription = "Missing 'group_name' parameter.";
                    $strErrorHeader = "HTTP/1.1 400 Bad Request";
                }
            }
            else if ($requestMethod == "POST") {

            } 
            else {
                $strErrorDescription = "Method not supported";
                $strErrorHeader = "HTTP/1.1 422 Unprocessable Entity";
            }

        $this->outputData($responseData, $strErrorDescription, $strErrorHeader);
    }

    public function getAnnotationbyID() {
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
                    $annotations = $userModel->selectAnnotationsById($id);
                    $responseData = json_encode($annotations);
                } catch (Error $e) {
                    $strErrorDescription = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            }
            else {
                $strErrorDescription = "Missing 'id' parameter.";
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        }
        else if ($requestMethod == "POST") {

        } 
        else {
            $strErrorDescription = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
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
                    $strErrorDescription = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            }
            else {
                $strErrorDescription = "Missing 'url' parameter.";
                $strErrorHeader = 'HTTP/1.1 400 Bad Request';
            }
        }
        else if ($requestMethod == "POST") {

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
                $strErrorDescription = $e->getMessage() . "Something went 
                                       wrong! Please contact support.";
                $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
            }
        }
        else if ($requestMethod == "POST") {
            $postData = file_get_contents("php://input");
            if ($postData) {
                $jsonData = json_decode($postData);
                if ($postData && Annotation::isValidJson($jsonData)) {
                    $annotation = Annotation::jsonToAnnotation($jsonData);

                    if ($userModel->insertAnnotation($annotation)) {
                        $annotation = $userModel->selectAnnotationsByLastInsertId();   
                        $responseData = "{message:\"The annotation was inserted " .
                                        "successfully.\", inserted_annotation:\"" .
                                        json_encode($annotation) . "\"}";
                    }
                    else {
                        $strErrorDescription = $userModel->getLastError() . 
                                            ". Something went wrong! Please " .
                                            "contact support.";
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