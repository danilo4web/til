// Initialize your app
var myApp = new Framework7({
	material: true,
	pushState: true,
	onAjaxStart: function(xhr) {
		myApp.showIndicator();
	},
	onAjaxComplete: function(xhr) {
		myApp.hideIndicator();
	}
});

// Export selectors engine
var $$ = Dom7;

// Add view
var mainView = myApp.addView('.view-main', {
    domCache: true,
});


$$(document).on('pageInit', function(e) {
	var page = e.detail.page;
	
	if(page.name === 'about') {
		var count  = page.query.count;
		
		var listHTML = '<ul>';
		for(var i = 0; i < count; i++) {
			listHTML += '<li>' + i + '</li>';	
		}
		listHTML += '</ul>';
		
		$$(page.container).find('.page-content').append(listHTML);
	}
	
	if(page.name === 'products') {
		
		// showpop
		$$('#show_popup').click(function() {
			mainView.router.loadContent($$('#ourNewPopPage').html());
		});
	}	

});

/*
$$(document).on('pageInit', '.page[data-page="about"]', function(e) {
	alert('So something crazy');
});
*/




myApp.onPageInit('about', function(e) {
	// alert('Do something!!!');
});






//// Callbacks to run specific code for specific pages, for example for About page:
//myApp.onPageInit('about', function (page) {
//	
//    // run createContentPage func after link was clicked
//    $$('.create-page').on('click', function () {
//        createContentPage();
//    });
//});

// Generate dynamic page
var dynamicPageIndex = 0;

function createContentPage() {
	mainView.router.loadContent(
        '<!-- Top Navbar-->' +
        '<div class="navbar">' +
        '  <div class="navbar-inner">' +
        '    <div class="left"><a href="#" class="back link"><i class="icon icon-back"></i><span>Back</span></a></div>' +
        '    <div class="center sliding">Dynamic Page ' + (++dynamicPageIndex) + '</div>' +
        '  </div>' +
        '</div>' +
        '<div class="pages">' +
        '  <!-- Page, data-page contains page name-->' +
        '  <div data-page="dynamic-pages" class="page">' +
        '    <!-- Scrollable page content-->' +
        '    <div class="page-content">' +
        '      <div class="content-block">' +
        '        <div class="content-block-inner">' +
        '          <p>Here is a dynamic page created on ' + new Date() + ' !</p>' +
        '          <p>Go <a href="#" class="back">back</a> or go to <a href="services.html">Services</a>.</p>' +
        '        </div>' +
        '      </div>' +
        '    </div>' +
        '  </div>' +
        '</div>'
    );
	return;
}