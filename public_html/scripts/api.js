
var URL = 'api.php';

function updateNotificationSettings() {
        $.ajax({
            url: URL,
            data: {
                method: 'settingsNotifications',
                notProjAdd: document.getElementById('notProjAdd').value,
                notTaskAdd: document.getElementById('notTaskAdd').value,
                notProjDead: document.getElementById('notProjDead').value,
                notProjOdue: document.getElementById('notProjOdue').value },
            type: 'POST',
            dataType: 'text',
            success: function(result) {
                //alert(result);
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Problem updating notification settings.');
            }
        });
}

function createNewProject() {
    $.ajax({
        url: URL,
        data: {
            method: 'newProject' },
        type: 'GET',
        dataType: 'text',
        success: function(result){
            window.location.href = "project.php?id="+result+"&mode=edit";
        },
        error: function(xhr, status, error) {
            ajaxError(xhr, status, error, 'Problem creating new project.');
        }
    });
}

function createNewJob(t) {
    var type;
    if (t == 't') {
        type = 'task';
    } else if (t == 'd') {
        type = 'deliv';
    }
    
    $.ajax({
        url:    URL,
        data:   {
            method: 'newJob',
            type:   type,
            project: document.getElementById('projID').value },
        type:   'GET',
        dataType: 'text',
        success: function(result){
            window.location.href = "job.php?id="+result+"&mode=edit";
        },
        error: function(xhr, status, error) {
            ajaxError(xhr, status, error, 'Problem creating new')
        }
    });
}

function updateProject(alert) {
    console.log('Starting update...');
    
    id = document.getElementById('projID').value;
    title = document.getElementById('projTitle').value;
    desc = document.getElementById('projDesc').value;
    owner = document.getElementById('projOwner').value;
    start = document.getElementById('projStart').value;
    end = document.getElementById('projEnd').value;
    stat = document.getElementById('projStatus').value;
    visib = document.getElementById('projVis').value;
    health = document.getElementById('projHealth').value;
    priority = document.getElementById('projPri').value;
    
    $.ajax({
        url: URL,
        data: {
            method: 'updateProject',
            pID: id,
            pTitle: title,
            pDesc: desc,
            pOwner: owner,
            pStart: start,
            pEnd: end,
            pStatus: stat,
            pVisib: visib,
            pHealth: health,
            pPriority: priority },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            if (alert) {    
                showAlert('Success!', 'Your changes have been saved.');
            }
            console.log('\tDone.');
        },
        error: function(xhr, status, error) {
            ajaxError(xhr, status, error, 'Problem updating project.');
        }
    });
}

function updateJob(alert) {
    console.log('Starting update...');
    
    id = document.getElementById('jobID').value;
    title = document.getElementById('jobTitle').value;
    desc = document.getElementById('jobDesc').value;
    owner = document.getElementById('jobOwner').value;
    start = document.getElementById('jobStart').value;
    end = document.getElementById('jobEnd').value;
    stat = document.getElementById('jobStatus').value;
    health = document.getElementById('jobHealth').value;
    priority = document.getElementById('jobPri').value;
    
    $.ajax({
        url: URL,
        data: {
            method: 'updateJob',
            jID: id,
            jTitle: title,
            jDesc: desc,
            jOwner: owner,
            jStart: start,
            jEnd: end,
            jStatus: stat,
            jHealth: health,
            jPriority: priority },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            if (alert) {    
                showAlert('Success!', 'Your changes have been saved.');
            }
            console.log('\tDone.');
        },
        error: function(xhr, status, error) {
            ajaxError(xhr, status, error, 'Problem updating item.');
        }
    });
}

function ajaxError(xhr, status, error, message) {
    console.log("Error: " + xhr.status + " " + xhr.statusText + ": " + message);
    showError('Server Error:', message);
}

function showAlert(title, message) {
    $('#popupAlert').html('<h4>' + title + '</h4><p>' + message + '</p>');
    $('#popupAlert').popup('open');
    setTimeout(function() {
        $('#popupAlert').popup('close');
    }, 3000)
}

function showError(title, message) {
    $('#popupError').html('<h4>' + title + '</h4><p>' + message + '</p>');
    $('#popupError').popup('open');
    setTimeout(function() {
        $('#popupError').popup('close');
    }, 3000)
}

