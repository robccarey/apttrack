
var URL = 'api.php';

// edit related jobs handlers
$('#edrel').on('show', function() { searchRelated(); })
$('#edrel').on('hidden', function() { var relSearch = document.getElementById("relSearch"); relSearch.value = ""; })

// edit job tag handlers
$('#editjobtags').on('show', function() { searchJobTag(); })
$('#editjobtags').on('hidden', function() { var tagSearch = document.getElementById("tagSearch"); tagSearch.value = ""; })

// edit project tag handlers
$('#editprojtags').on('show', function() { searchProjTag(); })
$('#editprojtags').on('hidden', function() { var tagSearch = document.getElementById("tagSearch"); tagSearch.value = ""; })

// edit project personnel handlers
$('#editpersonnel').on('show', function() { searchPersonnel(); })
$('#editpersonnel').on('hidden', function() { var perSearch = document.getElementById("personnelSearch"); perSearch.value = ""; })

function searchRelated() {
    
    term = document.getElementById('relSearch').value;
    jid = document.getElementById('jobID').value;
    
    $.ajax({
        url: URL,
        data: {
            method: 'relatedSearch',
            term: term,
            jid: jid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#relResults').html(result);
        },
        error: function(xhr, status, error) {
            $('#relResults').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong communicating with the server.</div>')
        }
    });
}
function relatedToggle(num, state) {
    jid = document.getElementById('jobID').value;
    
    $.ajax({
        url: URL,
        data: {
            method: 'toggleRelated',
            jid: jid,
            rid: num,
            type: state },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#jobrelcont').html(result);
        },
        error: function(xhr, status, error) {
            $('#jobrelcont').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong communicating with the server.</div>');
        }
    });
    
    searchRelated();
}

function addJobTag() {
    tag = document.getElementById('newTag').value;
    $.ajax({
        url: URL,
        data: {
            method: 'addTag',
            tag: tag },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            jobTagToggle(result, false);
        },
        error: function(xhr, status, error) {
            $('#addTagRes').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong adding a new tag.</div>')
        }
    });
    
}

function searchJobTag() {
    term = document.getElementById('tagSearch').value;
    jid = document.getElementById('jobID').value;
    
    $.ajax({
        url: URL,
        data: {
            method: 'jobTagSearch',
            term: term,
            jid: jid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#tagResults').html(result);
        },
        error: function(xhr, status, error) {
            $('#tagResults').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong communicating with the server.</div>')
        }
    });
}
function jobTagToggle(num, state) {
    jid = document.getElementById('jobID').value;
    
    $.ajax({
        url: URL,
        data: {
            method: 'toggleJobTag',
            jid: jid,
            tag: num,
            type: state },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#tagCont').html(result);
        },
        error: function(xhr, status, error) {
            $('#tagCont').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong communicating with the server.</div>');
        }
    });
    
    searchJobTag();
}

function addProjTag() {
    tag = document.getElementById('newTag').value;
    $.ajax({
        url: URL,
        data: {
            method: 'addTag',
            tag: tag },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            projTagToggle(result, false);
        },
        error: function(xhr, status, error) {
            $('#addTagRes').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong adding a new tag.</div>')
        }
    });
}

function searchProjTag() {
    term = document.getElementById('tagSearch').value;
    pid = document.getElementById('projID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'projTagSearch',
            term: term,
            pid: pid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#tagResults').html(result);
        },
        error: function(xhr, status, error) {
            $('#tagResults').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong communicating with the server.</div>')
        }
    });
}
function projTagToggle(num, state) {
    pid = document.getElementById('projID').value;
    
    $.ajax({
        url: URL,
        data: {
            method: 'toggleProjTag',
            pid: pid,
            tag: num,
            type: state },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#tagCont').html(result);
        },
        error: function(xhr, status, error) {
            $('#tagCont').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong communicating with the server.</div>');
        }
    });
    searchProjTag();
}

function searchPersonnel() {
    term = document.getElementById('personnelSearch').value;
    pid = document.getElementById('projID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'searchPersonnel',
            term: term,
            pid: pid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#personnelResults').html(result);
        },
        error: function(xhr, status, error) {
            $('#personnelResults').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong searching personnel.</div>')
        }
    });
}

function addPerson(uid) {
    pid = document.getElementById('projID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'addProjPerson',
            uid: uid,
            pid: pid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            searchPersonnel();
        },
        error: function(xhr, status, error) {
            $('#personnelResults').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong adding the person.</div>')
        }
    });
    
}

function removePerson(uid) {
    pid = document.getElementById('projID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'remProjPerson',
            uid: uid,
            pid: pid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            searchPersonnel();
        },
        error: function(xhr, status, error) {
            $('#personnelResults').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong adding the person.</div>')
        }
    });
}

function togglePersonEdit(uid, state) {
    pid = document.getElementById('projID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'togProjPerson',
            uid: uid,
            pid: pid,
            state: state },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            searchPersonnel();
        },
        error: function(xhr, status, error) {
            $('#personnelResults').html('<div class="alert alert-error"><strong>Error!</strong> Something went wrong modifying priviliges.</div>')
        }
    });
}