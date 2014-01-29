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

	$('.dataTables_wrapper *').css('background-color', 'red');

	$('table.contains-data').dataTable( {
		"oLanguage": { "sUrl": "/assets/js/vendor/jquery.dataTables.fr.json" },
		"iDisplayLength": 20,
		"fnInitComplete": function(oSettings, json) {
			$('.dataTables_filter input').attr('placeholder', 'Rechercher…');

			if($(this).is('.first-desc')) {
				$(this).dataTable().fnSort([ [0, 'desc'] ]);
			}
		},
		"fnDrawCallback": function(oSettings) {
			$(this).removeHighlight();
			if($('.dataTables_filter input').val() != '') {
				$('table.contains-data').highlight($('.dataTables_filter input').val());
			}
		}
	});
});