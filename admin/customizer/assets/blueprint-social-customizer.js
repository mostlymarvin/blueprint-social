(function($) {

	jQuery(document).ready(function($){

	$('#add_link').on('click', function() {
		var row = $('.empty-link').clone(true);
		row.removeClass('empty-link');
		row.addClass('ui-state-default');
		row.insertBefore('#blueprint-social-list li:last-child');
		return false;
	});
	$( '#sort_links' ).on('click', function() {
		$( '#blueprint-social-list' ).addClass('enable-sort').sortable(
			{
				opacity: 0.6,
				revert: true,
				cursor: 'move',
				handle: '.sort_handle',
				placeholder: 'ui-state-highlight',
				start: function( event, ui ) {
				$(ui.item).css({
				   'opacity': '1',
				   'width' : '80%',
				   'max-width' : '100%',
				   'height' : 'auto',
				   });
				$(ui.item).addClass('onthemove');
				},
				stop:function( event, ui ) {
				   $(ui.item).removeClass('onthemove').addClass('changed');

				},
				update: function(event, ui) {
					bpsGetAllInputs($(this).parent());
				}
				}
		);
		$(this).attr("disabled", "disabled");
		$('#save_sort').fadeIn();
	});

	$('#save_sort').on('click', function() {
		$(this).fadeOut();
		bpsGetAllInputs($('#blueprint-social-list').parent());
		$('#sort_links').removeAttr("disabled", "disabled");
	});

	$('.remove_link').on('click', function() {
		$(this).parent('li').remove();
		bpsGetAllInputs($('#blueprint-social-list').parent());
		return false;
	});

	$( '.repeater select' ).change(function () {
		var selectval = this.value;
		$(this).next('.network-choice').val(selectval);

		bpsGetAllInputs($('#blueprint-social-list').parent());
	});


	$('.network-url').change(function() {
		bpsGetAllInputs($('#blueprint-social-list').parent());
	});

	$('.network-url').on('input', function(){
		bpsGetAllInputs($('#blueprint-social-list').parent());
	});


	function bpsGetAllInputs($element) {
		var networks = [];

		$( ".network-url" ).each(function( index ) {
			var netchoice = $(this).prev('.network-choice').val();
			var neturl = $(this).val();

			networks.push({
				'network' :netchoice,
				'url' :neturl,
			});
		  });

		 var networkObj =  JSON.stringify( networks );


		$element.find('.customize-control-sortable-repeater').val(networkObj);

		$element.find('.customize-control-sortable-repeater').trigger('change');

		}


	});


})(jQuery);
