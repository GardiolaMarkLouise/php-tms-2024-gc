function editUser(that) {
  user_id = $(that).attr("data-id");
  username = $(that).attr("data-username");
  user_type = $(that).attr("data-user-type");
  acc_name = $(that).attr("data-acc-name");
  team_assigned = $(that).attr("data-team-assigned");

  $("#user_id").val(user_id);
  $("#username").val(username);
  $("#user-type").val(user_type);
  $("#acc_name").val(acc_name);
  $("#team_assigned").val(team_assigned);
}

function editTeam(that) {
  team_id = $(that).attr("data-team-id");
  team_name = $(that).attr("data-team-name");
  team_color = $(that).attr("data-team-color");

  $("#team_id").val(team_id);
  $("#team_name").val(team_name);
  $("#team_color").val(team_color);
}

function editEmployee(that) {
  id = $(that).attr("data-id");
  fname = $(that).attr("data-fname");
  mname = $(that).attr("data-mname");
  lname = $(that).attr("data-lname");
  emp_id_no = $(that).attr("data-employee-id");
  // dept = $(that).attr("data-department");
  age = $(that).attr("data-age");
  gender = $(that).attr("data-gender");
  sports = $(that).attr("data-sports");
  team = $(that).attr("data-team");
  team_leader = $(that).attr("data-team-leader");

  $("#emp_id").val(id);
  $("#fname").val(fname);
  $("#mname").val(mname);
  $("#lname").val(lname);
  $("#emp_id_no").val(emp_id_no);
  // $("#department").val(dept);
  $("#age").val(age);
  $("#gender").val(gender);
  $("#sports").val(sports);
  $("#team").val(team);
  $("#team_leaders").val(team_leader);
}

$(".toggle-password").click(function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

function goBack() {
  window.history.go(-1);
}
