/* Japanese initialisation for the jQuery UI date picker plugin. */
/* Written by Kentaro SATO (kentaro@ranvis.com). */
jQuery(function($){
	$.datepicker.regional['ja'] = {
		closeText: '•Â‚¶‚é',
		prevText: '&#x3c;‘O',
		nextText: 'Ÿ&#x3e;',
		currentText: '¡“ú',
		monthNames: ['1Œ','2Œ','3Œ','4Œ','5Œ','6Œ',
		'7Œ','8Œ','9Œ','10Œ','11Œ','12Œ'],
		monthNamesShort: ['1Œ','2Œ','3Œ','4Œ','5Œ','6Œ',
		'7Œ','8Œ','9Œ','10Œ','11Œ','12Œ'],
		dayNames: ['“ú—j“ú','Œ—j“ú','‰Î—j“ú','…—j“ú','–Ø—j“ú','‹à—j“ú','“y—j“ú'],
		dayNamesShort: ['“ú','Œ','‰Î','…','–Ø','‹à','“y'],
		dayNamesMin: ['“ú','Œ','‰Î','…','–Ø','‹à','“y'],
		weekHeader: 'T',
		dateFormat: 'yy/mm/dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '”N'};
	$.datepicker.setDefaults($.datepicker.regional['ja']);
});