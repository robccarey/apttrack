<?php
    class Job {
        
        private $id;
        private $name;
        private $description;
        private $owner;
        private $creator;
        private $created;
        private $date_start;
        private $date_end;
        
        private $start_format;
        private $end_format;
        private $created_format;
        private $updated_format;
        
        private $updater;
        private $updated;
        private $status;
        private $project;
        private $type;
        private $health;
        private $priority;
        
        private $tags;
        private $related;
        private $comments;
        
        public function __construct($t){
            
            // get main task stuff
            $query = "SELECT *,
                DATE_FORMAT(date_start, '%d-%b-%y') as start_format,
                DATE_FORMAT(date_end, '%d-%b-%y') as end_format,
                DATE_FORMAT(created, '%d-%b-%y %H:%i') as created_format,
                DATE_FORMAT(updated, '%d-%b-%y %H:%i') as updated_format
                FROM job WHERE id=".$t." LIMIT 1;";
            $result = mysql_query($query);
            if($result){
                $row = mysql_fetch_assoc($result);
                
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->description = $row['description'];
                $this->owner = new User($row['owner']);
                $this->creator = new User($row['creator']);
                $this->created = $row['created'];
                $this->date_start = $row['date_start'];
                $this->date_end = $row['date_end'];
                $this->updater = new User($row['updater']);
                $this->updated = $row['updated'];
                $this->status = new Status($row['status']);
                $this->project = $row['project'];
                $this->type = new JobType($row['type']);
                $this->health = new Health($row['health']);
                $this->priority = new Priority($row['priority']);
                
                $this->start_format = $row['start_format'];
                $this->end_format = $row['end_format'];
                $this->updated_format = $row['updated_format'];
                $this->created_format = $row['created_format'];
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
        public function getOwner() {
            return $this->owner;
        }
        public function getOwnerID() {
            return $this->owner->getID();
        }
        public function getOwnerFullName() {
            return $this->owner->getFullName();
        }
        public function getOwnerEmail() {
            return $this->owner->getEmail();
        }
        public function getCreator() {
            return $this->creator;
        }
        public function getCreatorID() {
            return $this->creator->getID();
        }
        public function getCreatorFullName() {
            return $this->creator->getFullName();
        }
        public function getCreatorEmail() {
            return $this->creator->getEmail();
        }
        public function getCreated($format = null) {
            if (isset($format)) {
                return $this->created_format;
            } else {
                return $this->created;
            }
        }
        public function getStartDate($format = null) {
            if (isset($format)) {
                return $this->start_format;
            } else {
                return $this->date_start;
            }
        }
        public function getEndDate($format = null) {
            if (isset($format)) {
                return $this->end_format;
            } else {
                return $this->date_end;
            }
        }
        public function getUpdater() {
            return $this->updater;
        }
        public function getUpdaterID() {
            return $this->updater->getID();
        }
        public function getUpdaterFullName() {
            return $this->updater->getFullName();
        }
        public function getUpdaterEmail() {
            return $this->updater->getEmail();
        }
        public function getUpdated($format = null) {
            if (isset($format)) {
                return $this->updated_format;
            } else {
                return $this->updated;
            }
        }
        public function getStatus() {
            return $this->status;
        }
        public function getStatusID() {
            return $this->status->getID();
        }
        public function getStatusText() {
            return $this->status->getName();
        }
        public function getStatusDesription() {
            return $this->status->getDescription();
        }
        public function getProjectID() {
            return $this->project;
        }
        public function getType() {
            return $this->type;
        }
        public function getTypeID() {
            return $this->type->getID();
        }
        public function getTypeText() {
            return $this->type->getName();
        }
        public function getHealth() {
            return $this->health;
        }
        public function getHealthID() {
            return $this->health->getID();
        }
        public function getHealthText() {
            return $this->health->getName();
        }
        public function getHealthDescription() {
            return $this->health->getDescription();
        }
        public function getPriority() {
            return $this->priority;
        }
        public function getPriorityID() {
            return $this->priority->getID();
        }
        public function getPriorityText() {
            return $this->priority->getName();
        }
        public function getComments() {
            if (!isset($this->comments)) {
                $this->comments = array();  
                $query = "SELECT id FROM job_comment WHERE job=".$this->id." ORDER BY time DESC;";
                $result = mysql_query($query);
                if ($result) {
                    while ($row = mysql_fetch_assoc($result)) {
                        $this->comments[] = new JobComment($row['id']);
                    }
                } else {
                    unset($this->comments);
                }
            }
            return $this->comments;
        }
        public function getTags() {
            if (!isset($this->tags)) {
                $this->tags = array();
                $query = "SELECT job, tag FROM tag_job WHERE job=".$t.";";
                $result = mysql_query($query);
                if($result){
                    if (mysql_num_rows($result) > 0) {
                        while ($row_t = mysql_fetch_assoc($res_t)){
                            $this->tags[] = new Tag($row_t['tag']);
                        }
                    }
                    mysql_free_result($result);
                } else {
                    unset($this->tags);
                }
            }
            return $this->tags;
        }
        public function getRelated() {
            if (!isset($this->related)) {
                $this->related = array();
                $query = "SELECT * FROM job_link WHERE aid=".$this->id." OR bid=".$this->id.";";
                $result = mysql_query($query);
                if ($result) {
                    while ($row = mysql_fetch_assoc($result)) {
                        $r = null;
                        if ($row['aid'] == $this->id) {
                            $r = $row['bid'];
                        } else {
                            $r = $row['aid'];
                        }

                        $this->related[] = new Job($r);
                    }
                    mysql_free_result($result);
                } else {
                    unset($this->related);
                }
            }
            return $this->related;
        }
    }
?>