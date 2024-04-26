(function($) {
	const $wrapper = $('<div class="inspire-settings"></div>');
	$wrapper.append($('<div class="inspire-main-content"></div>'));
	$("#posts-filter, .subsubsub").wrapAll($wrapper);
	$("#marketing-page-wrapper").wrapAll($wrapper);

	const $sidebar = $('<div class="inspire-sidebar metabox-holder"></div>');
	if ( !nonCptBoxes.is_pro_active ) {
		const $upgradeNowBox = $(nonCptBoxes.upgrade_now_content);
		$sidebar.prepend($upgradeNowBox);
	}
	const $docsBox = $(nonCptBoxes.start_here_content);
	$sidebar.append($docsBox);
	$(".inspire-settings").append($sidebar);
})(jQuery);
