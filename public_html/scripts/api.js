
var URL = 'api.php';

// edit related jobs handlers
$('#edrel').on('show', function() { searchRelated(); });
$('#edrel').on('hidden', function() { var relSearch = document.getElementById("relSearch"); relSearch.value = ""; });

// edit job tag handlers
$('#editjobtags').on('show', function() { searchJobTag(); });
$('#editjobtags').on('hidden', function() { var tagSearch = document.getElementById("tagSearch"); tagSearch.value = ""; });

// edit project tag handlers
$('#editprojtags').on('show', function() { searchProjTag(); });
$('#editprojtags').on('hidden', function() { var tagSearch = document.getElementById("tagSearch"); tagSearch.value = ""; });

// edit project personnel handlers
$('#editpersonnel').on('show', function() { searchPersonnel(); });
$('#editpersonnel').on('hidden', function() { var perSearch = document.getElementById("personnelSearch"); perSearch.value = ""; });

// edit report sorting handlers
$('#editreportsort').on('show', function() { repGetSortList(); });
$('#editreportsort').on('hidden', function() { refreshReportViewTable(); });

function deleteSession(s) {
    
    if (confirm('Are you sure you want to end the selected session?')) {
        
        $.ajax({
            url: URL,
            data: {
                method: 'deleteSession',
                sid: s },
            type: 'POST',
            dataType: 'text',
            success: function(result) {
                showSuccess('#msgbox', 'Session removed. To use that browser again you will need to provide a valid email and password combination.');
                updateSessions();
            },
            error: function(xhr, status, error) {
                showError('#msgbox', 'Something went wrong communicating with the server.');
            }
        });
    }
}

function updateSessions() {
    $.ajax({
        url: URL,
        data: {
            method: 'updateSessions' },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#sessionTab').html(result);
        },
        error: function(xhr, status, error) {
            showError('#msgbox','Could not retrieve an updated session list from the server.');
        }
    });
}

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
            showError('#relResults','Something went wrong communicating with the server.');
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
            showError('#jobrelcont','Something went wrong communicating with the server.');
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
            showError('#addTagRes', 'Something went wrong adding a new tag.');
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
            showError('#tagResults','Something went wrong communicating with the server.');
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
            showError('#tagCont', 'Something went wrong communicating with the server.');
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
            showError('#addTagRes', 'Something went wrong adding a new tag.');
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
            showError('#tagResults', 'Something went wrong communicating with the server.');
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
            showError('#tagCont', 'Something went wrong communicating with the server.');
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
            showError('#personnelResults', 'Something went wrong searching personnel.');
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
            showError('#personnelResults', 'Something went wrong adding the person.');
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
            showError('#personnelResults', 'Something went wrong removing the person.');
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

function deleteJob() {
    if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
        // delete it
        jid = document.getElementById('jobID').value;
        $.ajax({
            url: URL,
            data: {
                method: 'deleteJob',
                jid: jid },
            type: 'POST',
            dataType: 'text',
            success: function(result) {
                alert('Item successfully deleted.')
                proj = document.getElementById('projectID').value;
                window.location.replace("project.php?id="+proj);
            },
            error: function(xhr, status, error) {
                alert('Error: Could not delete item.');
            }
        });
    }
}

function deleteProject() {
    if (confirm('Are you sure you want to delete this project? This action cannot be undone.')) {
        // delete it
        pid = document.getElementById('projID').value;
        $.ajax({
            url: URL,
            data: {
                method: 'deleteProject',
                pid: pid },
            type: 'POST',
            dataType: 'text',
            success: function(result) {
                alert('Item successfully deleted.');
                window.location.replace("projects.php");
            },
            error: function(xhr, status, error) {
                alert('Error: Could not delete project.');
            }
        });
    }
}

function refreshReportViewTable() {
    rid = document.getElementById('repID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'refreshReportViewTable',
            rid: rid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#repViewTab').html(result);
        },
        error: function(xhr, status, error) {
            $('#repViewTab').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repSetLabel(fid) {
    rid = document.getElementById('repID').value;
    label = document.getElementById('fldLabel'+fid).value;
    $.ajax({
        url: URL,
        data: {
            method: 'repSetLabel',
            rid: rid,
            fid: fid,
            label: label },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            refreshReportViewTable();
        },
        error: function(xhr, status, error) {
            $('#repViewTab').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repSetVisib(fid, state) {
    rid = document.getElementById('repID').value;
    
    if (state) {
        visib = '0';
    } else {
        visib = '1';
    }
    
    $.ajax({
        url: URL,
        data: {
            method: 'repSetVisib',
            rid: rid,
            fid: fid,
            visib: visib },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            refreshReportViewTable();
        },
        error: function(xhr, status, error) {
            $('#repViewTab').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repSetSort(fid) {
    rid = document.getElementById('repID').value;
    sort = document.getElementById('fldSort'+fid).value;
    
    $.ajax({
        url: URL,
        data: {
            method: 'repSetSort',
            rid: rid,
            fid: fid,
            sort: sort },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            refreshReportViewTable();
        },
        error: function(xhr, status, error) {
            $('#repViewTab').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repMoveFieldDown(fid) {
    rid = document.getElementById('repID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'repMoveFieldRight',
            rid: rid,
            fid: fid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            refreshReportViewTable();
        },
        error: function(xhr, status, error) {
            $('#repViewTab').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repMoveFieldUp(fid) {
    rid = document.getElementById('repID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'repMoveFieldLeft',
            rid: rid,
            fid: fid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            refreshReportViewTable();
        },
        error: function(xhr, status, error) {
            $('#repViewTab').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repGetSortList() {
    rid = document.getElementById('repID').value;
    
    $.ajax({
        url: URL,
        data: {
            method: 'repGetSortList',
            rid: rid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#edrepcont').html(result);
        },
        error: function(xhr, status, error) {
            $('#edrepcont').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repMoveSortDown(fid) {
    rid = document.getElementById('repID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'repMoveSortRight',
            rid: rid,
            fid: fid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            repGetSortList();
        },
        error: function(xhr, status, error) {
            $('#repViewTab').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repMoveSortUp(fid) {
    rid = document.getElementById('repID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'repMoveSortLeft',
            rid: rid,
            fid: fid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            repGetSortList();
        },
        error: function(xhr, status, error) {
            $('#repViewTab').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repRemoveField(fid) {
    rid = document.getElementById('repID').value;
    if (confirm('Remove this field?')) {
        $.ajax({
            url: URL,
            data: {
                method: 'repRemoveField',
                rid: rid,
                fid: fid },
            type: 'POST',
            dataType: 'text',
            success: function(result) {
                refreshReportViewTable();
            },
            error: function(xhr, status, error) {
                $('#repViewTab').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
            }
        });
    }
}

function repAddField() {
    rid = document.getElementById('repID').value;
    fid = document.getElementById('newRepField').value;
    
    $.ajax({
        url: URL,
        data: {
            method: 'repAddField',
            rid: rid,
            fid: fid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            refreshReportViewTable();
        },
        error: function(xhr, status, error) {
            $('#repViewTab').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repUpdCritModal(fid) {
    rid = document.getElementById('repID').value;
    $.ajax({
        url: URL,
        data: {
            method: 'repGetCritContent',
            rid: rid,
            fid: fid },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#edcritcont').html(result);
        },
        error: function(xhr, status, error) {
            $('#edcritcont').html('<div class="alert alert-error"><strong>Error!</strong> Could not refresh data.</div>');
        }
    });
}

function repUpdateCriteria(report, field) {
    var crit = '';
    var func = document.getElementById('critFunction').value;
    crit = func;
    var val1 = document.getElementById("critVal1");
    if (val1 != null)
    {
        crit = crit + '::' + val1.value;
        var val2 = document.getElementById('critVal2');
        if (val2 != null) {
            crit = crit + '::' + val2.value;
        }
    }
    
    $.ajax({
        url: URL,
        data: {
            method: 'repSetCriteria',
            rid: report,
            fid: field,
            crit: crit },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            repUpdCritModal(field);
            refreshReportViewTable();
        },
        error: function(xhr, status, error) {
            $('#edcritcont').html('<div class="alert alert-error"><strong>Error!</strong> Could not update criteria.</div>');
        }
    });
}

function repEmailReport(r) {
    if (confirm('Send this report to yourself as an email attachment?')) {
        $.ajax({
        url: URL,
        data: {
            method: 'repEmailReport',
            rid: r },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            alert('Sent. Your report should arrive shortly.');
        },
        error: function(xhr, status, error) {
            alert('Error: Something went wrong sending your report. aptTrack apologise for any inconvenience.')
        }
    });
    }
}

function repCritSaveClose(r, f) {
    repUpdateCriteria(r, f);
    $('#editCriteria').modal('hide');
}

function repShowCritModal(fid) {
    repUpdCritModal(fid);
    $('#editCriteria').modal('show')
}

function mainSearch() {
    search = document.getElementById('search').value;
    type = document.getElementById('type').value;
    tag = document.getElementById('tag').value;
    $.ajax({
        url: URL,
        data: {
            method: 'mainSearch',
            search: search,
            type: type, 
            tag: tag },
        type: 'POST',
        dataType: 'text',
        success: function(result) {
            $('#searchResults').html(result);
        },
        error: function(xhr, status, error) {
            showError('#searchResults', 'Problem with search.');
        }
    });
}

function clearAlert(t, i) {
    $('#'+i).hide(400, function() {
        $(t).html('');
    });
}
function showAlert(target, id, body) {
    $(target).html(body);
    setTimeout( function() {
            clearAlert(target, id);
            //$('#'+id).hide(400);
        }, 3000);
}

function showSuccess(target, message) {
    showAlert(target, 'success', '<div class="alert alert-success fade in" id="success"><strong>Success!</strong> ' + message + '</div>');
}

function showWarning(target, message) {
    showAlert(target, 'warning', '<div class="alert alert-block fade in" id="warning"><strong>Warning!</strong> ' + message + '</div>');
}

function showError(target, message) {
    showAlert(target, 'error', '<div class="alert alert-error fade in" id="error"><strong>Error!</strong> ' + message + '</div>');
}



