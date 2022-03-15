<?php
class Quaternion implements JsonSerializable {
    protected float $w;
    protected float $x;
    protected float $y;
    protected float $z;

    public function getW(): float { return $this->w; }
    public function getX(): float { return $this->x; }
    public function getY(): float { return $this->y; }
    public function getZ(): float { return $this->z; }

    public function setW(float $w): void { $this->w = $w; }
    public function setX(float $x): void { $this->x = $x; }
    public function setY(float $y): void { $this->y = $y; }
    public function setZ(float $z): void { $this->z = $z; }

    public function __construct(float $w, float $x, float $y, float $z) {
        $this->w = $w;
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function jsonSerialize(): array {
        return [
            "w" => $this->w,
            "x" => $this->x,
            "y" => $this->y,
            "z" => $this->z
        ];
    }

    public static function isValidJson(stdClass|array $json): bool {
        if (is_a($json, "array")) {
            return false;
        }

        return property_exists($json, "w") && property_exists($json, "x") && 
               property_exists($json, "y") && property_exists($json, "z");
    }

    public static function jsonToQuaternion(stdclass $json): Quaternion {
        return new Quaternion($json->w, $json->x, $json->y, $json->z);
    }
}
?>