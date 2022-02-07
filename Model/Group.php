<?php
class Group implements JsonSerializable {
    private string $groupName;
    private string $sceneSettings;

    function getGroupName(): string { 
        return $this->groupName; 
    }
    
    function getSceneSettings(): string { 
        return $this->sceneSettings; 
    }

    function setId(string $groupName): void { 
        $this->groupName = $groupName; 
    }

    function setSceneSettings(string $sceneSettings): void { 
        $this->sceneSettings = $sceneSettings; 
    }

    function __construct(string $groupName, string $sceneSettings) {
        $this->groupName = $groupName;
        $this->sceneSettings = $sceneSettings;
    }

    public function jsonSerialize(): array
    {
        return [
            "group_name" => $this->groupName,
            "scene_settings" => $this->sceneSettings
        ];
    }

    public static function isValidJson(stdClass|array $json): bool {
        if (is_a($json, "array")) {
            return false;
        }

        return property_exists($json, "group_name") && 
               property_exists($json, "scene_settings");
    }

    public static function jsonToGroup(stdclass $json): Group {
        return new Group($json->group_name, $json->scene_settings);
    }
}
?>