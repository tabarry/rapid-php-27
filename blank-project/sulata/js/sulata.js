
//Keep session live
function suStayAlive(url) {
    $.post(url);
}

//Reset form
function suReset(frmName) {


    var elements = document.getElementById(frmName).elements;



    for (i = 0; i < elements.length; i++) {

        field_type = elements[i].type.toLowerCase();

        switch (field_type) {

            case "text":
            case "password":
            case "textarea":
            case "hidden":

                elements[i].value = "";
                break;

            case "radio":
            case "checkbox":
                if (elements[i].checked) {
                    elements[i].checked = false;
                }
                break;

            case "select-one":
            case "select-multi":
                elements[i].selectedIndex = 0;
                break;

            default:
                break;
        }
    }
}
//Redirect
function suRedirect(url) {
    parent.window.location.href = url;
}

////To reload a dropdown
//function suReload(ele,url,sql){
//    $('#'+ele).load(url+'?q='+sql);
//}

//Disable submit button
function suToggleButton(arg) {
    if (arg == 1) {
        if (parent.$('#suForm')) {
            parent.$("#suForm").submit(function (event) {
                if (parent.$('#Submit')) {
                    parent.$("#Submit").val("Processing..");
                    parent.$("#Submit").css("cursor", "default");
                    parent.$("#Submit").attr("disabled", true);
                }
            });
        }
    } else {
        if (parent.$('#suForm')) {
            if (parent.$('#Submit')) {
                parent.$("#Submit").val("Submit");
                parent.$("#Submit").css("cursor", "Pointer");
                parent.$("#Submit").attr("disabled", false);
            }
        }
    }
}
//Reload dropdown area
function suReload(ele, url, tbl, f1, f2) {
    url = url + 'reload.php';
    $('#' + ele).load(url + '?tbl=' + tbl + '&f1=' + f1 + '&f2=' + f2);
}
//Reload checkbox area
function suReload2(ele, url, tbl, f1, f2, tblb, f1b, f2b, id) {
    url = url + 'reload.php';
    $('#' + ele).load(url + '?type=chk&tbl=' + tbl + '&f1=' + f1 + '&f2=' + f2 + '&tblb=' + tblb + '&f1b=' + f1b + '&f2b=' + f2b + '&id=' + id);
}
//Reload radio area
function suReload3(ele, url, tbl, f1, f2) {
    url = url + 'reload.php';
    $('#' + ele).load(url + '?type=radio&tbl=' + tbl + '&f1=' + f1 + '&f2=' + f2);
}
//Search dropdown
//Sample code
//<input type="text" id="realtxt" onKeyUp="suSearchCombo(this.id,'mediafile__Category')">
function suSearchCombo(searchBox, searchCombo) {
    var input = document.getElementById(searchBox).value.toLowerCase();
    var output = document.getElementById(searchCombo).options;
    for (var i = 0; i < output.length; i++) {
        if (output[i].text.indexOf(input) >= 0) {
            output[i].selected = true;
        }
        if (document.getElementById(searchBox).value == '') {
            output[0].selected = true;
        }
    }
}


//Delete row and confirm
function delById(id, warning) {
    c = confirm(warning);
    if (c == false) {
        return false;

    } else {
        if ($('#' + id + '_preview')) {
            $('#' + id + '_preview').hide();
        }
        if ($('#' + id + '_del')) {
            $('#' + id + '_del').hide();
        }
        if ($('#' + id + '_edit')) {
            $('#' + id + '_edit').hide();
        }
        if ($('#' + id + '_duplicate')) {
            $('#' + id + '_duplicate').hide();
        }
        if ($('#' + id + '_restore')) {
            $('#' + id + '_restore').show();
        }
        if ($('#' + id + ' header')) {
            $('#' + id + ' header').addClass('strike-through');
        }
        if ($('#' + id + ' h1')) {
            $('#' + id + ' h1').addClass('strike-through');
        }
        if ($('#' + id + ' p')) {
            $('#' + id + ' p').addClass('strike-through');
        }
        if ($('#' + id + ' label')) {
            $('#' + id + ' label').addClass('strike-through');
        }
        if ($('#' + id + ' .card')) {
            $('#' + id + ' .card').addClass('deleted-bg');
            $('#' + id + ' .card').addClass('red-border');
        }
        if ($('#' + id + ' td')) {
            $('#' + id + ' td').addClass('strike-through');
            $('#' + id + ' td').addClass('deleted-bg');
        }

        return true;
    }
}
//Restore row and confirm
function restoreById(id) {
    if ($('#' + id + '_preview')) {
        $('#' + id + '_preview').show();
    }
    if ($('#' + id + '_del')) {
        $('#' + id + '_del').show();
    }
    if ($('#' + id + '_edit')) {
        $('#' + id + '_edit').show();
    }
    if ($('#' + id + '_duplicate')) {
        $('#' + id + '_duplicate').show();
    }
    if ($('#' + id + '_restore')) {
        $('#' + id + '_restore').hide();
    }
    if ($('#' + id + ' h1')) {
        $('#' + id + ' h1').removeClass('strike-through');
    }
    if ($('#' + id + ' p')) {
        $('#' + id + ' p').removeClass('strike-through');
    }
    if ($('#' + id + ' label')) {
        $('#' + id + ' label').removeClass('strike-through');
    }
    if ($('#' + id + ' .card')) {
        $('#' + id + ' .card').removeClass('deleted-bg');
        $('#' + id + ' .card').removeClass('red-border');
    }
    if ($('#' + id + ' td')) {
        $('#' + id + ' td').removeClass('strike-through');
        $('#' + id + ' td').removeClass('deleted-bg');
    }

}
//Checkbox Area
function loadCheckbox(id, txt, fld) {
    //Add new value
    oldVal = $('#checkboxArea').html();
    newVal = "<table class=\"checkTable\" id=\"chkTbl" + id + "\"><tr><td class=\"checkTd\">" + txt + "</td><td class=\"checkTdCancel\" onclick=\"removeCheckbox('" + id + "')\"><a href=\"javascript:;\" onclick=\"removeCheckbox('" + id + "')\">x</a></td></tr><input type=\"hidden\" value=\"" + id + "\" name=\"" + fld + "[]\"></table>";
    $('#checkboxArea').html(oldVal + newVal);
    //Hide old value
    $('#chk' + id).hide();
}

function removeCheckbox(id) {
    $('#chk' + id).show();
    $('#chkTbl' + id).remove();
}

function toggleCheckboxClass(state, id) {
    if (state == 'over') {
        $('#fa' + id).removeClass('fa fa-square-o');
        $('#fa' + id).addClass('fa fa-check-square-o');
    } else {
        $('#fa' + id).removeClass('fa fa-check-square-o');
        $('#fa' + id).addClass('fa fa-square-o');

    }
}
//Password stength validator
function doStrongPassword(passwordEle, outputEle) {
    var tip = "At least 8 characters, 1 uppercase and 1 number.";
    var outputHidden = $('#' + outputEle + '_hidden');
    //TextBox left blank.
    if ($('#' + passwordEle).val().length == 0) {
        $('#' + outputEle).html('');
        return;
    }

    //Regular Expressions.
    var regex = new Array();
    regex.push("[A-Z]"); //Uppercase Alphabet.
    regex.push("[a-z]"); //Lowercase Alphabet.
    regex.push("[0-9]"); //Digit.
    regex.push("[$@$!%*#?&]"); //Special Character.

    var passed = 0;

    //Validate for each Regular Expression.
    for (var i = 0; i < regex.length; i++) {
        if (new RegExp(regex[i]).test($('#' + passwordEle).val())) {
            passed++;
        }
    }


    //Validate for length of Password.
    if (passed > 2 && $('#' + passwordEle).val().length > 8) {
        passed++;
    }

    //Display status.
    var color = "";
    var strength = "";
    switch (passed) {
        case 0:
        case 1:
            strength = tip;
            color = "red";
            break;
        case 2:
            strength = "Good";
            color = "darkorange";
            break;
        case 3:
        case 4:
            strength = "Strong";
            color = "green";
            break;
        case 5:
            strength = "Very Strong";
            color = "darkgreen";
            break;
    }
    $('#' + outputEle).html(strength);
    $('#' + outputEle).css("color", color);
    outputHidden.val(passed);
}
//Slugify text
function doSlugify(text, spaceCharacter)
{
    return text.toString().toLowerCase()
            .replace(/\s+/g, spaceCharacter)           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, spaceCharacter)         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
}
//Sleep, delay, wait
function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}
//Quick pick
function doQuickPick(sourceVal, targetEle, errorMsg) {
    oldVal = $('#' + targetEle).val();
    eleType = document.getElementById(targetEle).type;
    if (eleType == 'textarea') {
        newVal = oldVal + sourceVal + '\n';
    } else if (eleType == 'text') {
        newVal = oldVal + sourceVal + '. ';
    } else {
        alert(errorMsg);
        newVal = '';
    }
    $('#' + targetEle).val(newVal);
}
//Focus first field
function doFocusField(id) {
    var all = document.getElementsByTagName("*");
    for (var i = 0, max = all.length; i < max; i++) {
        if (document.all(i).id == id) {
            document.all(i).focus();
            break;
        }

    }
}
//Function to show hide search expansion. arg = less or more
function doSearchExpand(arg) {
    if (arg == 'more') {
        $('#search-expand').hide();
        $('#search-collection').show();
    } else if (arg == 'less') {
        $('#search-expand').show();
        $('#search-collection').hide();
    }
}
//Count forms with similar ids
function doSearchForm(id) {
    var all = document.getElementsByTagName("*");
    count = 0;
    for (var i = 0, max = all.length; i < max; i++) {
        e = document.all(i).id;
        if (e.indexOf(id) != -1) {
            count++;
        }
    }
    return count;
}
//Toggle settings dropdown/textbox
function doSettings(selectedValue) {
    if ($('#setting__Type').val() == 'Text') {
        $('#setting__Options').val('');
        $('#setting__Options').prop('readonly', true);
        $('#option-wrapper').html(optTextbox);
    } else {
        $('#setting__Options').prop('readonly', false);
        $('#option-wrapper').html(optSelect);
        opt = $('#setting__Options').val();
        opt = opt.split(',');
        //alert(opt)
        o = '<option value="">Select..</option>';
        for (i = 0; i < opt.length; i++) {
            ot = opt[i].trim()
            if (ot != '') {
                if (ot == selectedValue) {
                    sel = " selected=\"selected\" ";
                } else {
                    sel = '';
                }
                o += '<option' + sel + '>' + ot + '</option>';
            }
        }
    }
    $('#setting__Value').html(o);
}
//Check uncheck all checkboxes on page
function doCheckUncheck(arg, findStrToCheck, strToUncheck) {
    for (i = 0; i <= document.suForm.elements.length - 1; i++) {
        t = document.suForm.elements[i];
        if (t.type == 'checkbox') {
            if (t.id.indexOf(findStrToCheck) != -1) {
                if ((t.id.indexOf('x_sort') == -1) && (t.id.indexOf('x_downloadcsv') == -1) && (t.id.indexOf('x_downloadpdf') == -1)) {
                    if (arg.checked == true) {
                        t.checked = true;
                    } else {
                        t.checked = false;
                    }
                }
            }
        }
    }
    //Uncheck main checkbox
    if (arg.id != 'check_all') {
        document.getElementById('check_all').checked = false;
    }
    if (arg.checked == false) {
        document.getElementById(strToUncheck).checked = false;
    }
}
//At least one checkbox checked
function doCheckboxCheck() {
    c = false;
    for (i = 0; i <= document.suForm.elements.length - 1; i++) {
        t = document.suForm.elements[i];
        if (t.type == 'checkbox') {
            if (t.checked == true) {
                c = true;
                document.getElementById('is_checked').value = '1';
                break;
            }
        }
    }
}
//Show password field
function doShowPassword() {
    if ($('#user__Password').prop('type') == 'password') {
        $('#user__Password').prop('type', 'text');
        $('#user__Password2').prop('type', 'text');
    } else {
        $('#user__Password').prop('type', 'password');
        $('#user__Password2').prop('type', 'password');
    }
}

//Disable form fields for preview page
//1 is to show preview buttons and disable fields
function doTogglePreviewButtons(arg) {
    for (i = 0; i <= document.suForm.elements.length - 1; i++) {
        d = document.suForm.elements[i];
        if (d.type != 'button' && d.type != 'submit') {
            if (arg == 'preview') {
                document.suForm.elements[i].disabled = true;
            } else {
                document.suForm.elements[i].disabled = false;
            }
        }
    }
    //Show hide divs
    if (arg == 'preview') {
        document.getElementById('preview-mode').style.display = 'block';
        document.getElementById('edit-mode').style.display = 'none';
        document.getElementById('page-title').innerHTML = 'Preview';

    } else {
        document.getElementById('preview-mode').style.display = 'none';
        document.getElementById('edit-mode').style.display = 'block';
        $("html, body").animate({scrollTop: parent.$("html").offset().top}, "slow");
        document.getElementById('page-title').innerHTML = 'Update';
    }
}
//Delete from preview page
function doPreviewDelete(msg, url) {
    c = confirm(msg);
    if (c == true) {
        document.getElementById('btn-delete').disabled = true;
        document.getElementById('btn-delete').innerHTML = document.getElementById('btn-delete').innerHTML + '..';
        remote.window.location.href = url;
    } else {
        return false;
    }
}
//Print a element
function doPrintEle(ele) {
    document.getElementById('preview-mode').style.display = 'none';
    var contents = document.getElementById(ele).innerHTML;
    var frame1 = document.createElement('iframe');
    var css = 'body{margin:20px;font-family:arial,tahoma,verdana;font-size:12px}input[type=text],select,textarea{width:100%;font-family:arial,tahoma,verdana;font-size:12px;display:block;margin-top:5px;margin-bottom:5px;border:1px solid #eee;outline:0}label{width:100%;font-family:arial,tahoma,verdana;font-size:12px;display:block;margin-top:5px;margin-bottom:5px;border:0 none;outline:0;font-weight:700}';
    frame1.name = "frame1";
    frame1.style.position = "absolute";
    frame1.style.top = "-1000000px";
    document.body.appendChild(frame1);
    var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
    frameDoc.document.open();
    frameDoc.document.write('<html><head><title></title>');
    frameDoc.document.write('<style>' + css + '</style></head><body>');
    frameDoc.document.write(contents);
    frameDoc.document.write('</body></html>');
    frameDoc.document.close();
    setTimeout(function () {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        document.body.removeChild(frame1);
    }, 500);
    document.getElementById('preview-mode').style.display = 'block';
    return false;
}
//Inline edit form submission
function doInlineSubmit(frmName, fld, event) {
    if (event.keyCode === 13) {//Enter key
        document.getElementById(frmName).submit();
    }
    if (event.keyCode === 27) {//Escape key
        //                                                                
        document.getElementById('_____xx_____' + fld).value = document.getElementById('_____wrapper_____' + fld).innerHTML;
        document.getElementById(frmName).style.display = 'none';
        document.getElementById('_____wrapper_____' + fld).style.display = 'block';
        event.preventDefault();

    }

}
//Inline edit forms toggle
function doToggleInlineFields(frmName, fld, doWhat) {
    //Hide all previous opened inline edit forms
    var all = document.getElementsByTagName("*");
    //Hide form
    for (var i = 0, max = all.length; i < max; i++) {
        e = document.all(i).id;
        if (e.indexOf('inlineForm_') != -1) {
            document.getElementById(e).style.display = 'none';
        }
    }
    //Show wrapper
    for (var i = 0, max = all.length; i < max; i++) {
        e = document.all(i).id;
        if (e.indexOf('_____wrapper_____') != -1) {
            document.all(i).style.display = 'block';
        }
    }
    //==
    if (doWhat == 'show_form') {
        document.getElementById(frmName).style.display = 'block';
        document.getElementById('_____wrapper_____' + fld).style.display = 'none';
    } else {
        document.getElementById('_____xx_____' + fld).value = document.getElementById('_____wrapper_____' + fld).innerHTML;
        document.getElementById(frmName).style.display = 'none';
        document.getElementById('_____wrapper_____' + fld).style.display = 'block';
        event.preventDefault();
    }
}
//Toggle change password field
function doChangePassword(fld) {
    $('#' + fld + '-1').show();
    $('#' + fld + '-2').show();
    $('#' + fld + '-note').show();
    $('#' + fld + '-change-password').hide()

}
function doHideMenusOnInOverlay() {
    if (parent.frames.length > 1) {
        if ($('#top-nav')) {
            $('#top-nav').hide();
        }
        if ($('#side-outer-nav')) {
            $('#side-outer-nav').hide();
            $('.mainbar').css('margin-left','0px');

        }
    }
}