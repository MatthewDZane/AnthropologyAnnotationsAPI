<?php
class Transform implements JsonSerializable {
    protected Quaternion $rotation;
    protected Point $scale3D;
    protected Point $translation;

    public function getRotation(): Quaternion { return $this->rotation; }
    public function getScale3D(): Point { return $this->scale; }
    public function getTranslation(): Point { return $this->translation; }

    public function setRotation(Quaternion $rotation): void { 
        $this->rotation = $rotation; 
    }
    public function setScale3D(Point $scale3D): void { 
        $this->scale3D = $scale3D; 
    }
    public function setTranslation(Point $translation): void { 
        $this->translation = $translation; 
    }

    public function __construct(Quaternion $rotation, Point $scale3D, 
                                Point $translation) {
        $this->rotation = $rotation;
        $this->scale3D = $scale3D; 
        $this->translation = $translation; 
    }

    public function jsonSerialize(): array {
        return [
            "rotation" => $this->rotation->jsonSerialize(),
            "scale3D" => $this->scale3D->jsonSerialize(),
            "translation" => $this->translation->jsonSerialize()
        ];
    }

    public static function isValidJson(stdClass|array $json): bool {
        if (is_a($json, "array")) {
            return false;
        }

        return property_exists($json, "rotation") && 
               Quaternion::isValidJson($json->rotation) &&
               property_exists($json, "scale3D") &&
               Point::isValidJson($json->scale3D) &&
               property_exists($json, "translation") &&
               Point::isValidJson($json->translation);
    }

    public static function jsonToTransform(stdclass $json): Transform {
        return new Transform(Quaternion::jsonToQuaternion($json->rotation),
                             Point::jsonToPoint($json->scale3D),
                             Point::jsonToPoint($json->translation));
    }
}
?>