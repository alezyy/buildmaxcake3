runMeter($("#FullSchedule").val());
$(document).ready(function() {
        var c = $("#password_meter_div").detach().show();
        $("#FullSchedule").popover({html: !0, title: $("#meter_title").text(), content: c, trigger: "focus", placement: "right"});
        $("#FullScheduleConfirm").tooltip({title: $("#pw_match").detach().show().text(), trigger: "manual", placement: "top"});
        $("#FullScheduleConfirm").focusout(function() {
                $("#FullScheduleConfirm").tooltip("hide")
        });
        $("#FullScheduleConfirm").focus(function() {
                var a = $("#FullSchedule").val();
                $(this).val() === a && "" !== a && $("#FullScheduleConfirm").tooltip("show")
        });
//$("#FullSchedule").hover(function(){$("#FullScheduleConfirm").parent().parent().removeClass("error").removeClass("success");runMeter($(this).val())});$("#FullScheduleConfirm").hover(function(){""===$("#FullSchedule").val()?($(this).parent().parent().removeClass("error").removeClass("success"),$("#FullScheduleConfirm").tooltip("hide")):$(this).val()===$("#FullSchedule").val()?($(this).parent().parent().removeClass("error").addClass("success"),$("#FullScheduleConfirm").tooltip("show")):($(this).parent().parent().removeClass("success").addClass("error"),
        $("#FullSchedule").hover(function() {
                $("#FullScheduleConfirm").parent().parent().removeClass("error").removeClass("success");
                runMeter($(this).val())
        });
        $("#FullScheduleConfirm").hover(function() {
                "" === $("#FullSchedule").val() ? ($(this).parent().parent().removeClass("error").removeClass("success"), $("#FullScheduleConfirm").tooltip("hide")) : $(this).val() === $("#FullSchedule").val() ? ($(this).parent().parent().removeClass("error").addClass("success"), $("#FullScheduleConfirm").tooltip("show")) : ($(this).parent().parent().removeClass("success").addClass("error"),
                        $("#FullScheduleConfirm").tooltip("hide"))
        })
});
function runMeter(c) {
        var a = checkPassword(c), d = getOccurrences(c);
        reset_meter();
        $("#FullScheduleConfirm").tooltip("hide").val("");
        90 <= a ? ($("#verystrong").show(), $("#password_meter").addClass("progress-success"), $("#FullSchedule").parent().parent().addClass("success")) : 80 <= a ? ($("#strong").show(), $("#password_meter").addClass("progress-success"), $("#FullSchedule").parent().parent().addClass("success")) : 60 <= a ? ($("#strong").show(), $("#password_meter").addClass("progress-info"), $("#FullSchedule").parent().parent().addClass("success")) :
                30 <= a ? ($("#average").show(), $("#password_meter").addClass("progress-warning")) : (15 < a ? $("#weak").css("color", "white") : $("#weak").css("color", "black"), $("#weak").show(), $("#password_meter").addClass("progress-danger"));
        $(".bar").css("width", a + "%");
        8 < c.length && ($("#password_length").addClass("text-success"), $("#password_length i").show());
        0 < d.lower && ($("#lower_case").addClass("text-success"), $("#lower_case i").show());
        0 < d.upper && ($("#upper_case").addClass("text-success"), $("#upper_case i").show());
        0 <
                d.digits && ($("#numbers").addClass("text-success"), $("#numbers i").show());
        0 < d.symbols && ($("#symbols").addClass("text-success"), $("#symbols i").show())
}
function reset_meter() {
        $("#weak").hide();
        $("#average").hide();
        $("#strong").hide();
        $("#verystrong").hide();
        $("#password_meter").removeClass("progress-danger").removeClass("progress-info").removeClass("progress-success").removeClass("progress-warning");
        $("#password_length").removeClass("text-success");
        $("#lower_case").removeClass("text-success");
        $("#upper_case").removeClass("text-success");
        $("#numbers").removeClass("text-success");
        $("#symbols").removeClass("text-success");
        $("#password_length i").hide();
        $("#lower_case i").hide();
        $("#upper_case i").hide();
        $("#numbers i").hide();
        $("#symbols i").hide();
        $("#FullSchedule").parent().parent().removeClass("success");
}