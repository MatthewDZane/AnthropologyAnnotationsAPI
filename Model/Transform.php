<?php
class Transform implements JsonSerializable {
    protected Quaternion $rotation;
    protected Point $scale;
    protected Point $translation;

    public function getRotation(): Quaternion { return $this->rotation; }
    public function getScale(): Point { return $this->scale; }
    public function getTranslation(): Point { return $this->translation; }

    public function setRotation(Quaternion $rotation): void { 
        $this->rotation = $rotation; 
    }
    public function setScale(Point $scale): void { 
        $this->scale = $scale; 
    }
    public function setTranslation(Point $translation): void { 
        $this->translation = $translation; 
    }

    public function __construct(Quaternion $rotation, Point $scale, 
                                Point $translation) {
        $this->rotation = $rotation;
        $this->scale = $scale; 
        $this->translation = $translation; 
    }

    public function jsonSerialize(): array {
        return [
            "rotation" => $this->rotation->jsonSerialize(),
            "scale" => $this->scale->jsonSerialize(),
            "translation" => $this->translation->jsonSerialize()
        ];
    }

    public static function isValidJson(stdClass|array $json): bool {
        if (is_a($json, "array")) {
            return false;
        }

        return property_exists($json, "rotation") && 
               Quaternion::isValidJson($json->rotation) &&
               property_exists($json, "scale") &&
               Point::isValidJson($json->scale) &&
               property_exists($json, "translation") &&
               Point::isValidJson($json->translation);
    }

    public static function jsonToTransform(stdclass $json): Transform {
        return new Transform(Quaternion::jsonToQuaternion($json->rotation),
                             Point::jsonToPoint($json->scale),
                             Point::jsonToPoint($json->translation));
    }
}
?>