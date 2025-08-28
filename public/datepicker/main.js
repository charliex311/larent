$(document).ready(function() {
	$('.normalDate').datetimepicker({
		allowInputToggle: true,
		showClose: true,
		showClear: true,
		showTodayButton: true,
		format: "hh:mm A DD/MM/YYYY",
		icons: {
			time: 'far fa-clock',
			date: 'fas fa-calendar-alt',
			up: 'fas fa-chevron-up',
			down: 'fas fa-chevron-down',
			previous: 'fas fa-chevron-left',
			next: 'fas fa-chevron-right',
			today: 'fas fa-chevron-up',
			clear: 'fas fa-trash-alt',
			close: 'far fa-window-close'
		}
	});
});