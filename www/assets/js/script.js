$(function () {
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

	$('#autocomplete').autocomplete({
		appendTo: '.autocomplete-results',
		source: '/api/cyclistes'
	}).data("ui-autocomplete")._renderItem = function (ul, item) {
		var newText = String(item.value).replace(
			new RegExp(this.term, "gi"),
			"<span class='ui-state-highlight'>$&</span>");

		return $("<li></li>")
			.data("item.autocomplete", item)
			.append("<a>" + newText + "</a>")
			.appendTo(ul);
	};;
});