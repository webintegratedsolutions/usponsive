// JavaScript Document
// Grandiox Layout & Responsive JavaScript functions

var calls = 0;

// Initialize viewSize variable
var viewSize = 0;

// IE6/7 safe event binding
function gxAddEvent(el, evt, fn) {
	if (!el) return;
	if (el.addEventListener) {
		el.addEventListener(evt, fn, false);
	} else if (el.attachEvent) {
		el.attachEvent('on' + evt, fn);
	} else {
		el['on' + evt] = fn;
	}
}

// IE6/7 safe class helpers (no classList)
function gxHasClass(el, cls) {
	if (!el || !el.className) return false;
	return (' ' + el.className + ' ').indexOf(' ' + cls + ' ') !== -1;
}
function gxAddClass(el, cls) {
	if (!el) return;
	if (!gxHasClass(el, cls)) {
		el.className = el.className ? (el.className + ' ' + cls) : cls;
	}
}
function gxRemoveClass(el, cls) {
	if (!el || !el.className) return;
	var s = ' ' + el.className + ' ';
	while (s.indexOf(' ' + cls + ' ') !== -1) {
		s = s.replace(' ' + cls + ' ', ' ');
	}
	el.className = s.replace(/^\s+|\s+$/g, '');
}

// window.resize callback function
function getDimensions() {
    calls += 1;
    console.log("Resize event: " + calls);

    // Optional debug output: if an element with id="w" exists, show current width
    var wEl = document.getElementById('w');
    if (wEl) {
        wEl.textContent = String(window.innerWidth);
    }
}

//lListen for window.resize
gxAddEvent(window, 'resize', getDimensions);

// call once to initialize page
getDimensions();



//ADMIN FUNCTIONS
//create adminMessages array
var adminMessages = new Array();

//Function: showAdminData
//Add new string to admin messages report
function addAdminMsg(type, condition, message) {

	var admMsgTerms = condition + "() - " + message + "<br />"

	switch (type) {

		case "task":
			adminMessages.push("#: " + admMsgTerms);
			break;

		case "status":
			adminMessages.push("!: " + admMsgTerms);
			break;

		default:
			adminMessages.push("?: " + admMsgTerms);
			break;

	}

}

//Function: showAdminData
//Display admin messages report string
function showAdminData() {

	//set default admin data variables
	var showAdminData = "0";
	var report = "";

	//show admin messages (if showAdminData is 1 is query string)
	if (getQueryString("showAdminData") == 1 && getQueryString("report") == "responsive") {

		//Set defaults for admin messages report string
		adminMessages.unshift('<strong>Admin Data (Client) - Responsive Report:</strong><br /><small># - Task, ! - Status, ? - Case</small><br /><br />');

		document.getElementById('cadata').innerHTML = adminMessages.join(" ");
		document.getElementById('cadata').style.display = "block";

	}

}

//GX FUNCTIONS

//Function: getViewSize
// 1. Get page view size
function getViewSize() {

	//outWidth property only supported on desktop ie8 and over, however, it is not needed in such as the outerWidth would never exceed the innerWidth, (but only on mobile devices with false dpis values).
	/*
	Window.outerWidth read-only property returns the width of the outside of the browser window. 
	It represents the width of the whole browser window including sidebar (if expanded), window chrome and window resizing borders/handles.
	*/
	var vpOuterWidth = window.outerWidth;

	// vpInnerWidth
	//To target older browsers, we will have to alter how we access clientWidth.
	var vpInnerWidth = document.body.clientWidth;

	// Default to innerWidth
	viewSize = vpInnerWidth;

	// If outerWidth is available and smaller, use it
	if (vpOuterWidth && vpOuterWidth > 0 && vpOuterWidth < vpInnerWidth) {
    	viewSize = vpOuterWidth;
	}

	//add admin message
	addAdminMsg("task", "getViewSize", "viewSize (page view size) size is: <strong>" + viewSize + "</strong>");

	return viewSize;

}

//Function: adjustScreenSizeTimeout
/*
This function is called after a 200 millisecond timeout after page load. 
It rechecks the calculated viewSize once again in the background. 
If the recalculated viewsize is smaller than the original calculation the gxResponsive functions are reloaded in order to capture the correct viewsize. 
This function was design to address the bug that occurs in some mobile browsers such as android 2.3 which has a lag in determining the correct screen size.
*/
function adjustScreenSizeTimeout(startViewSize) {
	//recheck the calculated viewSize
	getViewSize();
	if (startViewSize > viewSize) {

		// load responsive functions
		gxResponsive();

		//add admin message
		addAdminMsg("task", "adjustScreenSizeTimeout", "<strong>Adjust Screen Size Timeout</strong> has been activated.");

	}
}

//ONLOAD FUNCTIONS
/*
This event is fired when the whole page has loaded, including all dependent resources such as stylesheets and images. 
This is in contrast to DOMContentLoaded, which is fired as soon as the page DOM has been loaded, without waiting for resources to finish loading.
The window. onload event gets fired when all resources - including images, external script, CSS - of a page have been loaded. 
If you want to do something when that event has been fired you should always use the window.
*/
DOMContentLoaded(function () {

    var pageViewMode = (typeof getQueryString("viewMode") === 'undefined') ? 'default' : getQueryString("viewMode");
    var pageViewModeForce = "none";
    var pageInspectionMode = "normal";

    addAdminMsg("status", "Page View Mode", pageViewMode);

    if (pageViewMode == "fullSize") {

        gxFullSize();

    } else {

        pageViewMode = "responsive";

        if (getQueryString("viewMode") == "collapseSingle") {
            pageViewModeForce = "collapseSingle";
        } else if (getQueryString("viewMode") == "collapseDual") {
            pageViewModeForce = "collapseDual";
        }

        gxResponsive(pageViewModeForce, pageInspectionMode);

        setTimeout(function () {
            adjustScreenSizeTimeout(viewSize);
        }, 200);
    }
	addAdminMsg("status", "DOMReady", "DOM fully loaded and parsed");
    showAdminData();
});

// Reset responsive body classes before applying new responsive rules
function resetResponsiveBodyClasses() {
	// Only remove classes that THIS script manages (IE6/7 safe; no classList)
	gxRemoveClass(document.body, 'under640');
	gxRemoveClass(document.body, 'nav-collapse');
	gxRemoveClass(document.body, 'header-collapse');
	gxRemoveClass(document.body, 'under480');
	gxRemoveClass(document.body, 'maincollapse');
}

//PAGE LOAD FUNCTIONS

function gxPageFunctions() {

	// get page view width
	getViewSize();

	// check active page regions
	checkActivePageRegions();

	// adjust layout according to active/inactive page regions
	adjustLayoutByRegions();

	//if page inspection mode is set to see egions by color call the function to add the color settings
	if (getQueryString("inspectionMode") == "seeRegionsByColor") {
		pageInspectionMode = "seeRegionsByColor";
		setSeeRegionsByColor();
	}

	if (pageBgImage == "active") {
		// background image scaling
		document.getElementById("bgimage").style.minWidth = "640px";
	}

}

//load gx Responsive functions
function gxResponsive(pageViewModeForce) {

	// Call gx page functions (which are common to both responsive and full-size view modes)
	gxPageFunctions();

	// Reset the responsive <body> classes before re-applying them
	resetResponsiveBodyClasses();

	if (pageViewModeForce == "collapseDual") {
		viewSize = 541;
		layoutSize = "small";
	} else if (pageViewModeForce == "collapseSingle") {
		viewSize = 319;
		layoutSize = "xx-small";
	}

	var mainWidth = document.getElementById('main').offsetWidth;
	if (mainWidth < 548) {
		//Apply maincollapse
		document.body.classList.add('maincollapse');
	}

	// set page layout size (responsive)
	setLayoutSize(viewSize);

	// update responsive css
	updateResponsiveCSS(viewSize, layoutSize);

}

//load gx Full Size functions
function gxFullSize() {

	//call gx page functions (which are common to both responsive and full-size view modes)
	gxPageFunctions();

	// Reset the responsive <body> classes before re-applying them
	resetResponsiveBodyClasses();

	// If screensize is less than 640 show view-option link
	document.getElementById("footer-region-three").style.display = "block";

	// For full-Size set minimum page width to 640
	setMin640();

	//set meta viewport scale to max 5.0 to allow users to zoom on devices (now that page is at fullsize)
	userViewportScale = document.getElementById('userViewport');
	userViewportScale.setAttribute('content', 'maximum-scale=5.0');

	//add admin message
	addAdminMsg("task", "gxFullSize", "GX Full Size function completed.");

}

// 2. Check which page region are acive
function checkActivePageRegions() {

	regionTopbar = regionHeader = regionNavrow = regionSiteNavigation = regionMetarow = regionLeftcol = regionRightcol = regionMetafooter = regionFooter = regionHeaderOne = regionHeaderTwo = regionHeaderThree = regionFooterOne = regionFooterTwo = regionFooterThree = regionAside = regionSubfooter = pageBgImage = "inactive";

	if (document.getElementById('topbar') != null) { regionTopbar = "active"; }
	if (document.getElementById('header') != null) { regionHeader = "active"; }
	if (document.getElementById('navrow') != null) { regionNavrow = "active"; }
	if (document.getElementById('site-navigation') != null) { regionSiteNavigation = "active"; }
	if (document.getElementById('metarow') != null) { regionMetarow = "active"; }
	if (document.getElementById('leftcol') != null) { regionLeftcol = "active"; }
	if (document.getElementById('rightcol') != null) { regionRightcol = "active"; }
	if (document.getElementById('metafooter') != null) { regionMetafooter = "active"; }
	if (document.getElementById('footer') != null) { regionFooter = "active"; }
	if (document.getElementById('header-region-one') != null) { regionHeaderOne = "active"; }
	if (document.getElementById('header-region-two') != null) { regionHeaderTwo = "active"; }
	if (document.getElementById('header-region-three') != null) { regionHeaderThree = "active"; }
	if (document.getElementById('aside') != null) { regionAside = "active"; }

	if (document.getElementById('metafooter') != null) { metafooter = "active"; }
	if (document.getElementById('column-one') != null) { columnone = "active"; }
	if (document.getElementById('column-two') != null) { columntwo = "active"; }
	if (document.getElementById('column-three') != null) { columnthree = "active"; }

	if (document.getElementById('footer-region-one') != null) { regionFooterOne = "active"; }
	if (document.getElementById('footer-region-two') != null) { regionFooterTwo = "active"; }
	if (document.getElementById('footer-region-three') != null) { regionFooterThree = "active"; }
	if (document.getElementById('subfooter') != null) { regionSubfooter = "active"; }
	if (document.getElementById('bgimage') != null) { pageBgImage = "active"; }
}

// 3. Set responsive CSS layout size
function setLayoutSize(viewSize) {
	if (viewSize < 320) { layoutSize = "xx-small"; }
	else if (viewSize >= 320 && viewSize < 480) { layoutSize = "x-small"; }
	else if (viewSize >= 480 && viewSize < 640) { layoutSize = "small"; }
	else if (viewSize >= 640 && viewSize < 768) { layoutSize = "medium"; }
	else if (viewSize >= 768 && viewSize < 960) { layoutSize = "large"; }
	else if (viewSize >= 960 && viewSize < 1280) { layoutSize = "x-large"; }
	else if (viewSize >= 1280) { layoutSize = "xx-large"; }

// Ensure only ONE layout size class exists on <body> (IE6/7 safe; no classList)
var sizeClasses = ['xx-small', 'x-small', 'small', 'medium', 'large', 'x-large', 'xx-large'];
for (var i = 0; i < sizeClasses.length; i++) {
	gxRemoveClass(document.body, sizeClasses[i]);
}
gxAddClass(document.body, layoutSize);

	//add admin message
	addAdminMsg("task", "setLayoutSize", "Response layout size set to: <strong>" + layoutSize + "</strong>");

	return layoutSize;

}

//Update Responsive CSS
function updateResponsiveCSS(viewSize, layoutSize) {

	//! add admin status message
	addAdminMsg("status", "updateResponsiveCSS", "adjustResponsiveCSS()");

	//3. make general responsive adjustments based on page view size
	adjustResponsiveCSS(viewSize, layoutSize);

	//! add admin status message
	addAdminMsg("status", "updateResponsiveCSS", "Tasks complete!");

}

//make responsive adjustments based on page view and response sizes
function adjustResponsiveCSS(viewSize, layoutSize) {

	//! add admin status message
	addAdminMsg("status", "adjustResponsiveCSS", "adjustMinMax640(), adjustRightCol(), adjustResponseLayout()");

	if (viewSize < 640) { var minMax640 = "max"; } else { var minMax640 = "min"; }

	//?add admin case message
	addAdminMsg("case", "minMax640", "minMax640 layout size set to: <strong>" + minMax640 + "</strong>");

	//call to set page max width for page sizes under 640
	adjustMinMax640(minMax640);

	//call adjustments for rightcol layout for page view sizes under 640
	adjustRightCol(minMax640);

	//call to make specific responsive adjustments for layout size
	adjustResponseLayout(layoutSize);

	//call to append specific responsive css stylesheet for layout size
	//appendResponsiveCSS(layoutSize);

	//! add admin status message
	addAdminMsg("status", "adjustResponsiveCSS", "Tasks complete!");

	//add admin message
	addAdminMsg("task", "adjustResponsiveCSS", "Responsive CSS adjustments made.");

}

/*4. append specific responsive layout stylesheets based on response size
function appendResponsiveCSS(appendStyle) {

	var cssRandomVersion = Math.floor((Math.random() * 100) + 1);
	var appendCSS = appendStyle + '.css';
	var head = document.getElementsByTagName('head')[0];
	var link = document.createElement('link');
	link.id = appendStyle;
	link.rel = 'stylesheet';
	link.type = 'text/css';
	link.href = 'library/css/' + appendCSS + '?ver=1.' + cssRandomVersion + '.26';
	link.media = 'all';
	head.appendChild(link);

	//add admin message
	addAdminMsg("task", "appendResponsiveCSS", "<strong>" + appendCSS + "</strong> response layout stylesheet has been appended.");

}
*/

//adjust rightcol layout for page view sizes under 640
function adjustRightCol(minMax) {

	if (minMax == "max") {

		//Collapse Layout Columns into Dual Columns
		collapseLayoutDualColumn();

		//?add admin case message
		addAdminMsg("case", "adjustRightCol", "Adjustments for <strong>right column UNDER 640</strong> activated.");

	}

	//add admin message
	addAdminMsg("task", "adjustRightCol", "<strong>Min Max 640</strong> right column adjustments made.");

}

//adjust rightcol layout for page view sizes under 640
function adjustMinMax640(minMax640) {

	if (minMax640 == "max") { setMax640(); } else if (minMax640 == "min") { setMin640(); }

	//add admin message
	addAdminMsg("task", "adjustMinMax640", "<strong>Min Max 640</strong> page layout adjustments made.");

}


//Make specific responsive css adjustments according to page layout size
function adjustResponseLayout(layoutSize) {

	if (layoutSize == "xx-small") {

		//prevent page from contracting less than 240 on xx-small screen sizes
		document.getElementById("page-content").style.minWidth = "240px";

	} else if (layoutSize == "x-small") {

		//prevent page from contracting less than 320 on xx-small screen sizes
		document.getElementById("page-content").style.minWidth = "320px";

	} else if (layoutSize == "small") {

		//prevent page from contracting less than 480 on xx-small screen sizes
		document.getElementById("page-content").style.minWidth = "480px";

	} else if (layoutSize == "medium") {


	} else if (layoutSize == "large") {


	} else if (layoutSize == "x-large") {


	} else if (layoutSize == "xx-large") {


	}

	//?add admin case message
	addAdminMsg("task", "adjustResponseLayout", "Specific responsive adjustments made for layout size <strong>" + layoutSize + "</strong>");

}

function setMin640() {

	//set site region minimum widths
	document.getElementById("page-content").style.minWidth = "640px";
	document.getElementById("main").style.minWidth = "240px";

	if (regionRightcol == "active") {
		document.getElementById("rightcol").style.minWidth = "150px";
	}

	if (regionTopbar == "active") {
		document.getElementById("topbar").style.minWidth = "640px";
	}

	if (regionSubfooter == "active") {
		document.getElementById("subfooter").style.minWidth = "640px";
	}

	if (metafooter == "active") {
		document.getElementById("metafooter").style.minWidth = "640px";
	}

	var pageWidth = document.getElementById('page-content').offsetWidth;

	if (pageWidth > viewSize) {
		document.getElementById("page-content").style.width = viewSize + "px";
		if (regionTopbar == "active") {
			document.getElementById("topbar").style.width = viewSize + "px";
			document.getElementById("topbar-content").style.width = viewSize + "px";
		}
		if (regionSubfooter == "active") {
			document.getElementById("subfooter").style.width = viewSize + "px";
		}
	}

	//?add admin case message
	addAdminMsg("case", "adjustMinMax640", "<strong>Min 640</strong> page view adjustments made.");

}

function setMax640() {

	document.getElementById("page-content").style.maxWidth = "640px";
	if (regionNavrow == "active") {
		document.getElementById("navrow").style.maxWidth = "640px";
		document.getElementById("collapse").style.maxWidth = "640px";
	}
	document.getElementById("page-content").style.width = "100%";
	document.getElementById("content").style.padding = "0";
	document.body.style.marginTop = "0";

	//set body classes for under640
	document.body.classList.add('under640');

	if (regionHeaderThree == "active") {
		document.body.classList.add('header-collapse');
	}

	//Collapse Navigation Menu
	if (regionNavrow == "active") {
		document.getElementById("site-navigation").style.display = "none";

		//set body classes for under640
		document.body.classList.add('nav-collapse');
	}

	if (regionTopbar == "active") {
		document.getElementById("topbar").style.width = "100%";
		document.getElementById("topbar").style.maxWidth = "640px";
		document.getElementById("topbar-content").style.width = "100%";
	}

	if (regionSubfooter == "active") {
		document.getElementById("subfooter").style.width = "100%";
		document.getElementById("subfooter").style.maxWidth = "640px";
	}

	if (regionHeaderOne == "active") {
		document.getElementById("header-region-one").style.maxWidth = "507px";
	}

	if (metafooter == "active") {
		document.getElementById("metafooter").style.maxWidth = "640px";
	}

	if (columnone == "active") {
		document.getElementById("column-one").style.width = "100%";
		document.getElementById("column-one").style.textAlign = "center";
	}

	if (columntwo == "active") {
		document.getElementById("column-two").style.width = "100%";
	}

	if (columnthree == "active") {
		document.getElementById("column-three").style.width = "100%";
		document.getElementById("column-three").style.textAlign = "center";
	}

	//?add admin case message
	addAdminMsg("case", "adjustMinMax640", "<strong>Max 640</strong> page view adjustments made.");

}

//Adjust Layout by regions (If Leftcol or Rightcol are turned off, default adjustments need to be made to remove content margins ect.)
function adjustLayoutByRegions() {

	//?add admin status message
	addAdminMsg("status", "regionLeftcol", regionLeftcol);

	//?add admin status message
	addAdminMsg("status", "regionRightcol", regionRightcol);


	if (regionLeftcol == "active") {
		document.getElementById("content").style.marginLeft = "138px";
		if (regionRightcol == "active") {
			document.getElementById("rightcol").style.width = "33.4%";
			document.getElementById("rightcol").style.minWidth = "274px";
			document.getElementById("primary").style.width = "66.6%";
		}
	}

	if (regionRightcol != "active") {
		document.getElementById("primary").style.width = "100%";
		document.getElementById("content").style.paddingRight = "0";
	}

	if (regionRightcol == "active" && regionLeftcol != "active") {
		document.getElementById("primary").style.width = "53%";
		document.getElementById("content").style.paddingRight = "0";
	}

	//add admin message
	addAdminMsg("task", "adjustLayoutByRegions", "<strong>Adjust Layout By Regions</strong> page layout adjustments made.");
}

//Collapse Layout Columns into Single Stacked Column
function collapseLayoutSingleColumn() {

	//add admin message
	addAdminMsg("task", "collapseLayoutSingleColumn", "<strong>Collapse Layout Single Column</strong> page layout adjustments made.");

	document.getElementById("primary").style.width = "100%";
	document.getElementById("primary").style.display = "block";
	document.getElementById("primary").style.clear = "both";
	document.getElementById("main").style.width = "100%";
	document.getElementById("main").style.display = "block";
	document.getElementById("main").style.clear = "both";
	document.getElementById("content").style.marginLeft = "auto";

	if (regionLeftcol == "active") {
		document.getElementById("leftcol").style.width = "100%";
		document.getElementById("leftcol").style.display = "block";
		document.getElementById("leftcol").style.clear = "both";
		document.getElementById("leftcol").style.marginLeft = "auto";
	}

	if (regionRightcol == "active") {
		document.getElementById("rightcol").style.width = "100%";
		document.getElementById("rightcol").style.clear = "both";
		document.getElementById("rightcol").style.float = "left";
		document.getElementById("rightcol").style.marginLeft = "0";
		document.getElementById("rightcol").style.padding = "0";
	}


}

//Collapse Layout Columns into Dual Columns
function collapseLayoutDualColumn() {

	if (regionLeftcol == "active") {

		document.getElementById("primary").style.width = "100%";
		document.getElementById("primary").style.margin = "0";

		if (regionRightcol == "active") {
			document.getElementById("rightcol").style.width = "100%";
			document.getElementById("rightcol").style.clear = "both";
			document.getElementById("rightcol").style.float = "left";
			document.getElementById("rightcol").style.marginLeft = "-138px";
			document.getElementById("rightcol").style.paddingRight = "138px";
		}

	}

	//add admin message
	addAdminMsg("task", "collapseLayoutDualColumn", "<strong>Collapse Layout Dual Column</strong> page layout adjustments made.");

	//Collapse Layout Columns into Single Stacked Column for viewsizes beginning less than 540
	if (viewSize <= 540) {
		collapseLayoutSingleColumn();

		if (viewSize < 480) {

			//set body classes for header-collapse and under480
			document.body.classList.add('header-collapse');
			document.body.classList.add('under480');

			if (regionHeaderOne == "active") {
				document.getElementById("header-region-one").style.width = "100%";
			}
			if (regionHeaderTwo == "active") {
				document.getElementById("header-region-two").style.width = "100%";
			}
		}
	}
}

function setSeeRegionsByColor() {
	document.getElementById("primary").style.background = "#fc6";
	document.getElementById("main").style.background = "#ff0";
	document.getElementById("content").style.background = "#663";

	if (regionTopbar == "active") { document.getElementById("topbar").style.background = "#036"; }
	if (regionHeader == "active") { document.getElementById("header").style.background = "#090"; }
	if (regionMetarow == "active") { document.getElementById("metarow").style.background = "#0ff"; }
	if (regionLeftcol == "active") { document.getElementById("leftcol").style.background = "#f30"; }
	if (regionRightcol == "active") { document.getElementById("rightcol").style.background = "#fc0"; }
	if (regionMetafooter == "active") { document.getElementById("metafooter").style.background = "#0f9"; }
	if (regionFooter == "active") { document.getElementById("footer").style.background = "#033"; }
	if (regionHeaderOne == "active") { document.getElementById("header-region-one").style.background = "#06f"; }
	if (regionHeaderTwo == "active") { document.getElementById("header-region-two").style.background = "#6f0"; }
	if (regionHeaderThree == "active") { document.getElementById("header-region-three").style.background = "#0cc"; }
	if (regionFooterOne == "active") { document.getElementById("footer-region-one").style.background = "#906"; }
	if (regionFooterTwo == "active") { document.getElementById("footer-region-two").style.background = "#f90"; }
	if (regionFooterThree == "active") { document.getElementById("footer-region-three").style.background = "#336"; }
	if (regionAside == "active") { document.getElementById("aside").style.background = "#02D6F0"; }
}

//function to toggle hide/display of submenu navigation items
function toggle(id) {
	var menulist = document.getElementById(id);

	if (menulist.style.display == '')
		menulist.style.display = 'none';
	else
		menulist.style.display = '';
}

//function to toggle hide/display of collapse navigation menu
function collapseNavrowMenu(id, link) {
	var collapseMenuLink = document.getElementById(id);

	if (collapseMenuLink.style.display == '') {
		collapseMenuLink.style.display = 'none';
		document.getElementById("collapse").style.borderBottom = "none";
		link.innerHTML = 'Expand Navigation Menu';
	} else {
		collapseMenuLink.style.display = '';
		link.innerHTML = 'Collapse Navigation Menu';
		document.getElementById("collapse").style.borderBottom = "1px solid #000";
	}
}

//function to allow IE 6 and 7 to operate css minWidth
function fixMinWidthForIE() {
	try {
		if (!document.body.currentStyle) { return } //IE only
	} catch (e) { return }
	var elems = document.getElementsByTagName("*");
	for (e = 0; e < elems.length; e++) {
		var eCurStyle = elems[e].currentStyle;
		var l_minWidth = (eCurStyle.minWidth) ? eCurStyle.minWidth : eCurStyle.getAttribute("min-width"); //IE7 : IE6
		if (l_minWidth && l_minWidth != 'auto') {
			var shim = document.createElement("DIV");
			shim.style.cssText = 'margin:0 !important; padding:0 !important; border:0 !important; line-height:0 !important; height:0 !important; BACKGROUND:RED;';
			shim.style.width = l_minWidth;
			shim.appendChild(document.createElement("&nbsp;"));
			if (elems[e].canHaveChildren) {
				elems[e].appendChild(shim);
			} else {
				//??
			}
		}
	}
}

//Hover for page elements
hover = function () {
	if (regionSiteNavigation == "active") {
		var menuListItem = document.getElementById("site-navigation").getElementsByTagName("LI");
		for (var i = 0; i < menuListItem.length; i++) {
			menuListItem[i].onmouseover = function () {
				this.className += " hover";
			}
			menuListItem[i].onmouseout = function () {
				this.className = this.className.replace(new RegExp("hover\\b"), "");
			}
		}
	}
}

if (window.attachEvent) window.attachEvent("onload", hover);

// Read a page's GET URL variables and return them as an associative array.
function getQueryString(variable) {
	var queryString = window.location.search.substring(1);
	var vars = queryString.split("&");
	for (var i = 0; i < vars.length; i++) {
		var getValue = vars[i].split("=");
		if (getValue[0] == variable) return getValue[1];
	}
}


// Usage: DOMContentLoaded(function(e) { console.log(e); /* your code here */});

function DOMContentLoaded() { "use strict";

    var ael = 'addEventListener', rel = 'removeEventListener', aev = 'attachEvent', dev = 'detachEvent';
    var alreadyRun = false,
        funcs = arguments; // for use in the idempotent function `ready()`, defined later.

    function microtime() { return + new Date() } // new Date().valueOf();

    /* The vast majority of browsers currently in use now support both addEventListener
       and DOMContentLoaded. However, 2% is still a significant portion of the web, and
       graceful degradation is still the best design approach.

       `document.readyState === 'complete'` is functionally equivalent to `window.onload`.
       The events fire within a few tenths of a second, and reported correctly in every
       browser that was tested, including IE6. But IE6 to 10 did not correctly return the other
       readyState values as per the spec:
       In IE6-10, readyState was sometimes 'interactive', even when the DOM wasn't accessible,
       so it's safe to assume that listening to the `onreadystatechange` event
       in legacy browsers is unstable. Should readyState be undefined, accessing undefined properties
       of a defined object (document) will not throw.

       The following statement checks for IE < 11 via conditional compilation.
       `@_jscript_version` is a special String variable defined only in IE conditional comments,
       which themselves only appear as regular comments to other browsers.
       Browsers not named IE interpret the following code as
       `Number( new Function("")() )` => `Number(undefined)` => `NaN`.
       `NaN` is neither >, <, nor = to any other value.
       Values: IE5: 5?, IE5.5: 5.5?, IE6/7: 5.6/5.7, IE8: 5.8, IE9: 9, IE10: 10,
       (IE11 older doc mode*): 11, IE11 / NOT IE: undefined
    */

    var jscript_version = Number( new Function("/*@cc_on return @_jscript_version; @*\/")() );

    // check if the DOM has already loaded
    // If it has, send null as the readyTime, since we don't know when the DOM became ready.

    if (document.readyState === 'complete') { ready(null); return; } // execute ready()

    // For IE<9 poll document.documentElement.doScroll(), no further actions are needed.
    if (jscript_version < 9) { doIEScrollCheck(); return; }

    // ael: addEventListener, rel: removeEventListener, aev: attachEvent, dev: detachEvent

    if (document[ael]) {
        document[ael]("DOMContentLoaded", ready, false);

        // fallback to the universal load event in case DOMContentLoaded isn't supported.
        window[ael]("load", ready, false);
    } else
    if (aev in window) { window[aev]('onload', ready);
        // Old Opera has a default of window.attachEvent being falsy, so we use the in operator instead.
        // https://dev.opera.com/blog/window-event-attachevent-detachevent-script-onreadystatechange/
    } else {
        // fallback to window.onload that will always work.
        addOnload(ready);
    }

    // addOnload: Allows us to preserve any original `window.onload` handlers,
    // in ancient (prehistoric?) browsers where this is even necessary, while providing the
    // option to chain onloads, and dequeue them later.

    function addOnload(fn) {

        var prev = window.onload; // old `window.onload`, which could be set by this function, or elsewhere.

        // Here we add a function queue list to allow for dequeueing.
        // Should we have to use window.onload, `addOnload.queue` is the queue of functions
        // that we will run when the DOM is ready.

        if ( typeof addOnload.queue !== 'object') { // allow loose comparison of arrays
            addOnload.queue = [];
            if (typeof prev === 'function') {
                addOnload.queue.push( prev ); // add the previously defined event handler, if any.
            }
        }

        if (typeof fn === 'function') { addOnload.queue.push(fn) } // add the new function

        window.onload = function() { // iterate through the queued functions
            for (var i = 0; i < addOnload.queue.length; i++) { addOnload.queue[i]() }
        };
    }

    // dequeueOnload: remove a queued `addOnload` function from the chain.

    function dequeueOnload(fn, all) {

        // Sort backwards through the queued functions in `addOnload.queue` (if it's defined)
        // until we find `fn`, and then remove `fn` from its place in the array.

        if (typeof addOnload.queue === 'object') { // array
            for (var i = addOnload.queue.length-1; i >= 0; i--) { // iterate backwards
                if (fn === addOnload.queue[i]) {
                    addOnload.queue.splice(i,1); if (!all) {break}
                }
            }
        }
    }

    // ready: idempotent event handler function

    function ready(ev) {
        if (alreadyRun) {return} alreadyRun = true;

        // This time is when the DOM has loaded, or, if all else fails,
        // when it was actually possible to inference that the DOM has loaded via a 'load' event.

        var readyTime = microtime();

        detach(); // detach any event handlers

        // run the functions (`funcs` is arguments of DOMContentLoaded)
        for (var i=0; i < funcs.length; i++) {

            var func = funcs[i];

            if (typeof func === 'function') {

                // force set `this` to `document`, for consistency.
                func.call(document, {
                  'readyTime': (ev === null ? null : readyTime),
                  'funcExecuteTime': microtime(),
                  'currentFunction': func
                });
            }
        }
    }

    // detach: detach all the currently registered events.

    function detach() {
        if (document[rel]) {
            document[rel]("DOMContentLoaded", ready); window[rel]("load", ready);
        } else
        if (dev in window) { window[dev]("onload", ready); }
        else {
            dequeueOnload(ready);
        }
    }

    // doIEScrollCheck: poll document.documentElement.doScroll until it no longer throws.

    function doIEScrollCheck() { // for use in IE < 9 only.
        if ( window.frameElement ) {
            /* We're in an `iframe` or similar.
               The `document.documentElement.doScroll` technique does not work if we're not
               at the top-level (parent document).
               Attach to onload if we're in an <iframe> in IE as there's no way to tell otherwise
            */
            try { window.attachEvent("onload", ready); } catch (e) { }
            return;
        }
        // if we get here, we're not in an `iframe`.
        try {
            // when this statement no longer throws, the DOM is accessible in old IE
            document.documentElement.doScroll('left');
        } catch(error) {
            setTimeout(function() {
                (document.readyState === 'complete') ? ready() : doIEScrollCheck();
            }, 50);
            return;
        }
        ready();
    }
}

// Tested via BrowserStack.
