function open_sel()
{
    $("#sel_div").show();
    $("#user_add_opt").val("");
}

function open_db_sel()
{
    $("#db_upload").show();
    $("#db_upload_files").show();
}

function add_um_details() {
   
    var um_mail = $("#um_mail");
    var um_mail_val = $("#um_mail").val();
    var um_pwd = $("#um_pwd");
    var um_pwd_val = $("#um_pwd").val();
    var a = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;

    if(um_mail_val == '' || um_mail_val == null || !a.test(um_mail_val)) {
        um_mail.css("background-color", '#e77776');
        um_mail.attr("placeholder", "Not a valid e-mail address");
        return false;
    }
    if(um_pwd_val == '' || um_pwd_val == null) {
        um_pwd.css("background-color", "#e77776");
        um_pwd.attr("placeholder","Password field cannot be blank");
        return false;
    }

    sendData = "um_mail=" + um_mail_val + "&um_pwd=" + um_pwd_val;
   
    $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url + "admin/add_um_data",
        data: sendData,
        success: function() {
            $("#show_um_msg").show().html("Record added successfully!");
            setTimeout("$('#show_um_msg').hide().html('')", 2000);
          
        }

    });
}

function open_entry(val)
{
    if (val == 'ME')
    {
        $("#manual_entry").show();
        $("#csv_upload").hide();
        $("#csv_upload_files").hide();
    }
    else if (val == 'CSV')
    {
        $("#csv_upload").show();
        $("#csv_upload_files").show();
        $("#manual_entry").hide();
    }
    else
    {
        $("#manual_entry").hide();
        $("#csv_upload").hide();
        $("#csv_upload_files").hide();
    }
}

function open_news_event(val)
{
    if (val == '1')
    {
        $("#add_news").show();
        $("#add_event").hide();
    }
    else if (val == '2')
    {
        $("#add_event").show();
        $("#add_news").hide();
    }
    else
    {
        $("#add_news").hide();
        $("#add_event").hide();
    }
}

function open_cont_details(val)
{
    $("#db_upload").hide();
    $("#db_upload_files").hide();
    $("#details_table_cls").hide();
    $("#list_table_cls").show();
    if (val == 1)
    {
        $("#rcd_but").css("background-color", "#95bcf2");
        $("#ucd_but").css("background-color", "#FFFFFF");
        $("#ued_but").css("background-color", "#FFFFFF");
        $("#refresh_db").show();
        $("#update_cls").hide();
        $("#update_eve").hide();
    }
    else if (val == 2)
    {
        get_class_data(1, '');
    }
    else if (val == 3)
    {
        get_events_data(1, '');
    }
    else
    {
        $("#rcd_but").css("background-color", "#95bcf2");
        $("#ucd_but").css("background-color", "#FFFFFF");
        $("#ued_but").css("background-color", "#FFFFFF");
        $("#refresh_db").show();
        $("#update_cls").hide();
        $("#update_eve").hide();
    }
}

function validateuserName() {
    var d = $("#fname");
    var a = $("#fname").val();
    if (a != "") {
        d.css("background-color", "#FFF");
        d.attr("placeholder", "First Name");
        return true
    } else {
        d.css("background-color", "#e77776");
        d.attr("placeholder", "First Name required");
        return false
    }
}

function validateuserLName() {
    var d = $("#lname");
    var a = $("#lname").val();
    if (a != "") {
        d.css("background-color", "#FFF");
        d.attr("placeholder", "Last Name");
        return true
    } else {
        d.css("background-color", "#e77776");
        d.attr("placeholder", "Last Name required");
        return false
    }
}

function validateuserDName() {
    var d = $("#dname");
    var a = $("#dname").val();
    if (a != "") {
        d.css("background-color", "#FFF");
        d.attr("placeholder", "Display Name");
        return true
    } else {
        d.css("background-color", "#e77776");
        d.attr("placeholder", "Display Name required");
        return false
    }
}

function validateuseremail() {
    var f = $("#uemail");
    var e = $("#uemail").val();
    var a = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
    if (a.test(e)) {
        return true
    } else {
        f.css("background-color", "#e77776");
        f.attr("placeholder", "University Email required");
        return false
    }
}

function validateuserpass() {
    var b = $("#passwd");
    var c = $("#passwd").val();
    if (c != "") {
        if (c.length < 7) {
            $("#passwd").addClass("error");
            $("#passwd_err").show();
            return false
        } else {
            b.css("background-color", "#FFF");
            $("#passwd").removeClass("error");
            $("#passwd_err").hide();
            return true
        }
    } else {
        b.css("background-color", "#e77776");
        b.attr("placeholder", "Password required");
        return false
    }
}

function validateprogram() {
    var b = $("#prog");
    var c = $("#prog").val();
    if (c != "")
    {
        b.css("background-color", "#FFF");
        $("#prog").removeClass("error");
        return true
    }
    else
    {
        b.css("background-color", "#e77776");
        b.attr("placeholder", "Please Select Program");
        return false
    }
}

/*function validatepdate()
 {
 var startdate = $("#pstart").val();
 var enddate = $("#pend").val();
 
 var d1 = document.stud_reg.pstart.value.substr(0, 2);
 var m1 = document.stud_reg.pstart.value.substr(3, 2);
 var y1 = document.stud_reg.pstart.value.substr(6, 4);
 var StrDate = m1 + "/" + d1 + "/" + y1;
 
 var d2 = document.stud_reg.pend.value.substr(0, 2);
 var m2 = document.stud_reg.pend.value.substr(3, 2);
 var y2 = document.stud_reg.pend.value.substr(6, 4);
 var EndDate = m2 + "/" + d2 + "/" + y2;
 
 var startDate = new Date(StrDate);
 var endDate = new Date(EndDate);
 
 if(startdate == '' || startdate ==null)
 {
 $("#pstart").css('background-color', '#e77776');
 $("#pstart_err").show();
 $("#pstart").addClass("error");
 return false;
 }
 else if(enddate == '' || enddate ==null)
 {
 $("#pend").css('background-color', '#e77776');
 $("#pend_err").show();
 $("#pend_err_label").text("Program End Date should not be blank.");
 $("#pend").addClass("error");
 return false;
 }
 else if (startDate > endDate)
 {
 $("#pend").css('background-color', '#e77776');
 $("#pend_err").show();
 $("#pend_err_label").text("Program End Date should be greater than Start Date.");
 $("#pend").addClass("error");
 return false;
 }
 else
 {
 $("#pstart_err").hide();
 $("#pend_err").hide();
 $("#pstart").removeClass("error");
 $("#pend").removeClass("error");
 return true;
 }
 }*/

function validatepdate()
{
    var startdate = $("#pstart").val();
    var enddate = $("#pend").val();

    if (startdate == '' || startdate == null)
    {
        $("#pstart").css('background-color', '#e77776');
        $("#pstart_err").show();
        $("#pstart").addClass("error");
        return false;
    }
    else if (enddate == '' || enddate == null)
    {
        $("#pend").css('background-color', '#e77776');
        $("#pend_err").show();
        $("#pend_err_label").text("Program End Date should not be blank.");
        $("#pend").addClass("error");
        return false;
    }
    else if (startdate > enddate)
    {
        $("#pend").css('background-color', '#e77776');
        $("#pend_err").show();
        $("#pend_err_label").text("Program End Date should be greater than Start Date.");
        $("#pend").addClass("error");
        return false;
    }
    else
    {
        $("#pstart_err").hide();
        $("#pend_err").hide();
        $("#pstart").removeClass("error");
        $("#pend").removeClass("error");
        return true;
    }
}

function submit_stud_data()
{
    if (validateuserName() && validateuserLName() && validateuseremail() && validateuserpass() && validateuserDName() && validateprogram() && validatepdate())
    {
        var a = $("#fname").val();
        var b = $("#lname").val();
        var c = $("#dname").val();
        var d = $("#uemail").val();
        var e = $("#passwd").val();
        var joindate = $("#jdate").val();
        var g = $("#prog").val();
        var h = $("#pstart").val();
        var i = $("#pend").val();
        var f = '';
        if (joindate != '')
        {
            var jodate = joindate.split('-');
            f = jodate[2] + "-" + jodate[1] + "-" + jodate[0];
        }
        else
        {
            f = '';
        }

        SendData = "a=" + a + "&b=" + b + "&c=" + c + "&d=" + d + "&e=" + e + "&f=" + f + "&g=" + g + "&h=" + h + "&i=" + i;
        $.ajax({
            url: site_url + "admin/add_stud_data",
            type: "POST",
            data: SendData,
            dataType: "json",
            success: function (d) {
                if(d == 'p'){
                $("#msg_txt").show();
                $("#msg_txt").html("<b>User already Present</b>");
                setTimeout("$('#msg_txt').hide()", 20000);
                setTimeout("$('#msg_txt').html('')", 20000);
                return false;
                }
                $("#msg_txt").show();
                $("#msg_txt").html("<b>Student details added successfully</b>");
                setTimeout("$('#msg_txt').hide()", 20000);
                setTimeout("$('#msg_txt').html('')", 20000);
                
                $("#fname").val('');
                $("#lname").val('');
                $("#dname").val('');
                $("#uemail").val('');
                $("#passwd").val('');
                $("#jdate").val('');
                $("#prog").val('');
                $("#pstart").val('');
                $("#pend").val('');
            }
        })
    }
}

function validateNtitle()
{
    var d = $("#ntitle");
    var a = $("#ntitle").val();

    if (a == "")
    {
        d.css("background-color", "#e77776");
        d.addClass("error");
        d.attr("placeholder", "Title required");
        return false
    }
    else
    {
        d.css("background-color", "#FFF");
        d.removeClass("error");
        return true
    }
}

function validateNtext()
{
    var ntxt = $("#ntext");
    var atxt = $("#ntext").val();

    if (atxt == "")
    {
        ntxt.css("background-color", "#e77776");
        ntxt.addClass("error");
        ntxt.attr("placeholder", "Text required");
        return false
    }
    else
    {
        ntxt.css("background-color", "#FFF");
        ntxt.removeClass("error");
        return true
    }
}

function validateNdate()
{
    var nddate = $("#npdate");
    var ddate = $("#npdate").val();

    if (ddate == '' || ddate == null)
    {
        nddate.css('background-color', '#e77776');
        nddate.addClass("error");
        $("#npdate_err").show();
        return false;
    }
    else
    {
        nddate.css("background-color", "#FFF");
        nddate.removeClass("error");
        $("#npdate_err").hide();
        return true
    }
}

function add_news_data()
{
    if (validateNtitle() && validateNtext() && validateNdate())
    {
        var a = $("#ntitle").val();
        var atxt = $("#ntext").val();
        var ddate = $("#npdate").val();
        var ntype = $("#ntype").val();

        var jodate = ddate.split('-');
        c = jodate[2] + "-" + jodate[1] + "-" + jodate[0];

        SendData = "a=" + a + "&b=" + atxt + "&c=" + c +"&d="+ntype;
        $.ajax({
            url: site_url + "admin/add_news_data",
            type: "POST",
            data: SendData,
            dataType: "json",
            success: function (d) {
                $("#msg_txt_news").show();
                $("#msg_txt_news").html("News details added successfully");
                setTimeout("$('#msg_txt_news').hide()", 10000);
                setTimeout("$('#msg_txt_news').html('')", 10000);

                $("#ntitle").val('');
                $("#ntext").val('');
                $("#npdate").val('');
            }
        })
    }
}

function validateetitle()
{
    var etitlef = $("#etitle");
    var etitlev = $("#etitle").val();

    if (etitlev == '' || etitlev == null)
    {
        etitlef.css('background-color', '#e77776');
        etitlef.attr("placeholder", "Title required");
        return false;
    }
    else
    {
        etitlef.css("background-color", "#FFF");
        etitlef.removeClass("error");
        return true
    }
}

function validateedetails()
{
    var edetailsf = $("#edetails");
    var edetailsv = $("#edetails").val();

    if (edetailsv == "")
    {
        edetailsf.css("background-color", "#e77776");
        edetailsf.attr("placeholder", "Details required");
        return false
    }
    else
    {
        edetailsf.css("background-color", "#FFF");
        edetailsf.removeClass("error");
        return true
    }
}

function validateetype()
{
    var etypef = $("#etype");
    var etypev = $("#etype").val();

    if (etypev == "")
    {
        etypef.css("background-color", "#e77776");
        etypef.attr("placeholder", "Type of Event required");
        return false
    }
    else
    {
        etypef.css("background-color", "#FFF");
        etypef.removeClass("error");
        return true
    }
}

function validateedate()
{
    var edatef = $("#edate");
    var edatev = $("#edate").val();

    if (edatev == '' || edatev == null)
    {
        edatef.css('background-color', '#e77776');
        edatef.addClass("error");
        $("#edate_err").show();
        return false;
    }
    else
    {
        edatef.css("background-color", "#FFF");
        edatef.removeClass("error");
        $("#edate_err").hide();
        return true
    }
}

function validateetime()
{
    var ehourf = $("#ehour");
    var ehourv = $("#ehour").val();

    var eminutesf = $("#eminutes");
    var eminutesv = $("#eminutes").val();

    if (ehourv == '' || ehourv == null)
    {
        ehourf.css('background-color', '#e77776');
        ehourf.addClass("error");
        $("#etime_err").show();
        $("#etime_arr_label").text("Please select hour");
        return false;
    }
    else if (eminutesv == '' || eminutesv == null)
    {
        ehourf.css("background-color", "#FFF");
        ehourf.removeClass("error");

        eminutesf.css('background-color', '#e77776');
        eminutesf.addClass("error");
        $("#etime_err").show();
        $("#etime_arr_label").text("Please select minutes");
        return false;
    }
    else
    {
        ehourf.css("background-color", "#FFF");
        ehourf.removeClass("error");
        eminutesf.css("background-color", "#FFF");
        eminutesf.removeClass("error");
        $("#etime_err").hide();
        return true
    }
}

function validateelocation()
{
    var elocationf = $("#elocation");
    var elocationv = $("#elocation").val();

    if (elocationv == '' || elocationv == null)
    {
        elocationf.css('background-color', '#e77776');
        elocationf.attr("placeholder", "location required");
        return false;
    }
    else
    {
        elocationf.css("background-color", "#FFF");
        elocationf.removeClass("error");
        return true
    }
}

function add_event_data()
{
    if (validateetitle() && validateedetails() && validateetype() && validateedate() && validateetime() && validateelocation())
    {
        var a = $("#etitle").val();
        var b = $("#edetails").val();
        var c = $("#etype").val();
        var edatev = $("#edate").val();
        var ehourv = $("#ehour").val();
        var eminutesv = $("#eminutes").val();
        var f = $("#elocation").val();

        var jodate = edatev.split('-');
        d = jodate[2] + "-" + jodate[1] + "-" + jodate[0];
        var e = '';
        if (ehourv < 12)
        {
            e = ehourv + ':' + eminutesv + ' AM';
        }
        else if (ehourv == 24)
        {
            e = '12:' + eminutesv + ' AM';
        }
        else if (ehourv == 13)
        {
            e = '1:' + eminutesv + ' PM';
        }
        else if (ehourv == 14)
        {
            e = '2:' + eminutesv + ' PM';
        }
        else if (ehourv == 15)
        {
            e = '3:' + eminutesv + ' PM';
        }
        else if (ehourv == 16)
        {
            e = '4:' + eminutesv + ' PM';
        }
        else if (ehourv == 17)
        {
            e = '5:' + eminutesv + ' PM';
        }
        else if (ehourv == 18)
        {
            e = '6:' + eminutesv + ' PM';
        }
        else if (ehourv == 19)
        {
            e = '7:' + eminutesv + ' PM';
        }
        else if (ehourv == 20)
        {
            e = '8:' + eminutesv + ' PM';
        }
        else if (ehourv == 21)
        {
            e = '9:' + eminutesv + ' PM';
        }
        else if (ehourv == 22)
        {
            e = '10:' + eminutesv + ' PM';
        }
        else if (ehourv == 23)
        {
            e = '11:' + eminutesv + ' PM';
        }
        else
        {
            e = ehourv + ':' + eminutesv + ' PM';
        }

        SendData = "a=" + a + "&b=" + b + "&c=" + c + "&d=" + d + "&e=" + e + "&f=" + f;
        $.ajax({
            url: site_url + "admin/add_event_data",
            type: "POST",
            data: SendData,
            dataType: "json",
            success: function (d) {
                $("#msg_txt_event").show();
                $("#msg_txt_event").html("Event details added successfully");
                setTimeout("$('#msg_txt_event').hide()", 10000);
                setTimeout("$('#msg_txt_event').html('')", 10000);

                $("#etitle").val('');
                $("#edetails").val('');
                $("#etype").val('');
                $("#edate").val('');
                $("#ehour").val('');
                $("#eminutes").val('');
                $("#elocation").val('');
            }
        })
    }
}

function send_msg()
{
    var support_msg = $("#support_msg");
    var a = $("#support_msg").val();
    if (a == '')
    {
        support_msg.css('background-color', '#e77776');
        support_msg.attr("placeholder", "Message required");
        return false;
    }
    else
    {
        SendData = "a=" + a;
        $.ajax({
            url: site_url + "admin/send_msg",
            type: "POST",
            data: SendData,
            dataType: "json",
            success: function (d) {
                $("#msg_txt_support").show();
                $("#msg_txt_support").html("Message sent successfully");
                setTimeout("$('#msg_txt_support').hide()", 10000);
                setTimeout("$('#msg_txt_support').html('')", 10000);

                $("#support_msg").val('');
                support_msg.attr("placeholder", "Type your message here and the GradsPad Tech Support Team will revert to you as soon as possible. Additionally you can call the numbers provided during office Hours.");
            }
        })
    }
}
