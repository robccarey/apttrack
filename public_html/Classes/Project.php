<?php
    class Project {
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
        private $visibility;
        private $health;
        private $priority;
        
        private $tags;
        private $tasks;
        private $deliverables;
        private $comments;
        private $subscribers;
        
        public function __construct($p){
            
            // get main project content
            $query = "SELECT *,
                DATE_FORMAT(date_start, '%d-%b-%y') as start_format,
                DATE_FORMAT(date_end, '%d-%b-%y') as end_format,
                DATE_FORMAT(created, '%d-%b-%y %H:%i') as created_format,
                DATE_FORMAT(updated, '%d-%b-%y %H:%i') as updated_format
                FROM project WHERE id=".$p." LIMIT 1;";
            $result = mysql_query($query);
            if ($result) {
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
                $this->visibility = new Visibility($row['visibility']);
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
        public function getStatusDescription() {
            return $this->status->getDescription();
        }
        public function getVisibility() {
            return $this->visibility;
        }
        public function getVisibilityID() {
            return $this->visibility->getID();
        }
        public function getVisibilityText() {
            return $this->visibility->getName();
        }
        public function getVisiblityDescription() {
            return $this->visibility->getDescription();
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
                $query = "SELECT id FROM project_comment WHERE project=".$this->id." ORDER BY time DESC;";
                $result = mysql_query($query);
                if ($result) {
                    while ($row = mysql_fetch_assoc($result)) {
                        $this->comments[] = new ProjectComment($row['id']);
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
                $query = "SELECT project, tag FROM tag_project WHERE project=".$this->id.";";
                $result = mysql_query($query);
                if ($result){
                    while ($row = mysql_fetch_assoc($result)) {
                        $this->tags[] = new Tag($row['tag']);
                    }
                } else {
                    unset($this->tags);
                }
                mysql_free_result($result);
            }
            return $this->tags;
        }
        public function getDeliverables() {
            if (!isset($this->deliverables)) {
                $this->deliverables = array();
                $query = "SELECT id FROM job WHERE type=2 AND project=".$this->id.";";
                $result = mysql_query($query);
                if($result){
                    while ($row = mysql_fetch_assoc($result)){
                        $this->deliverables[] = new Deliverable($row['id']);
                    }
                } else {
                    unset($this->deliverables);
                }
                mysql_free_result($result);
            }
            return $this->deliverables;
        }
        public function getTasks() {
            if (!isset($this->tasks)) {
                $this->tasks = array();
                $qry_tasks = "SELECT id FROM job WHERE type=1 AND project=".$this->id.";";
                $res_tasks = mysql_query($qry_tasks);
                if($res_tasks){
                    while ($row_tasks = mysql_fetch_assoc($res_tasks)){
                        $this->tasks[] = new Task($row_tasks['id']);
                    }
                } else {
                    unset($this->tasks);
                }
                mysql_free_result($res_tasks);
            }
            return $this->tasks;
        }
        public function getSubscribers() {
            if (!isset($this->subscribers)) {
                $this->subscribers = array();
                $query = "SELECT id FROM project_user WHERE project=".$this->id.";";
                $result = mysql_query($query);
                if ($result) {
                    while ($row = mysql_fetch_assoc($result)) {
                        $this->subscribers[] = new User($row['user']);
                    }
                    mysql_free_result($result);
                } else {
                    unset($this->subscribers);
                }
            }
            return $this->subscribers;
        }
        public function userCanRead($userID) {
            $query = "SELECT COUNT(*) as res FROM project_user WHERE project=".$this->id." AND user=".$userID.";";
            $result = mysql_query($query);
            if ($result) {
                if (mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_assoc($result);
                    if ($row['res'] === '0') {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
                mysql_free_result($result);
            } else {
                return false;
            }
        }
        public function userCanEdit($userID) {
            $query = "SELECT COUNT(*) as res FROM project_user WHERE project=".$this->id." AND user=".$userID." AND can_edit=1;";
            $result = mysql_query($query);
            if($result) {
                if (mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_assoc($result);
                    if ($row['res'] === '0') {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
                mysql_free_result($result);
            } else {
                return false;
            }
        }
            
    }
?>
