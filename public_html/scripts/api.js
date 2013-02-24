
// TODO: update IP of api
var URL = 'http://rcarey.co.uk/api.php';
//var URL = 'http://localhost/api.php';

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

function ajaxError(xhr, status, error, message) {
    console.log("Error: " + xhr.status + " " + xhr.statusText + ": " + message);
    $('#popupError').html('<h4>Server Error</h4><p>'+message+'</p>');
    $( "#popupError" ).popup( "open" );
}