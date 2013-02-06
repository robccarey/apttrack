
// TODO: update IP of api
var URL = 'http://86.129.3.201/api.php';

function updateNotificationSettings() {
	console.log("called.");
        
        $.ajax({
            url: URL,
            data: {
                method: 'settingsNotifications',
                notProjAdd: document.getElementById('notProjAdd').value,
                notTaskAdd: document.getElementById('notTaskAdd').value,
                notProjDead: document.getElementById('notProjDead').value,
                notProjOdue: document.getElementById('notProjOdue').value },
            type: 'POST',
            dataType: 'json'
        }).done(function(data) {
            console.log(data);
        }).fail(function(data){
            //show_notice(data.responseText, 'error');
        });
        
        
        
	//$.getJSON(url, function(json) {
	//	console.log('now here.');
	///	var output = [];
//
//		titles = json.titles;
//
//		for (var i = 0, len = titles.length; i < len; i++) {
//			output.push('<option value="'+titles[i].id+'">'+titles[i].title+'</option>');
//			//<option value="4">Dr</option>
//			console.log('title');
//		}
//
//		$("#title").html(output.join(''));
//		$("#title").selectmenu('refresh');

//	});
//	console.log('done');
}