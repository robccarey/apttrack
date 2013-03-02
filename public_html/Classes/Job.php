<?php
    class Job {
        
        var $id;
        var $name;
        var $description;
        var $owner;
        var $creator;
        var $created;
        var $date_start;
        var $date_end;
        var $updater;
        var $updated;
        var $status;
        var $project;
        var $type;
        var $health;
        var $priority;
        
        var $tags;
        var $related;
        var $comments;
        
        function __construct($t){
            
            // get main task stuff
            $query = "SELECT * FROM job WHERE id=".$t.";";
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
            }
            mysql_free_result($result);
            
        }
        function getComments() {
            $this->comments = array();
            $query = "SELECT id FROM job_comment WHERE job=".$this->id." ORDER BY time;";
            $result = mysql_query($query);
            if ($result) {
                while ($row = mysql_fetch_assoc($result)) {
                    $this->comments[] = new JobComment($row['id']);
                }
            }
        }
        
        function getTags() {
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
            }
        }
        
        function getRelated() {
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
            }
        }
    }
?>
