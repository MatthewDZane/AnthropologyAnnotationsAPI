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

    public function selectGroup(string $groupName): Group {
        $query = "SELECT * FROM annotation_group WHERE group_name = ?";

        $result = null;
        try {
            $stmt = $this->connection->prepare($query);

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            
            $stmt->bind_param("s", $groupName);

            $stmt->execute();

            $result = $stmt->get_result();
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	

        $row = $result->fetch_assoc();

        $group = null;
        try {
            $group = new Group($row['group_name'], $row['sceneSettings']);
        } catch(Exception $e) { }

        return $group;
    }

    public function selectAnnotationsByGroup(string $groupName): array {
        $query = "SELECT * FROM annotation WHERE group_name = ?";

        $result = null;
        try {
            $stmt = $this->connection->prepare($query);

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            
            $stmt->bind_param("s", $groupName);

            $stmt->execute();

            $result = $stmt->get_result();
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	

        $annotations = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $cameraLocation = Position::jsonToPosition($row['camera_location']);
                $cameraLookAtPoint = Position::jsonToPosition($row['camera_look_at_point']);
                $annotationLocation = Position::jsonToPosition($row['annotation_location']);
                
                $annotations[count($annotations)] = 
                    new Annotation($row['id'], $row['url'], $row['title'], 
                                $row['description'], 
                                $row['description_link'], $row['group_name'],
                                $cameraLocation, $cameraLookAtPoint,
                                $annotationLocation, $row['last_updated']);
            }
        }

        return $annotations;
    }

    public function selectAnnotationsById(int $id): array {
        $query = "SELECT * FROM annotation WHERE id = ?";

        $result = null;
        try {
            $stmt = $this->connection->prepare($query);

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            
            $stmt->bind_param("i", $id);

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
                $annotationLocationJson = json_decode($row['annotation_location']);

                $cameraLocation = Position::jsonToPosition($cameraLocationJson);
                $cameraLookAtPoint = Position::jsonToPosition($cameraLookAtPointJson);
                $annotationLocation = Position::jsonToPosition($annotationLocationJson); 

                $annotations[count($annotations)] = 
                    new Annotation($row['id'], $row['url'], $row['title'], 
                                $row['description'], 
                                $row['description_link'], $row['group_name'],
                                $cameraLocation, $cameraLookAtPoint,
                                $annotationLocation, $row['last_updated']);
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
        $annotationLocationJson = json_decode($row['annotation_location']);

        $cameraLocation = Position::jsonToPosition($cameraLocationJson);
        $cameraLookAtPoint = Position::jsonToPosition($cameraLookAtPointJson);
        $annotationLocation = Position::jsonToPosition($annotationLocationJson);
        
        $annotation = new Annotation($row['id'], $row['url'], $row['title'], 
                                      $row['description'], 
                                      $row['description_link'], 
                                      $row['group_name'],
                                      $cameraLocation, $cameraLookAtPoint,
                                      $annotationLocation, 
                                      $row['last_updated']);
        
        return $annotation;
    }

    public function selectAnnotationsByURL(string $url): array {
        $query = "SELECT * FROM annotation WHERE url = ?";

        $result = null;
        try {
            $stmt = $this->connection->prepare($query);

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            
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
                $annotationLocationJson = json_decode($row['annotation_location']);
        
                $cameraLocation = Position::jsonToPosition($cameraLocationJson);
                $cameraLookAtPoint = Position::jsonToPosition($cameraLookAtPointJson);
                $annotationLocation = Position::jsonToPosition($annotationLocationJson);
                
                $annotations[count($annotations)] = 
                    new Annotation($row['id'], $row['url'], $row['title'], 
                                $row['description'], 
                                $row['description_link'], $row['group_name'],
                                $cameraLocation, $cameraLookAtPoint,
                                $annotationLocation, $row['last_updated']);
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
                $annotationLocationJson = json_decode($row['annotation_location']);
        
                $cameraLocation = Position::jsonToPosition($cameraLocationJson);
                $cameraLookAtPoint = Position::jsonToPosition($cameraLookAtPointJson);
                $annotationLocation = Position::jsonToPosition($annotationLocationJson);
                
                $annotations[count($annotations)] = 
                    new Annotation($row['id'], $row['url'], $row['title'], 
                                $row['description'], 
                                $row['description_link'], $row['group_name'],
                                $cameraLocation, $cameraLookAtPoint,
                                $annotationLocation, $row['last_updated']);
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
            annotation_location JSON,
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
    private function insertGroup(Group $group): bool {
        $query = "INSERT INTO annotation_group (group_name, sceneSettings)
                VALUES (?, ?)";

        try {
            $stmt = $this->connection->prepare($query);

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            
            $stmt->bind_param("ss", $group->get_group_name(), $group->get_scene_settings());

            if ($stmt->execute() === TRUE) {
                echo "New Group was added to annotation_group table<br>";
                return true;
            } else {
                echo "Error inserting group: " . $this->connection->error . "<br>";
                return false;
            }
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	
    }

    public function insertAnnotation(Annotation $annotation): bool {
        $query = "INSERT INTO annotation (url, title, description, 
                description_link, group_name, camera_location, 
                camera_look_at_point, annotation_location) VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)";
        
        try {
            $stmt = $this->connection->prepare($query);

            if($stmt === false) {
                $this->lastError = "Unable to do prepared statement: " . $query;
                return false;
            }

            $url = $annotation->getUrl();
            $title = $annotation->getTitle(); 
            $description = $annotation->getDescription();
            $descriptionLink = $annotation->getDescriptionLink();
            $groupName = $annotation->getGroupName();

            # create JSONs for the 3D points
            $cameraLocationJSON = json_encode($annotation->getCameraLocation());

            $lookAtPointJSON = json_encode($annotation->getLookAtPoint());

            $annotationLocationJSON = json_encode($annotation->getAnnotationLocation());

            $stmt->bind_param("ssssssss", $url, $title, $description,
                              $descriptionLink, $groupName,
                              $cameraLocationJSON, $lookAtPointJSON, 
                              $annotationLocationJSON);

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

    private function updateAnnotation(int $id, Annotation $annotation): bool {
        $query = "UPDATE annotation SET url = ?, title = ?, description = ?, 
                description_link = ?, group_name = ?, camera_location = ?,
                camera_look_at_point = ?, annotation_location = ? WHERE id= ?";
        
        try {
            $stmt = $this->connection->prepare($query);

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }

            # create JSONs for the 3D points
            $cameraLocationJSON = json_encode($annotation->getCameraLocation());

            $lookAtPointJSON = json_encode($annotation->getLookAtPoint());

            $annotationLocationJSON = json_encode($annotation->getAnnotationLocation());
            
            $stmt->bind_param("ssssssssi", $annotation->getUrl(), 
                            $annotation->getTitle(), 
                            $annotation->getDescription(),
                            $annotation->getDescriptionLink(),
                            $annotation->getGroupName(),
                            $cameraLocationJSON, $lookAtPointJSON, 
                            $annotationLocationJSON, $id);

            if ($stmt->execute() === TRUE) {
                echo "New Group was added to annotation_group table<br>";
                return true;
            } else {
                echo "Error inserting group: " . $this->connection->error . "<br>";
                return false;
            }
        } catch(Exception $e) {
            throw New Exception($e->getMessage());
        }	
    }
}