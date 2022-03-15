<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database
{
    // Select Functions
    public function selectAllGroups(): array {
        $query = "SELECT * FROM annotation_group";
        $result = $this->connection->query($query);

        $groups = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $groups[count($groups)] = new Group($row['group_name'], $row['sceneSettings']);
            }
        }

        return $groups;
    }

    public function selectGroup(string $groupName): Group|null {
        $query = "SELECT * FROM annotation_group WHERE group_name = ?";

        $result = null;
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("s", $groupName);
            $stmt->execute();

            $result = $stmt->get_result();
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	

        $row = $result->fetch_assoc();

        if ($row == null) {
            return null;
        }
        
        $group = null;
        try {
            $group = new Group($row['group_name'], $row['sceneSettings']);
        } catch(Exception $e) { }

        return $group;
    }

    public function selectAnnotationById(int $id): Annotation|null {
        $query = "SELECT * FROM annotation WHERE id = ?";

        $result = null;
        try {
            $stmt = $this->connection->prepare($query);  
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $result = $stmt->get_result();
        } catch(Exception $e) {
            $this->lastError = $e->getMessage();
            return null;
        }	

        $row = $result->fetch_assoc();

        if ($row == null) {
            return null;
        }

        $cameraLocationJson = json_decode($row['camera_location']);
        $cameraLookAtPointJson = json_decode($row['camera_look_at_point']);
        $annotationTransformJson = json_decode($row['annotation_transform']);

        $cameraLocation = Point::jsonToPoint($cameraLocationJson);
        $cameraLookAtPoint = Point::jsonToPoint($cameraLookAtPointJson);
        $annotationTransform = Transform::jsonToTransform($annotationTransformJson); 

        $annotation = new Annotation($row['id'], $row['url'], $row['title'], 
                                     $row['description'], 
                                     $row['description_link'], 
                                     $row['group_name'],
                                     $cameraLocation, $cameraLookAtPoint,
                                     $annotationTransform, $row['last_updated']);        

        return $annotation;
    }

    public function selectAnnotationsByGroup(string $groupName): array {
        $query = "SELECT * FROM annotation WHERE group_name = ?";

        $result = null;
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("s", $groupName);
            $stmt->execute();

            $result = $stmt->get_result();
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	

        $annotations = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $cameraLocationJson = json_decode($row['camera_location']);
                $cameraLookAtPointJson = json_decode($row['camera_look_at_point']);
                $annotationTransformJson = json_decode($row['annotation_transform']);
        
                $cameraLocation = Point::jsonToPoint($cameraLocationJson);
                $cameraLookAtPoint = Point::jsonToPoint($cameraLookAtPointJson);
                $annotationTransform = Transform::jsonToTransform($annotationTransformJson);
                
                $annotations[count($annotations)] = 
                    new Annotation($row['id'], $row['url'], $row['title'], 
                                $row['description'], 
                                $row['description_link'], $row['group_name'],
                                $cameraLocation, $cameraLookAtPoint,
                                $annotationTransform, $row['last_updated']);
            }
        }

        return $annotations;
    }

    public function selectAnnotationsByLastInsertId(): Annotation {
        $query = "SELECT * FROM annotation WHERE id = LAST_INSERT_ID()";
        $result = $this->connection->query($query);

        $row = $result->fetch_assoc();
        
        $cameraLocationJson = json_decode($row['camera_location']);
        $cameraLookAtPointJson = json_decode($row['camera_look_at_point']);
        $annotationLocationJson = json_decode($row['annotation_transform']);

        $cameraLocation = Point::jsonToPoint($cameraLocationJson);
        $cameraLookAtPoint = Point::jsonToPoint($cameraLookAtPointJson);
        $annotationTransform = Transform::jsonToTransform($annotationLocationJson);
        
        $annotation = new Annotation($row['id'], $row['url'], $row['title'], 
                                      $row['description'], 
                                      $row['description_link'], 
                                      $row['group_name'],
                                      $cameraLocation, $cameraLookAtPoint,
                                      $annotationTransform, 
                                      $row['last_updated']);
        
        return $annotation;
    }

    public function selectAnnotationsByURL(string $url): array {
        $query = "SELECT * FROM annotation WHERE url = ?";

        $result = null;
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("s", $url);
            $stmt->execute();

            $result = $stmt->get_result();
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	

        $annotations = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $cameraLocationJson = json_decode($row['camera_location']);
                $cameraLookAtPointJson = json_decode($row['camera_look_at_point']);
                $annotationLocationJson = json_decode($row['annotation_transform']);
        
                $cameraLocation = Point::jsonToPoint($cameraLocationJson);
                $cameraLookAtPoint = Point::jsonToPoint($cameraLookAtPointJson);
                $annotationTransform = Transform::jsonToTransform($annotationLocationJson);
                
                $annotations[count($annotations)] = 
                    new Annotation($row['id'], $row['url'], $row['title'], 
                                $row['description'], 
                                $row['description_link'], $row['group_name'],
                                $cameraLocation, $cameraLookAtPoint,
                                $annotationTransform, $row['last_updated']);
            }
        }

        return $annotations;
    }

    public function selectAllAnnotations(): array {
        $query = "SELECT * FROM annotation";
        $result = $this->connection->query($query);

        $annotations = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $cameraLocationJson = json_decode($row['camera_location']);
                $cameraLookAtPointJson = json_decode($row['camera_look_at_point']);
                $annotationLocationJson = json_decode($row['annotation_transform']);
        
                $cameraLocation = Point::jsonToPoint($cameraLocationJson);
                $cameraLookAtPoint = Point::jsonToPoint($cameraLookAtPointJson);
                $annotationTransform = Transform::jsonToTransform($annotationLocationJson);
                
                $annotations[count($annotations)] = 
                    new Annotation($row['id'], $row['url'], $row['title'], 
                                $row['description'], 
                                $row['description_link'], $row['group_name'],
                                $cameraLocation, $cameraLookAtPoint,
                                $annotationTransform, $row['last_updated']);
            }
        }

        return $annotations;
    }

    // Create Table Functions
    /**
     * Attempts to create the group table. Returns true if the group table was 
     * created, false otherwise.
     * 
     * @author Matthew Zane <Matthewdzane@gmail.com>
     * @return bool True if the group table was created, false otherwise.
     */ 
    public function createGroupTable(): bool {
        $sql = "CREATE TABLE annotation_group (
            group_name VARCHAR(50) PRIMARY KEY,
            sceneSettings JSON
            )";
        
        if ($this->connection->query($sql) === TRUE) {
            echo "Table annotation_group created successfully<br>";
            return true;
        } else {
            echo "Error creating table: " . $this->connection->error . "<br>";
            return false;
        }
    }

    /**
     * Attempts to create the annotation table. Returns true if the annotation
     * table was created, false otherwise.
     * 
     * @author Matthew Zane <Matthewdzane@gmail.com>
     * @return bool True if the annotation table was created, false otherwise.
     */ 
    public function createAnnotationTable(): bool {
        // sql to create table
        $sql = "CREATE TABLE annotation (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            url VARCHAR(100) NOT NULL,
            title VARCHAR(50),
            description VARCHAR(60000),
            description_link VARCHAR(100),
            group_name VARCHAR(50), 
            FOREIGN KEY (group_name) REFERENCES annotation_group(group_name),
            camera_location JSON,
            camera_look_at_point JSON,
            annotation_transform JSON,
            last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

        if ($this->connection->query($sql) === TRUE) {
            echo "Table annotation created successfully<br>";
            return true;
        } else {
            echo "Error creating table: " . $this->connection . "<br>";
            return false;
        }      
    }

    // Insert Functions
    public function addAnnotation(Annotation $annotation, string $sceneSettings): bool {
        $group = $this->selectGroup($annotation->getGroupName());

        if ($group == null) {
            $this->insertGroup(new Group($annotation->getGroupName(), $sceneSettings));
        }

        return $this->insertAnnotation($annotation);
    }

    /**
     * Checks if there exists a group entry with the given name. Creates a new
     * entry with the given name and current scene settings if it does not
     * already exist.
     *
     * @param string  $groupName  The name of the group to check existance of
     *                            and create if it does not exist
     * 
     * @author Matthew Zane <Matthewdzane@gmail.com>
     * @return bool True if the a new group with the given name was created.
     *              False if a group with the given name already existed, and
     *              therefore a new group was not created.
     */ 
    public function insertGroup(Group $group): bool {
        $query = "INSERT INTO annotation_group (group_name, sceneSettings)
                VALUES (?, ?)";

        try {
            $stmt = $this->connection->prepare($query);
            
            $groupName = $group->getGroupName();
            $sceneSettings = $group->getSceneSettings();
            $stmt->bind_param("ss", $groupName, $sceneSettings);

            if ($stmt->execute() === TRUE) {
                return true;
            } else {
                $this->lastError = $this->connection->error;
                return false;
            }
        } catch(Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        }	
    }

    public function insertAnnotation(Annotation $annotation): bool {
        $query = "INSERT INTO annotation (url, title, description, 
                description_link, group_name, camera_location, 
                camera_look_at_point, annotation_transform) VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)";
        
        try {
            $stmt = $this->connection->prepare($query);

            $url = $annotation->getUrl();
            $title = $annotation->getTitle(); 
            $description = $annotation->getDescription();
            $descriptionLink = $annotation->getDescriptionLink();
            $groupName = $annotation->getGroupName();

            # create JSONs for the 3D points
            $cameraLocationJSON = json_encode($annotation->getCameraLocation());
            $lookAtPointJSON = json_encode($annotation->getLookAtPoint());
            $annotationTransformJSON = json_encode($annotation->getAnnotationTransform());

            $stmt->bind_param("ssssssss", $url, $title, $description,
                              $descriptionLink, $groupName,
                              $cameraLocationJSON, $lookAtPointJSON, 
                              $annotationTransformJSON);

            if ($stmt->execute() === TRUE) {
                return true;
            } else {
                $this->lastError = $this->connection->error;
                return false;
            }
        } catch(Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        }	
    }

    public function updateAnnotation(Annotation $annotation): bool {
        $query = "UPDATE annotation SET url = ?, title = ?, description = ?, 
                description_link = ?, group_name = ?, camera_location = ?,
                camera_look_at_point = ?, annotation_transform = ? WHERE id= ?";
        
        try {
            $stmt = $this->connection->prepare($query);

            $url = $annotation->getUrl();
            $title = $annotation->getTitle();
            $description = $annotation->getDescription();
            $descriptionLink = $annotation->getDescriptionLink();
            $groupName = $annotation->getGroupName();
            $id = $annotation->getId();

            # create JSONs for the 3D points
            $cameraLocationJSON = json_encode($annotation->getCameraLocation());
            $lookAtPointJSON = json_encode($annotation->getLookAtPoint());
            $annotationTransformJSON = json_encode($annotation->getAnnotationTransform());
            
            $stmt->bind_param("ssssssssi", $url, $title, $description, 
                              $descriptionLink, $groupName, 
                              $cameraLocationJSON, $lookAtPointJSON, 
                              $annotationTransformJSON, $id);
                              
            if ($stmt->execute() === TRUE) {
                return true;
            } else {
                $this->lastError = $this->connection->error;
                return false;
            }
        } catch(Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        }	
    }

    public function updateGroup(string $currentGroupName, Group $group): bool {
        $query = "UPDATE annotation_group SET group_name = ?, sceneSettings = ?
                  WHERE group_name = ?";

        try {
            $stmt = $this->connection->prepare($query);
            
            $groupName = $group->getGroupName();
            $sceneSettings = $group->getSceneSettings();
            $stmt->bind_param("sss", $groupName, $sceneSettings, $currentGroupName);

            if ($stmt->execute() === TRUE) {
                return true;
            } else {
                $this->lastError = $this->connection->error;
                return false;
            }
        } catch(Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        }	
    }

    public function getHelp(string $endpoint): string {
        $readmeMessage = "For more detailed documentation read the README: " .
                         "https://github.com/MatthewDZane/" . 
                         "AnthropologyAnnotationsAPI/blob/main/README.md";
        switch($endpoint) {
            case "annotations":
                return "GET - Get all of the annotations in the database.\n" .
                       "POST - Inserts a new annotation record into the " . 
                       "database.\n\n" . $readmeMessage;
            case "annotations/byId":
                return "GET - Get the annotation with the given ID.\n" .
                       "PUT - Updates the given group record with the given" .
                       " group data.\n\n" . $readmeMessage;
            case "annotations/byGroup":
                return "GET - Get all the annotations in the given group.\n\n" .
                        $readmeMessage;
            case "annotations/byUrl":
                return "GET - Get all the annotations in the given url.\n\n" .
                        $readmeMessage;
            case "groups":
                return "GET - Get all of the groups in the database.\n" .
                       "POST - Inserts a new group record into the database." .
                       "\n\n" . $readmeMessage;
            case "groups/byGroupName":
                return "GET - Get the group with the given group name.\n" .
                       "PUT - Updates the annotation record with the given " . 
                       "ID with the given annotation data.\n\n" . $readmeMessage;
            case "help":
                return "GET - Get help on the given endpoint. Get the " .
                       "avaiable endpoints if no endpoint is given.\n\n" . 
                       $readmeMessage;           
            case "":
                $valid_endpoints = array("annotations", "annotations/byId",
                                         "annotations/byGroup", 
                                         "annotations/buUrl", "groups",
                                         "groups/byGroupName");
                return "Valid Endpoints = [\"annotations\", " .
                       "\"annotations/byId\", \"annotations/byGroup\"," .
                       "\"annotations/byUrl\", \"groups\", " .
                       "\"groups/byGroupName\"]\n\n" . $readmeMessage;
            default:
                throw new Exception("endpoint (" . $endpoint . 
                                    ") is not valid." );
        }
    }

}