// JavaScript Document
//Validate Project Creation
function validateProject() {

    if (document.getElementById('directory').value == '') {
        alert('`Directory` is a required field.');
        document.getElementById('directory').focus();
        return false;
    }
    if (document.getElementById('db').value == '') {
        alert('`Database` is a required field.');
        document.getElementById('db').focus();
        return false;
    }
    if (document.getElementById('db_user').value == '') {
        alert('`Database User` is a required field.');
        document.getElementById('db_user').focus();
        return false;
    }


    if (document.getElementById('db_drop').value != 'DROP') {
        alert(' Type `DROP` to drop previous database.');
        document.getElementById('db_drop').focus();
        return false;
    }
    $('#result').html('');
    c = confirm('This will overwrite any previously created directory with the name `' + document.getElementById('directory').value + '`.\nDo you want to proceed?');
    if (c == true) {
        submitDisable();
        return true;
    } else {
        return false;
    }
}
//Validate DB Structure
function validateDBStructure() {
    if (document.getElementById('db').selectedIndex == 0) {
        alert('Please select database.');
        document.getElementById('db').focus();
        return false;
    }
    if (document.getElementById('folder').selectedIndex == 0) {
        alert('Please select folder.');
        document.getElementById('folder').focus();
        return false;
    }
    $('#result').html('');
}
//Validate step 1
function validate1() {
    if (document.getElementById('db').selectedIndex == 0) {
        alert('Please select database.');
        document.getElementById('db').focus();
        return false;
    }
}
//Validate step 2
function validate2() {
    flag = 0;
    for (i = 0; i <= document.form1.elements.length - 1; i++) {
        if (document.form1.elements[i].type == 'checkbox') {
            if (document.form1.elements[i].checked == true) {
                flag = 1;
            }
        }
    }
    if (flag == 0) {
        alert('Please select at least one table.');
        return false;

    }
}

//Validate step 3
function validate3(frmName) {
    if (document.getElementById('folderName').selectedIndex == 0) {
        alert('Please select folder.');
        document.getElementById('folderName').focus();
        return false;
    }
    if (document.getElementById('template').value == '') {
        alert('Please choose a template file.');
        document.getElementById('template').focus();
        return false;
    }
    return true;
}

//Check/uncheck check boxes on step 2
function doCheck(arg) {
    for (i = 0; i <= document.form1.elements.length - 1; i++) {
        if (document.form1.elements[i].type == 'checkbox') {
            if (arg == 1) {
                document.form1.elements[i].checked = true;
            } else {
                document.form1.elements[i].checked = false;
            }
        }
    }
}
//Copy folder name to hidden files
function copyFolderName(str) {
    for (i = 0; i <= document.forms.length - 1; i++) {
        if (document.forms[i].folder) {
            document.forms[i].folder.value = str;
        }
    }
}
//Sleep function
function sleep(delay) {
    var start = new Date().getTime();
    while (new Date().getTime() < start + delay)
        ;
}
//Submit all forms on step 3
function submitAll() {
    //resetCheckedValues();
    //Clear previous result
    $('#result').html('');
    //Check if template is uploaded
    if (document.getElementById('folderName').selectedIndex == 0) {
        alert('Please select folder.');
        document.getElementById('folderName').focus();
        return false;
    }
    if (document.getElementById('template').value == '') {
        alert('Please choose a template file.');
        document.getElementById('template').focus();
        return false;
    }

    for (i = 0; i <= document.forms.length - 1; i++) {
        document.forms[i].submit();
    }
    document.uploadForm.folderName.selectedIndex = 0;
}

//Slugify text
function doSlugify(text, spaceCharacter)
{
    return text.toString().toLowerCase()
            .replace(/\s+/g, spaceCharacter)           // Replace spaces with -
            .replace(/[^\w\-]+/g, spaceCharacter)       // Remove all non-word chars
            .replace(/\-\-+/g, spaceCharacter)         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
}


//Reset checked values
function resetCheckedValues() {
    var all = document.getElementsByTagName("*");
    for (var i = 0, max = all.length; i < max; i++) {
        t = document.all(i).type;
        if (t == 'checkbox') {
            if (document.all(i).checked == false) {
                document.all(i).checked = true;
                document.all(i).value = '^';
            }
        }

    }


}
//Count down
var t = 1;
var tVar;
function startCount() {
    t = t + 1;
    document.getElementById('countdown').innerHTML = t;
}
//Function clear timer
function clearCounter(){
    t = 0;
    clearInterval(tVar);
}
//Disable submit button
function submitDisable() {
    tVar = setInterval(startCount, 1000);
    document.getElementById('Submit').value = 'Creating Project..';
    document.getElementById('Submit').classList.remove('enabled');
    document.getElementById('Submit').classList.add('disabled');
    document.getElementById('Submit').disabled = true;
}
