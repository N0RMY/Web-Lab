function findMaxMin($numbers) {
    return [
        "max" => max($numbers),
        "min" => min($numbers)
    ];
}

function extractEmails($text) {
    preg_match_all('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $text, $matches);
    return $matches[0];
}

function sumNestedArray($array) {
    $sum = 0;
    foreach ($array as $value) {
        if (is_array($value)) {
            $sum += sumNestedArray($value);
        } elseif (is_numeric($value)) {
            $sum += $value;
        }
    }
    return $sum;
}

class Rectangle {
    private $width;
    private $height;

    public function __construct($w = null, $h = null) {
        if ($w) $this->setWidth($w);
        if ($h) $this->setHeight($h);
    }

    public function setWidth($width) {
        if ($width <= 0) throw new Exception("Ширина має бути > 0");
        $this->width = $width;
    }

    public function setHeight($height) {
        if ($height <= 0) throw new Exception("Висота має бути > 0");
        $this->height = $height;
    }

    public function calculateArea() {
        return $this->width * $this->height;
    }

    public function calculatePerimeter() {
        return 2 * ($this->width + $this->height);
    }
}

class Square extends Rectangle {
    public function __construct($side = null) {
        if ($side) $this->setSide($side);
    }

    public function setSide($side) {
        if ($side <= 0) throw new Exception("Сторона має бути > 0");
        $this->setWidth($side);
        $this->setHeight($side);
    }

    public function calculatePerimeter() {
        return 4 * $this->getWidth();
    }
}

interface Shape {
    public function calculateArea();
    public function calculatePerimeter();
}

class Circle implements Shape {
    private $radius;
    public function __construct($radius) {
        if ($radius <= 0) throw new Exception("Радіус має бути > 0");
        $this->radius = $radius;
    }
    public function calculateArea() {
        return round(pi() * $this->radius * $this->radius, 2);
    }
    public function calculatePerimeter() {
        return round(2 * pi() * $this->radius, 2);
    }
}