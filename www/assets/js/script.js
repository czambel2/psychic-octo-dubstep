jQuery().ready(function () {
	$('.exception.message').css('cursor', 'help');
	$('.exception.trace').hide();

	$('.exception.message').click(function () {
		if ($('.exception.trace').is(':visible')) {
			$('.exception.message').css('cursor', 'help');
			$('.exception.trace').slideUp(150);
		} else {
			$('.exception.message').css('cursor', 'pointer');
			$('.exception.trace').slideDown(150);
		}
	});

	$('table.contains-data').dataTable({
		"oLanguage": { "sUrl": "/assets/js/vendor/jquery.dataTables.fr.json" },
		"iDisplayLength": 20
	});
});