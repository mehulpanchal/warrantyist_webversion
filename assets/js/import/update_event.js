function get_events_data(a, srch) {
	$("#ued_but").css("background-color", "#95bcf2");
	$("#ucd_but").css("background-color", "#FFFFFF");
	$("#rcd_but").css("background-color", "#FFFFFF");
	$("#update_eve").show();
	$("#refresh_db").hide();
	$("#update_cls").hide();
	
	var b = "";
	b += '<div class="col-md-12 ilist-listing">';
	b += '<div class="row">';
	b += '<img src="' + base_url + 'assets/img/ajaxLoading.gif" alt="" class="img-responsive">';
	b += "</div>";
	b += "</div>";
	b += '<div class="clearfix"></div>';
	$("#update_eve").html(b);
	SendData = "page=" + a + "&srch=" + srch;
	$.ajax({
		url: site_url + "admin/event_list",
		type: "POST",
		data: SendData,
		dataType: "json",
		success: function (d) {
			$("#update_eve").html("");
			apply_event_data(d, srch)
		}
	})
}

function apply_event_data(n, srch) {
	var o = '';
	o += '<div class="table-responsive">';
	o += '<div class="table-scrollable">';
	o += '<table class="table table-striped table-hover table-bordered">';
	o += '<thead>';
	o += '<tr>';
	o += '<th>';
	o += 'Title';
	o += '</th>';
	o += '<th>';
	o += 'Type';
	o += '</th>';
	o += '<th>';
	o += 'Details';
	o += '</th>';
	o += '<th>';
	o += 'Date';
	o += '</th>';
	o += '<th>';
	o += 'Time';
	o += '</th>';
	o += '<th>';
	o += 'Location';
	o += '</th>';
	o += '<th>';
	o += 'Edit';
	o += '</th>';
	o += '<th>';
	o += 'Delete';
	o += '</th>';
	o += '</tr>';
	o += '</thead>';
	o += '<tbody>';
	if (n.totalPages == 0) {
		o += '<tr>';
		o += '<td colspan="8">';
		o += 'No result found';
		o += '</td>';
		o += '</tr>';
	} else {
		$.each(n, function () {
			$.each(this, function (b, d) {
				if (d.id!= null) {
					o += '<tr id="tr_'+d.id+'">';
					o += '<td>';
					o += d.title;
					o += '</td>';
					o += '<td>';
					o += d.event_type;
					o += '</td>';
					o += '<td>';
					o += d.details;
					o += '</td>';
					o += '<td>';
					o += d.event_date;
					o += '</td>';
					o += '<td>';
					o += d.event_time;
					o += '</td>';
					o += '<td>';
					o += d.location;
					o += '</td>';
					o += '<td>';
					o += '<a class="edit" href="javascript:;" onclick="edit_row('+d.id+')"> Edit </a>';
					o += '</td>';
					o += '<td>';
					o += '<a class="delete" href="javascript:;" onclick="delete_row('+d.id+', \''+srch+'\')"> Delete </a>';
					o += '</td>';
					o += '</tr>';
				}
			})
		});
	}
	o += '</tbody>';
	o += '</table>';
	o += pagination_datacoll(n, srch);
	o += '</div>';
	o += '</div>';
	o += '</div>';
	$("#update_eve").html(o);
};

function edit_row(Val)
{
	SendData = "Val="+Val;
	$.ajax({
		url: site_url + "admin/EditEventDetails",
		type: "POST",
		data: SendData,
		dataType: "json",
		success: function (d) {
			edit_row_data(d);
		}
	})
}

function delete_row(Val, srch)
{
	if(confirm("You sure to delete this details"))
	{
		SendData = "Val="+Val;
		$.ajax({
			url: site_url + "admin/DeleteEventDetails",
			type: "POST",
			data: SendData,
			dataType: "json",
			success: function (d) {
				get_events_data(1, srch);
			}
		});
	}
}

function edit_row_data(n)
{
	var o ='';
	$.each(n, function () {
		$.each(this, function (b, d) {
			if (d.id != null) {
				var timearr = d.event_time.split(":");
				var minarr = timearr[1].split(" ");
				var hour = '';
				if(timearr[0] == '1' && minarr[1] == 'PM')
				{
					hour = '13';
				}
				else if(timearr[0] == '2' && minarr[1] == 'PM')
				{
					hour = '14';
				}
				else if(timearr[0] == '3' && minarr[1] == 'PM')
				{
					hour = '15';
				}
				else if(timearr[0] == '4' && minarr[1] == 'PM')
				{
					hour = '16';
				}
				else if(timearr[0] == '5' && minarr[1] == 'PM')
				{
					hour = '17';
				}
				else if(timearr[0] == '6' && minarr[1] == 'PM')
				{
					hour = '18';
				}
				else if(timearr[0] == '7' && minarr[1] == 'PM')
				{
					hour = '19';
				}
				else if(timearr[0] == '8' && minarr[1] == 'PM')
				{
					hour = '20';
				}
				else if(timearr[0] == '9' && minarr[1] == 'PM')
				{
					hour = '21';
				}
				else if(timearr[0] == '10' && minarr[1] == 'PM')
				{
					hour = '22';
				}
				else if(timearr[0] == '11' && minarr[1] == 'PM')
				{
					hour = '23';
				}
				else if(timearr[0] == '12' && minarr[1] == 'AM')
				{
					hour = '24';
				}
				else
				{
					hour = timearr[0];
				}
				o += '<td>';
				o += '<input type="text" name="val1" id="val1" class="form-control input-small" value="' + d.title + '">';
				o += '</td>';
				o += '<td>';
				o += '<input type="text" name="val2" id="val2" class="form-control input-small" value="' + d.event_type + '">';
				o += '</td>';
				o += '<td>';
				o += '<input type="text" name="val3" id="val3" class="form-control input-small" value="' + d.details + '">';
				o += '</td>';
				o += '<td>';
				o += '<input type="text" name="val4" id="val4" class="form-control input-small" value="' + d.event_date + '">';
				o += '</td>';
				o += '<td>';
				o += '<select name="val5" id="val5" class="form-control input-small col-md-6">';
				o += '<option value="">Select Hour</option>';
				var s = 0;
				for(var i=1; i<=23; i++)
				{
					s = ('0' + i).slice(-2);
					o += '<option value="'+s+'" ';
					if(s == hour)
					{
						o += 'SELECTED';
					}
					o += ' >'+s+'</option>';
				}
				o += '</select>';
				o += '<select name="val6" id="val6" class="form-control input-small col-md-6">';
				o += '<option value="">Select Minutes</option>';
				for(var i=1; i<=59; i++)
				{
					s = ('0' + i).slice(-2);
					o += '<option value="'+s+'" ';
					if(s == minarr[0])
					{
						o += 'SELECTED';
					}
					o += ' >'+s+'</option>';
				}
				o += '</select>';
				o += '</td>';
				o += '<td>';
				o += '<input type="text" name="val7" id="val7" class="form-control input-small" value="' + d.location + '">';
				o += '</td>';
				o += '<td>';
				o += '<a class="Save" href="javascript:;" onclick="save_row('+d.id+')"> Save </a>';
				o += '</td>';
				o += '<td>';
				o += '<a class="Cancel" href="javascript:;" onclick="cancel_row('+d.id+')"> Cancel </a>';
				o += '</td>';
			}
		});
	});
	/*$('#datetimepicker5').datetimepicker({
					pickTime: false
				});*/
	$("#tr_"+n.Val).html(o);
}

function save_row(Val)
{
	var val1 = $("#val1").val();
	var val2 = $("#val2").val();
	var val3 = $("#val3").val();
	var edatev = $("#val4").val();
	var ehourv = $("#val5").val();
	var eminutesv = $("#val6").val();
	var val7 = $("#val7").val();
	
	var jodate = edatev.split('-');
	val4 = jodate[2]+"-"+jodate[1]+"-"+jodate[0];
	
	var val5 = '';
	if(ehourv < 12)
	{
		val5 = ehourv+':'+eminutesv+' AM';
	}
	else if(ehourv == 24)
	{
		val5 = '12:'+eminutesv+' AM';
	}
	else if(ehourv == 13)
	{
		val5 = '1:'+eminutesv+' PM';
	}
	else if(ehourv == 14)
	{
		val5 = '2:'+eminutesv+' PM';
	}
	else if(ehourv == 15)
	{
		val5 = '3:'+eminutesv+' PM';
	}
	else if(ehourv == 16)
	{
		val5 = '4:'+eminutesv+' PM';
	}
	else if(ehourv == 17)
	{
		val5 = '5:'+eminutesv+' PM';
	}
	else if(ehourv == 18)
	{
		val5 = '6:'+eminutesv+' PM';
	}
	else if(ehourv == 19)
	{
		val5 = '7:'+eminutesv+' PM';
	}
	else if(ehourv == 20)
	{
		val5 = '8:'+eminutesv+' PM';
	}
	else if(ehourv == 21)
	{
		val5 = '9:'+eminutesv+' PM';
	}
	else if(ehourv == 22)
	{
		val5 = '10:'+eminutesv+' PM';
	}
	else if(ehourv == 23)
	{
		val5 = '11:'+eminutesv+' PM';
	}
	else
	{
		val5 = ehourv+':'+eminutesv+' PM';
	}

	SendData = "Val="+Val+"&val1="+val1+"&val2="+val2+"&val3="+val3+"&val4="+val4+"&val5="+val5+"&val7="+val7;
	$.ajax({
		url: site_url + "admin/SaveEventDetails",
		type: "POST",
		data: SendData,
		dataType: "json",
		success: function (d) {
			display_row_data(d);
		}
	})
}

function cancel_row(Val)
{
	SendData = "Val="+Val;
	$.ajax({
		url: site_url + "admin/EventManageDetails",
		type: "POST",
		data: SendData,
		dataType: "json",
		success: function (d) {
			display_row_data(d);
		}
	})
}

function display_row_data(n)
{
	var o ='';
	$.each(n, function () {
		$.each(this, function (b, d) {
			if (d.id != null) {
				o += '<td>';
				o += d.title;
				o += '</td>';
				o += '<td>';
				o += d.event_type;
				o += '</td>';
				o += '<td>';
				o += d.details;
				o += '</td>';
				o += '<td>';
				o += d.event_date;
				o += '</td>';
				o += '<td>';
				o += d.event_time;
				o += '</td>';
				o += '<td>';
				o += d.location;
				o += '</td>';
				o += '<td>';
				o += '<a class="edit" href="javascript:;" onclick="edit_row('+d.id+')"> Edit </a>';
				o += '</td>';
				o += '<td>';
				o += '<a class="delete" href="javascript:;" onclick="delete_row('+d.id+')"> Delete </a>';
				o += '</td>';
			}
		});
	});
	$("#tr_"+n.Val).html(o);
}

function pagination_datacoll(i, srch) {
	var n = "";
	if (i.totalPages > 1) {
		n += '<div class="pagination"><ul>';
		var m = 1;
		var l = (1 * i.totalPages);
		if (l > 10) {
			m = (1 * i.currentPage) - 5;
			m = m > 1 ? m : 1;
			l = l > (m + 9) ? (m + 9) : l
		}
		if (m > 1) {
			n += '<li><a class="pageButton" id="page-' + (m - 1) + '" href="javascript:void(0);" onclick="nxt_pagcoll(' + (m - 1) + ", '" + srch + "');\"><<</a></li>"
		}
		for (var k = m; k <= l; k++) {
			n += '<li' + (i.currentPage == k ? ' class="active"' : "") + '><a class="pageButton" id="page-' + k + '" href="javascript:void(0);" onclick="nxt_pagcoll(' + k + ", '" + srch + "');\">" + k + "</a></li>"
		}
		if (l < (1 * i.totalPages)) {
			n += '<li><a class="pageButton" id="page-' + (l + 1) + '" href="javascript:void(0);" onclick="nxt_pagcoll(' + (l + 1) + ", '" + srch + "');\">>></a></li>"
		}
		n += "</ul></div>"
	}
	return n
}

function nxt_pagcoll(h, srch) {
	get_events_data(h, srch)
}
