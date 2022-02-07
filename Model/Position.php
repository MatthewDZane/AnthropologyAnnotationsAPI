<?php
class Position implements JsonSerializable {
    protected float $x;
    protected float $y;
    protected float $z;

    public function getX(): float { return $this->x; }
    public function getY(): float { return $this->y; }
    public function getZ(): float { return $this->z; }

    public function setX(float $x): void { $this->x = $x; }
    public function setY(float $y): void { $this->y = $y; }
    public function setZ(float $z): void { $this->z = $z; }

    public function __construct(float $x, float $y, float $z) {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public static function jsonToPosition(string $positionJSON): Position {
        $position = json_decode($positionJSON)->position;
        
        return new Position((float)$position->x, (float)$position->y, (float)$position->z);
    }

    public function jsonSerialize() {
        return [
            "x" => $this->x,
            "y" => $this->y,
            "z" => $this->z
        ];
    }
}
?>