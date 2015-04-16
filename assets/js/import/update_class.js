function get_class_data(a, srch) {
	$("#ucd_but").css("background-color", "#95bcf2");
	$("#rcd_but").css("background-color", "#FFFFFF");
	$("#ued_but").css("background-color", "#FFFFFF");
	$("#update_cls").show();
	$("#refresh_db").hide();
	$("#update_eve").hide();
	
	var b = "";
	b += '<div class="col-md-12 ilist-listing">';
	b += '<div class="row">';
	b += '<img src="' + base_url + 'assets/img/ajaxLoading.gif" alt="" class="img-responsive">';
	b += "</div>";
	b += "</div>";
	b += '<div class="clearfix"></div>';
	$("#update_cls").html(b);
	SendData = "page=" + a + "&srch=" + srch;
	$.ajax({
		url: site_url + "admin/class_list",
		type: "POST",
		data: SendData,
		dataType: "json",
		success: function (d) {
			$("#update_cls").html("");
			apply_class_details_data(d, srch)
		}
	})
}

function get_class_details_data(a, srch) {
	
	var b = "";
	b += '<div class="col-md-12 ilist-listing">';
	b += '<div class="row">';
	b += '<img src="' + base_url + 'assets/img/ajaxLoading.gif" alt="" class="img-responsive">';
	b += "</div>";
	b += "</div>";
	b += '<div class="clearfix"></div>';
	$("#details_table_cls").html(b);
	SendData = "page=" + a + "&srch=" + srch;
	$.ajax({
		url: site_url + "admin/ClassManageDetails",
		type: "POST",
		data: SendData,
		dataType: "json",
		success: function (d) {
			$("#details_table_cls").html("");
			apply_class_data(d, srch)
		}
	})
}

function apply_class_details_data(n, srch) {
	var o = '';
	o += '<div id="list_table_cls">';
	o += '<div class="table-responsive">';
	o += '<div class="table-scrollable">';
	o += '<table class="table table-striped table-hover table-bordered">';
	o += '<thead>';
	o += '<tr>';
	o += '<th>';
	o += 'Semester';
	o += '</th>';
	o += '<th>';
	o += 'Department';
	o += '</th>';
	o += '<th>';
	o += 'Class Code';
	o += '</th>';
	o += '<th>';
	o += 'Class Name';
	o += '</th>';
	o += '<th>';
	o += 'Batch Number';
	o += '</th>';
	o += '<th>';
	o += 'Professor';
	o += '</th>';
	o += '<th>';
	o += 'Capacity';
	o += '</th>';
	o += '</tr>';
	o += '</thead>';
	o += '<tbody>';
	if (n.totalPages == 0) {
		o += '<tr>';
		o += '<td colspan="7">';
		o += 'No result found';
		o += '</td>';
		o += '</tr>';
	} else {
		$.each(n, function () {
			$.each(this, function (b, d) {
				if (d.uni_id!= null) {
					//var batchArr = d.title.split(' Batch NO:');
					o += '<tr  style="cursor:pointer;">';
					o += '<td>';
					o += d.semester;
					o += '</td>';
					o += '<td>';
					o += d.department;
					o += '</td>';
					o += '<td>';
					o += d.course_no;
					o += '</td>';
					o += '<td>';
					//o += batchArr[0];
					o += d.department;
					o += '</td>';
					o += '<td>';
					//o += batchArr[1];
					o += d.batch_no;
					o += '</td>';
					o += '<td>';
					o += d.professor;
					o += '</td>';
					o += '<td>';
					o += d.capacity;
					o += '</td>';
					o += '</tr>';
				}
			})
		});
	}
	o += '</tbody>';
	o += '</table>';
	o += pagination_datacoll_class(n, srch);
	o += '</div>';
	o += '</div>';
	o += '</div>';
	o += '<div id="details_table_cls" style="display:none;"></div>';
	$("#update_cls").html(o);
};

function open_cls_details_table(val)
{
	$("#details_table_cls").show();
	$("#list_table_cls").hide();

	var b = "";
	b += '<div class="col-md-12 ilist-listing">';
	b += '<div class="row">';
	b += '<img src="' + base_url + 'assets/img/ajaxLoading.gif" alt="" class="img-responsive">';
	b += "</div>";
	b += "</div>";
	b += '<div class="clearfix"></div>';
	$("#details_table_cls").html(b);
	SendData = "Val="+val;
	$.ajax({
		url: site_url + "admin/ClassManageDetails",
		type: "POST",
		data: SendData,
		dataType: "json",
		success: function (d) {
			$("#details_table_cls").html("");
			$("#ucd_but").css("background-color", "#95bcf2");
			$("#rcd_but").css("background-color", "#FFFFFF");
			$("#ued_but").css("background-color", "#FFFFFF");
			$("#update_cls").show();
			$("#refresh_db").hide();
			$("#update_eve").hide();
			apply_class_data(d);
		}
	})
}

function apply_class_data(n, srch) {
	var o = '';
	o += '<div class="table-responsive">';
	o += '<div class="table-scrollable">';
	o += '<table class="table table-striped table-hover table-bordered">';
	o += '<thead>';
	o += '<tr>';
	o += '<th>';
	o += 'Semester';
	o += '</th>';
	o += '<th>';
	o += 'Department';
	o += '</th>';
	o += '<th>';
	o += 'Class Code';
	o += '</th>';
	o += '<th>';
	o += 'Class Name';
	o += '</th>';
	o += '<th>';
	o += 'Batch Number';
	o += '</th>';
	o += '<th>';
	o += 'Professor';
	o += '</th>';
	o += '<th>';
	o += 'Capacity';
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
		o += '<td colspan="9">';
		o += 'No result found';
		o += '</td>';
		o += '</tr>';
	} else {
		$.each(n, function () {
			$.each(this, function (b, d) {
				if (d.id!= null) {
					var batchArr = d.title.split(' Batch NO:');
					o += '<tr id="tr_'+d.id+'">';
					o += '<td>';
					o += d.semester;
					o += '</td>';
					o += '<td>';
					o += d.department;
					o += '</td>';
					o += '<td>';
					o += d.course_no;
					o += '</td>';
					o += '<td>';
					o += batchArr[0];
					o += '</td>';
					o += '<td>';
					o += batchArr[1];
					o += '</td>';
					o += '<td>';
					o += d.professor;
					o += '</td>';
					o += '<td>';
					o += d.capacity;
					o += '</td>';
					o += '<td>';
					o += '<a class="edit" href="javascript:;" onclick="edit_row_class('+d.id+')"> Edit </a>';
					o += '</td>';
					o += '<td>';
					o += '<a class="delete" href="javascript:;" onclick="delete_row_class('+d.id+', \''+srch+'\')"> Delete </a>';
					o += '</td>';
					o += '</tr>';
				}
			})
		});
	}
	o += '</tbody>';
	o += '</table>';
	o += pagination_datacoll_class(n, srch);
	o += '</div>';
	o += '</div>';
	o += '</div>';
	$("#details_table_cls").html(o);
};

function edit_row_class(Val)
{
	SendData = "Val="+Val;
	$.ajax({
		url: site_url + "admin/EditClassDetails",
		type: "POST",
		data: SendData,
		dataType: "json",
		success: function (d) {
			edit_row_data_class(d);
		}
	})
}

function delete_row_class(Val, srch)
{
	if(confirm("You sure to delete this details"))
	{
		SendData = "Val="+Val;
		$.ajax({
			url: site_url + "admin/DeleteClassDetails",
			type: "POST",
			data: SendData,
			dataType: "json",
			success: function (d) {
				get_class_details_data(1, srch);
			}
		});
	}
}

function edit_row_data_class(n)
{
	var o ='';
	$.each(n, function () {
		$.each(this, function (b, d) {
			if (d.id != null) {
				var batchArr = d.title.split(' Batch NO:');
				o += '<td>';
				o += '<input type="hidden" name="UniVal" id="UniVal" class="form-control input-small" value="' + d.uni_id + '">';
				o += '<input type="text" name="val1" id="val1" class="form-control input-small" value="' + d.semester + '">';
				o += '</td>';
				o += '<td>';
				o += '<input type="text" name="val2" id="val2" class="form-control input-small" value="' + d.department + '">';
				o += '</td>';
				o += '<td>';
				o += '<input type="text" name="val3" id="val3" class="form-control input-small" value="' + d.course_no + '">';
				o += '</td>';
				o += '<td>';
				o += '<input type="text" name="val4" id="val4" class="form-control input-small" value="' + batchArr[0] + '">';
				o += '</td>';
				o += '<td>';
				o += '<input type="text" name="val5" id="val5" class="form-control input-small" value="' + batchArr[1] + '">';
				o += '</td>';
				o += '<td>';
				o += '<input type="text" name="val6" id="val6" class="form-control input-small" value="' + d.professor + '">';
				o += '</td>';
				o += '<td>';
				o += '<input type="text" name="val7" id="val7" class="form-control input-small" value="' + d.capacity + '">';
				o += '</td>';
				o += '<td>';
				o += '<a class="Save" href="javascript:;" onclick="save_row_class('+d.id+')"> Save </a>';
				o += '</td>';
				o += '<td>';
				o += '<a class="Cancel" href="javascript:;" onclick="cancel_row_class('+d.id+')"> Cancel </a>';
				o += '</td>';
			}
		});
	});
	$("#tr_"+n.Val).html(o);
}

function save_row_class(Val)
{
	var val1 = $("#val1").val();
	var val2 = $("#val2").val();
	var val3 = $("#val3").val();
	var classnm = $("#val4").val();
	var batchno = $("#val5").val();
	var val5 = $("#UniVal").val();
	var val6 = $("#val6").val();
	var val7 = $("#val7").val();
	var val4 = classnm+' Batch NO:'+batchno;
	
	SendData = "Val="+Val+"&val1="+val1+"&val2="+val2+"&val3="+val3+"&val4="+val4+"&val5="+val5+"&val6="+val6+"&val7="+val7;
	$.ajax({
		url: site_url + "admin/SaveClassDetails",
		type: "POST",
		data: SendData,
		dataType: "json",
		success: function (d) {
			display_row_data_class(d);
		}
	})
}

function cancel_row_class(Val)
{
	SendData = "Val="+Val;
	$.ajax({
		url: site_url + "admin/ClassManageDetails",
		type: "POST",
		data: SendData,
		dataType: "json",
		success: function (d) {
			display_row_data_class(d);
		}
	})
}

function display_row_data_class(n)
{
	var o ='';
	$.each(n, function () {
		$.each(this, function (b, d) {
			if (d.id != null) {
				var batchArr = d.title.split(' Batch NO:');
				o += '<td>';
				o += d.semester;
				o += '</td>';
				o += '<td>';
				o += d.department;
				o += '</td>';
				o += '<td>';
				o += d.course_no;
				o += '</td>';
				o += '<td>';
				o += batchArr[0];
				o += '</td>';
				o += '<td>';
				o += batchArr[1];
				o += '</td>';
				o += '<td>';
				o += d.professor;
				o += '</td>';
				o += '<td>';
				o += d.capacity;
				o += '</td>';
				o += '<td>';
				o += '<a class="edit" href="javascript:;" onclick="edit_row_class('+d.id+')"> Edit </a>';
				o += '</td>';
				o += '<td>';
				o += '<a class="delete" href="javascript:;" onclick="delete_row_class('+d.id+')"> Delete </a>';
				o += '</td>';
			}
		});
	});
	$("#tr_"+n.Val).html(o);
}

function pagination_datacoll_class(i, srch) {
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
			n += '<li><a class="pageButton" id="page-' + (m - 1) + '" href="javascript:void(0);" onclick="nxt_pagcoll_class(' + (m - 1) + ", '" + srch + "');\"><<</a></li>"
		}
		for (var k = m; k <= l; k++) {
			n += '<li' + (i.currentPage == k ? ' class="active"' : "") + '><a class="pageButton" id="page-' + k + '" href="javascript:void(0);" onclick="nxt_pagcoll_class(' + k + ", '" + srch + "');\">" + k + "</a></li>"
		}
		if (l < (1 * i.totalPages)) {
			n += '<li><a class="pageButton" id="page-' + (l + 1) + '" href="javascript:void(0);" onclick="nxt_pagcoll_class(' + (l + 1) + ", '" + srch + "');\">>></a></li>"
		}
		n += "</ul></div>"
	}
	return n
}

function nxt_pagcoll_class(h, srch) {
	get_class_data(h, srch)
}
