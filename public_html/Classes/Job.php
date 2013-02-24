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
        var $tags;
        
        var $type;
        var $health;
        var $priority;
        
        var $related;
        
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
            
            // get deliverable tags
            $this->tags = array();
            $query = "SELECT job, tag FROM tag_job WHERE job=".$t.";";
            $res_t = mysql_query($query);
            if($res_t){
                while ($row_t = mysql_fetch_assoc($res_t)){
                    $this->tags[] = new Tag($row_t['tag']);
                }
            }
            mysql_free_result($res_t);
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
