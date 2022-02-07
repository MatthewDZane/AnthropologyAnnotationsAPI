<?php
require_once PROJECT_ROOT_PATH . "Model/Position.php";

class Annotation implements JsonSerializable  {
    private int $id;
    private string $url;
    private string $title;
    private string $description;
    private string $descriptionLink;
    private string $groupName;

    private Position $cameraLocation;
    private Position $lookAtPoint;
    private Position $annotationLocation;

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

    public function getCameraLocation(): Position {
        return $this->cameraLocation;
    }

    public function getLookAtPoint(): Position {
        return $this->lookAtPoint;
    }

    public function getAnnotationLocation(): Position {
        return $this->annotationLocation;
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

    public function setCameraLocation(Position $cameraLocation): void {
        $this->cameraLocation = $cameraLocation;
    }

    public function setLookAtPoint(Position $lookAtPoint): void {
        $this->lookAtPoint = $lookAtPoint;
    }

    public function setAnnotationLocation(Position $annotationLocation): void {
        $this->annotationLocation = $annotationLocation;
    }

    public function setLast_Updated(string $lastUpdated): void {
        $this->lastUpdated = $lastUpdated;
    }

    public function __construct(int $id, string $url, string $title, 
                            string $description, string $descriptionLink,
                            string $groupName, Position $cameraLocation,
                            Position $lookAtPoint, 
                            Position $annotationLocation,
                            string $lastUpdated) {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->descriptionLink = $descriptionLink;
        $this->groupName = $groupName;

        $this->cameraLocation = $cameraLocation;
        $this->lookAtPoint = $lookAtPoint;
        $this->annotationLocation = $annotationLocation;
        $this->lastUpdated = $lastUpdated;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->id,
            "url" =>$this->url,
            "title" => $this->title,
            "description" => $this->description,
            "description_link" => $this->descriptionLink,
            "group_name" => $this->groupName,
            "camera_location" => $this->cameraLocation,
            "look_at_point" => $this->lookAtPoint,
            "annotation_location" => $this->annotationLocation,
            "last_updated" => $this->lastUpdated,
        ];
    }
}
?>