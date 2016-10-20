$(document).ready(function() {
	$("#delete").click(function() {
		if (confirm("Are you sure you want to delete this?")) {
			var href = $(this).attr('href');
			window.location.href = href;
		}
	});
});