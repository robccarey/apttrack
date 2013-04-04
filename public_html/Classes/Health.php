<?php

class Health {

    private $id;
    private $name;
    private $description;

    public function __construct($id) {
        $query = "SELECT * FROM health WHERE id=" . $id . " LIMIT 1;";
        $result = mysql_query($query);
        if ($result) {
            $row = mysql_fetch_assoc($result);
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->description = $row['description'];
            mysql_free_result($result);
        }
    }

    public function getID() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

}

?>
