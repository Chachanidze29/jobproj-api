<?php

namespace services;

abstract class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct($data)
    {
        $this->sku = $data->sku;
        $this->name = $data->name;
        $this->price = $data->price;
        $this->type = $data->type;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function __toString()
    {
        return $this->getSku().' '.$this->getName().' '.$this->getPrice().' '.$this->getType();
    }
}

class DVD extends Product {
    protected $size;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->size = $data->size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function __toString()
    {
        return parent::__toString().' '.$this->getSize();
    }
}

class Furniture extends Product {
    protected $height;
    protected $width;
    protected $length;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->height = $data->height;
        $this->width = $data->width;
        $this->length = $data->length;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getDimensions() {
        return $this->getHeight().'X'.$this->getLength().'X'.$this->getWidth();
    }

    public function __toString()
    {
        return parent::__toString().' '.$this->getDimensions();
    }
}

class Book extends Product {
    protected $weight;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->weight = $data->weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function __toString()
    {
        return parent::__toString().' '.$this->getWeight();
    }
}

class ProductService {
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getProducts() {
        $stmt = $this->conn->prepare(
            'SELECT P.sku,P.name,P.price,D.size,PT.type_name from products P
            INNER JOIN dvd D ON P.sku=D.sku
            LEFT JOIN product_types PT ON P.type_id=PT.type_id'
                                        );
        $stmt->execute();
        $dvds = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmt = $this->conn->prepare('
            SELECT P.sku,P.name,P.price,F.width,F.length,F.height,PT.type_name from products P
            INNER JOIN furniture F ON P.sku=F.sku
            LEFT JOIN product_types PT ON P.type_id=PT.type_id
                                        ');
        $stmt->execute();
        $furnitures = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmt = $this->conn->prepare('SELECT P.sku,P.name,P.price,B.weight,PT.type_name from products P
                                        INNER JOIN book B ON P.sku=B.sku
                                        LEFT JOIN product_types PT ON P.type_id=PT.type_id
                                        ');
        $stmt->execute();
        $books = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return json_encode(array_merge($dvds,$furnitures,$books));
    }

    public function deleteProducts($skus) {
        $skus = implode("','", $skus);
        $stmt = $this->conn->prepare("DELETE FROM products WHERE sku IN ('".$skus."')");
        $stmt->execute();
    }

    public function insert($data,$type) {
        $stmt = $this->conn->prepare('SELECT * FROM products WHERE sku=:sku');
        $stmt->bindValue(':sku',$data->sku);
        $stmt->execute();
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($product) {
            return 'Product With Such Sku Already Exists';
        }
        $insertMethod = 'insert'.$type;;
        $className = __NAMESPACE__.'\\'.$type;
        $obj = new $className($data);
        return $this->$insertMethod($obj);
    }

    public function insertProduct(Product $obj,$typeId) {
        $stmt = $this->conn->prepare("INSERT INTO products (sku,type_id,name,price) values(:sku,:type_id,:name,:price)");
        $stmt->bindValue(':sku',$obj->getSku());
        $stmt->bindValue(':type_id',$typeId);
        $stmt->bindValue(':name',$obj->getName());
        $stmt->bindValue(':price',$obj->getPrice());

        $stmt->execute();
    }

    public function insertDVD(DVD $dvd) {
        $typeId = 1;
        $this->insertProduct($dvd,$typeId);

        $stmt = $this->conn->prepare("INSERT INTO dvd (sku,type_id,size) values(:sku,:type_id,:size)");
        $stmt->bindValue(':sku',$dvd->getSku());
        $stmt->bindValue(':type_id',$typeId);
        $stmt->bindValue(':size',$dvd->getSize());

        return $stmt->execute();
    }

    public function insertFurniture(Furniture $furniture) {
        $typeId = 2;
        $this->insertProduct($furniture,$typeId);

        $stmt = $this->conn->prepare("INSERT INTO furniture (sku,type_id,length,width,height) values(:sku,:type_id,:length,:width,:height)");
        $stmt->bindValue(':sku',$furniture->getSku());
        $stmt->bindValue(':type_id',$typeId);
        $stmt->bindValue(':length',$furniture->getLength());
        $stmt->bindValue(':width',$furniture->getWidth());
        $stmt->bindValue(':height',$furniture->getHeight());

        return $stmt->execute();
    }

    public function insertBook(Book $book) {
        $typeId = 3;
        $this->insertProduct($book,$typeId);

        $stmt = $this->conn->prepare("INSERT INTO book (sku,type_id,weight) values(:sku,:type_id,:weight)");
        $stmt->bindValue(':sku',$book->getSku());
        $stmt->bindValue(':type_id',$typeId);
        $stmt->bindValue(':weight',$book->getWeight());

        return $stmt->execute();
    }
}