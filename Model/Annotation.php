<?php
require_once PROJECT_ROOT_PATH . "Model/Transform.php";
require_once PROJECT_ROOT_PATH . "Model/Quaternion.php";
require_once PROJECT_ROOT_PATH . "Model/Point.php";


class Annotation implements JsonSerializable  {
    private int $id;
    private string $url;
    private string $title;
    private string $description;
    private string $descriptionLink;
    private string $groupName;

    private Point $cameraLocation;
    private Point $lookAtPoint;
    private Transform $annotationTransform;

    private string $lastUpdated;

    public function getId(): int { 
        return $this->id; 
    }

    public function getUrl(): string { 
        return $this->url; 
    }

    public function getTitle(): string { 
        return $this->title; 
    }

    public function getDescription(): string { 
        return $this->description; 
    }

    public function getDescriptionLink(): string {
        return $this->descriptionLink; 
    }

    public function getGroupName(): string { 
        return $this->groupName; 
    }

    public function getCameraLocation(): Point {
        return $this->cameraLocation;
    }

    public function getLookAtPoint(): Point {
        return $this->lookAtPoint;
    }

    public function getAnnotationTransform(): Transform {
        return $this->annotationTransform;
    }

    public function getLastUpdated(): string {
        return $this->lastUpdated;
    }


    public function setId(int $id): void { 
        $this->id = $id; 
    }

    public function setUrl(string $url): void { 
        $this->url = $url; 
    }

    public function setTitle(string $title): void { 
        $this->title = $title; 
    }

    public function setDescription(string $description): void { 
        $this->description = $description; 
    }

    public function setDescriptionLink(string $descriptionLink): void { 
        $this->descriptionLink = $descriptionLink; 
    }
    
    public function setGroupName(string $groupName): void { 
        $this->groupName = $groupName; 
    }

    public function setCameraLocation(Point $cameraLocation): void {
        $this->cameraLocation = $cameraLocation;
    }

    public function setLookAtPoint(Point $lookAtPoint): void {
        $this->lookAtPoint = $lookAtPoint;
    }

    public function setAnnotationTransform(Transform $annotationTransform): void {
        $this->annotationTransform = $annotationTransform;
    }

    public function setLast_Updated(string $lastUpdated): void {
        $this->lastUpdated = $lastUpdated;
    }

    public function __construct(int $id, string $url, string $title, 
                            string $description, string $descriptionLink,
                            string $groupName, Point $cameraLocation,
                            Point $lookAtPoint, 
                            Transform $annotationTransform,
                            string $lastUpdated) {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->descriptionLink = $descriptionLink;
        $this->groupName = $groupName;

        $this->cameraLocation = $cameraLocation;
        $this->lookAtPoint = $lookAtPoint;
        $this->annotationTransform = $annotationTransform;
        $this->lastUpdated = $lastUpdated;
    }

    public function jsonSerialize(): array {
        return [
            "id" => $this->id,
            "url" =>$this->url,
            "title" => $this->title,
            "description" => $this->description,
            "description_link" => $this->descriptionLink,
            "group_name" => $this->groupName,
            "camera_location" => $this->cameraLocation,
            "look_at_point" => $this->lookAtPoint,
            "annotation_transform" => $this->annotationTransform,
            "last_updated" => $this->lastUpdated,
        ];
    }

    public static function isValidJson(stdClass|array $json): bool {
        if (is_a($json, "array")) {
            return false;
        }

        if (!(property_exists($json, "url") && 
              property_exists($json, "title") &&
              property_exists($json, "description") && 
              property_exists($json, "description_link") &&
              property_exists($json, "group_name") && 
              property_exists($json, "camera_location") && 
              property_exists($json, "look_at_point") && 
              property_exists($json, "annotation_transform"))) {
            return false;
        }

        $cameraLocation = $json->camera_location;
        $lookAtPoint = $json->look_at_point;
        $annotationTransform = $json->annotation_transform;

        return Point::isValidJson($cameraLocation) && 
               Point::isValidJson($lookAtPoint) &&
               Transform::isValidJson($annotationTransform);
    }

    public static function jsonToAnnotation(stdClass $json): Annotation {
        $id = 0;
        if (property_exists($json, "id")) {
            $id = $json->id;
        }

        $cameraLocation = Point::jsonToPoint($json->camera_location);
        $lookAtPoint = Point::jsonToPoint($json->look_at_point);
        $annotationLocation = Transform::jsonToTransform($json->annotation_transform);

        $lastUpdated = "";
        if (property_exists($json, "last_updated")) {
            $lastUpdated = $json->last_updated;
        }

        return new Annotation($id, $json->url, $json->title, $json->description,
                              $json->description_link, $json->group_name, 
                              $cameraLocation, $lookAtPoint,
                              $annotationLocation, $lastUpdated);
    }
}
?>