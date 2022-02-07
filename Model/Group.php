<?php
class Group implements JsonSerializable {
    private string $groupName;
    private string $sceneSettings;

    function get_group_name(): string { 
        return $this->groupName; 
    }
    
    function get_scene_settings(): string { 
        return $this->sceneSettings; 
    }

    function set_id(string $groupName): void { 
        $this->groupName = $groupName; 
    }

    function set_scene_settings(string $sceneSettings): void { 
        $this->sceneSettings = $sceneSettings; 
    }

    function __construct(string $groupName, string $sceneSettings) {
        $this->groupName = $groupName;
        $this->sceneSettings = $sceneSettings;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "group_name" => $this->groupName,
            "scene_settings" => $this->sceneSettings
        ];
    }
}
?>