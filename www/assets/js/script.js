jQuery().ready(function () {
	$('.exception.message').css('cursor', 'help');
	$('.exception.trace, .hide-script').hide();

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

	var recompenseModifiee = null;
	$('.modifier-recompense').click(function(e) {
		e.preventDefault();

		recompenseModifiee = $(this).attr('data-number');

		// Désactivation de tous les autres champs
		$('tr').find('td:has(span) span, td:has(a) .modifier-recompense').show();
		$('tr').find('td:has(span) input, td:has(a) .ok-modif-recompense').hide();

		var trConcerne = $('tr[data-number=' + recompenseModifiee + ']');

		trConcerne.find('td:has(span) span, td:has(a) .modifier-recompense').hide();
		trConcerne.find('td:has(span) input, td:has(a) .ok-modif-recompense').show();

		trConcerne.find('td:has(span) input').focus();
	});

	$('.ajax-editable').submit(function(e) {
		e.preventDefault();

		$.ajax({
			'type': 'POST',
			'url': '/api/modifier-recompense',
			'data': {
				'NbParticipation': recompenseModifiee,
				'LibRecompense': $('tr[data-number=' + recompenseModifiee + '] input').val()
			},
			'success': function() {
				$('tr[data-number=' + recompenseModifiee + '] span').html($('tr[data-number=' + recompenseModifiee + '] input').val());
			},
			'error': function() {
				$('.ajax-editable>div div.alert-box.alert').remove();
				$('.ajax-editable>div').prepend($('<div />').addClass('alert-box alert').html('Impossible de mettre à jour l\'élément...'));
			}
		});

		$('tr').find('td:has(span) span, td:has(a) .modifier-recompense').show();
		$('tr').find('td:has(span) input, td:has(a) .ok-modif-recompense').hide();
	})
});