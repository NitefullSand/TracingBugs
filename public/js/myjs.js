// function editBug(id) {
// 	  var xmlhttp;
// 	  if (window.XMLHttpRequest)
// 	  {
// 	    // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
// 	    xmlhttp=new XMLHttpRequest();
// 	  }
// 	  else
// 	  {
// 	    // IE6, IE5 浏览器执行代码
// 	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
// 	  }
// 	  xmlhttp.onreadystatechange=function()
// 	  {
// 	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
// 	    {
// 	    	document.getElementById('createBugForm').innerHTML = xmlhttp.responseText;
// 	    }
// 	  }
// 	  xmlhttp.open("GET",document.URL+"/bug_edit/"+id,true);
// 	  xmlhttp.send();
// }

$(document).ready(function(){
	// 点击Bug列表后，使用ajax加载Bug编辑页面
	$("tr.bugList").click(function(){
		getBugForm($(this));
	});

	$("#a_bugAdd").click(function(){
		getBugForm($(this));
	});

	showUsersPanel();
});


function showUsersPanel() {
	$("#orgUsersPanel").click(function(){
		var oId = $(this).data('id');
		$("#manageModalTitle").text('组织成员');
		getUserList('/organization/'+oId+'/users');
	});

	$("#usersPanel").click(function(){
		var pId = $(this).data('id');
		$("#manageModalTitle").text('项目成员');
		getUserList('/project/'+pId+'/users');
	});
}

function addOrgUser() {
	$("#btn_addOrgUser").click(function(){
		var oId = $(this).data('oid');
		var user_email = $("#user_email").val();
		var role = $("#role").val();

		$.get('/organization/'+ oId + '/user_add', {
			user_email: user_email,
			role: role
		},  function(data, status){
			if(status=="success" && data == "true") {
				getUserList('/organization/'+oId+'/users');
			};
		});
	});
}

function delOrgUser() {
	$('button.btn_delOrgUser').click(function(){
		var oId = $(this).data('oid');
		var rId = $(this).data('rid');

		$.get('/organization/'+ oId + '/user_del', {
			rId: rId
		},  function(data, status){
			if(status=="success" && data =="true") {
				getUserList('/organization/'+oId+'/users');
			};
		});
	});
}

// “添加成员”按钮
function addProUser() {
	$("#btn_addProUser").click(function(){
		var pId = $(this).data('pid');
		var uId = $("#user_id").val();
		var role = $("#role").val();

		$.get('/project/'+ pId + '/user_add', {
			uId: uId,
			role: role
		},  function(data, status){
			if(status=="success" && data == "true") {
				getUserList('/project/'+pId+'/users');
			};
		});
	});
}

function delProUser() {
	$('button.btn_delProUser').click(function(){
		var pId = $(this).data('pid');
		var rId = $(this).data('rid');

		$.get('/project/'+ pId + '/user_del', {
			rId: rId
		},  function(data, status){
			if(status=="success" && data =="true") {
				getUserList('/project/'+pId+'/users');
			};
		});
	});
}

// 使用ajax加载并显示项目成员
function getUserList(url) {
	$.get(url, function(data, status){
		if (status == "success") {
			$("#manageModalContent").html(data);
		} else {
			alert("加载页面失败: " + status);
		}
	});
}

function getBugForm(object) {
	var bId = $(object).data('id');
	$.get(document.URL+'/bug_edit/'+bId, function(data, status){
		if(status == "success") {
    		$("#createBugForm").html(data);
		} else {
			alert("加载页面失败: " + status);
		}
	});
}