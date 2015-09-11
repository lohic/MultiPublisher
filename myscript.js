jQuery(document).ready(function($) {
	// Find posts
	var $findBox = $('#find-posts'),
	$found   = $('#find-posts-response'),
	$findBoxSubmit = $('#find-posts-submit');

	// Open
	$('input.kc-find-post').live('dblclick', function() {
		$findBox.data('kcTarget', $(this));
		findPosts.open();
  	});

  	// Insert
	$findBoxSubmit.click(function(e) {
	  	e.preventDefault();

	    // Be nice!
	    if ( !$findBox.data('kcTarget') )
	    	return;

	    var $selected = $found.find('input:checked');
	    if ( !$selected.length )
	    	return false;

	    var $target = $findBox.data('kcTarget'),
	    current = $target.val(),
	    current = current === '' ? [] : current.split(','),
	    newID   = $selected.val();

	    if ( $.inArray(newID, current) < 0 ) {
	    	current.push(newID);
	    	$target.val( current.join(',') );
	    }
	});

	// Double click on the radios
	$('input[name="found_post_id"]', $findBox).live('dblclick', function() {
		$findBoxSubmit.trigger('click');
	});

	// Close
	$( '#find-posts-close' ).click(function() {
		$findBox.removeData('kcTarget');
	});
});