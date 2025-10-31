	// JavaScript Document

// Grandiox Wordpress theme responsive javascript functions
// Functions to accurately retrieve user's viewport width for resposive adaptation.
// Operates from the width of the HTML document (not including vertical scrollbar width).
// For devices with issues with width=device-width the viewport width is compared to the outer window width. Since the viewport width should never exceed the outer window width, if the veiwport width exceeds the outer window width the outer window width is returned as the acurate value.

//SET SCRIPT PATHS
//Returns the Location object for the window
var getUrl = window.location;
var baseUrl = "";

//Set defaults for admin messages report string
window.functionCount = 0;
window.admMsg = '<strong>Admin Data (Client) - Responsive Report:</strong><br /><small># - Task, ! - Status, ? - Case</small><br /><br />Script Path: ' + baseUrl + '<br /><br />';


//ADMIN FUNCTIONS

//Display admin messages report string
function showAdminData(){

	//set default admin data variables
	var showAdminData = "0";
	var side = "";
	var report = "";

	//show admin messages (if showAdminData is 1 is query string)
	if (getQueryString("showAdminData") == 1 && getQueryString("report")=="responsive"){

		document.getElementById('cadata').innerHTML=window.admMsg;
		document.getElementById('cadata').style.display = "block";

	}

}

//this function is called after a 200 millisecond timeout after page load. it rechecks the calculated viewSize once again in the background. if the recalculated viewsize is smaller than the original calculation the gxResponsive functions are reloaded in order to capture the correct viewsize. this function was design to address the bug that occurs in some mobile browsers such as android 2.3 which has a lag in determining the correct screen size.
function adjustScreenSizeTimeout(startViewSize) {
	getViewSize();
	if (startViewSize > viewSize) {

		// load responsive functions
   		gxResponsive();

		//add admin message
		addAdminMsg("task", "adjustScreenSizeTimeout", "<strong>Adjust Screen Size Timeout</strong> has been activated.");

	}
}


//Add new string to admin messages repor
function addAdminMsg(type, condition, message){

	if(type=="task"){

		window.functionCount++;

		//append admin messages
		window.admMsg =window.admMsg.concat(window.functionCount + ": " + condition + "() - " + message + "<br />");

	} else if (type=="status"){

		window.admMsg =window.admMsg.concat("!: " + condition + "() > " + message + "<br />");

	} else if (type=="case"){

		window.admMsg =window.admMsg.concat("?: " + condition + "() * " + message + "<br />");

	}

}

//ONLOAD FUNCTIONS

window.onload = function() {

	var viewMode;
	var pageViewModeForce = "none";
	var pageInspectionMode = "normal";

	//script gets the src attribute based on ID of page's script element:
	var requestURL = document.getElementById("gxscript").getAttribute("src");

	//next use substring() to get querystring part of src
	var queryString = requestURL.substring(requestURL.indexOf("?") + 1, requestURL.length);

	//Next split the querystring into array
	var params = queryString.split("&");

	//Next loop through params
	for(var i = 0; i < params.length; i++){
		var name  = params[i].substring(0,params[i].indexOf("="));
		var value = params[i].substring(params[i].indexOf("=") + 1, params[i].length);

		//Test if value is a number. If not, wrap value with quotes:
		if(isNaN(parseInt(value))) {
			params[i] = params[i].replace(value, "'" + value + "'");
		}

		// Finally, use eval to set values of pre-defined variables:
		eval(params[i]);
	}

	if (typeof viewMode !== 'undefined' && viewMode == "full") {
		var pageViewMode = "full";
	} else if ( getQueryString("viewMode") == "collapseSingle" ) {
		pageViewMode = "responsive";
		pageViewModeForce = "collapseSingle";
	} else if ( getQueryString("viewMode") == "collapseDual" ) {
		pageViewMode = "responsive";
		pageViewModeForce = "collapseDual";
	} else {
		var pageViewMode = "responsive";
	}

	// Check for full-Size option selected, if not load gx responsive page function
	if (pageViewMode!="full"){

		// show JS admin data (showAdminData=1)
   		gxResponsive(pageViewModeForce, pageInspectionMode);

		//recheck screen size after timeout to address bug that cuases a lag in some mobile browsers such as android 2.3
		setTimeout(function(){adjustScreenSizeTimeout(viewSize);},200);

	} else {

		//Full size page view settings
		gxFullSize();

	}

	showAdminData();

};


//PAGE LOAD FUNCTIONS

function gxPageFunctions(){

		// get page view width
		getViewSize();

		// check active page regions
		checkActivePageRegions();

		// adjust layout according to active/inactive page regions
		adjustLayoutByRegions();

		//if page inspection mode is set to see egions by color call the function to add the color settings
		if ( getQueryString("inspectionMode") == "seeRegionsByColor" ) {
			pageInspectionMode = "seeRegionsByColor";
			setSeeRegionsByColor();
		}

	if (pageBgImage=="active"){
		// background image scaling
		document.getElementById("bgimage").style.minWidth = "640px";
	}

}

//load gx Responsive functions
function gxResponsive(pageViewModeForce){

	gxPageFunctions();

	if (pageViewModeForce=="collapseDual") {
		viewSize = 541;
		layoutSize = "small";
	} else if (pageViewModeForce=="collapseSingle") {
		viewSize = 319;
		layoutSize = "xx-small";
	}

	var mainWidth = document.getElementById('main').offsetWidth;
	if (mainWidth < 548){
		//Apply over 960
		appendResponsiveCSS('maincollapse');
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


// 1. Get page view size
function getViewSize(){

	//outWidth property only supported on desktop ie8 and over, however, it is not needed in such as the outerWidth would never exceed the innerWidth, (but only on mobile devices with false dpis values).
	var vpOuterWidth = window.outerWidth;
	var vpInnerWidth = document.body.clientWidth;
	if (vpInnerWidth > vpOuterWidth) {viewSize = vpOuterWidth;}
	if (vpOuterWidth = 0) { viewSize = vpInnerWidth; }
	else {viewSize = vpInnerWidth;}

	//add admin message
	addAdminMsg("task", "getViewSize", "Page view size is: <strong>" + viewSize + "</strong>");

	return viewSize;

}

// 2. Check which page region are acive
function checkActivePageRegions(){

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
	if (document.getElementById('footer-region-one') != null) { regionFooterOne = "active"; }
	if (document.getElementById('footer-region-two') != null) { regionFooterTwo = "active"; }
	if (document.getElementById('footer-region-three') != null) { regionFooterThree = "active"; }
	if (document.getElementById('subfooter') != null) { regionSubfooter = "active"; }
	if (document.getElementById('bgimage') != null) { pageBgImage = "active"; }
}

// 3. Set responsive CSS layout size
function setLayoutSize(viewSize){
	if (viewSize < 320){ layoutSize = "xx-small"; }
	else if (viewSize >= 320 && viewSize < 480){ layoutSize = "x-small"; }
	else if (viewSize >= 480 && viewSize < 640){ layoutSize = "small"; }
	else if (viewSize >= 640 && viewSize < 768){ layoutSize = "medium"; }
	else if (viewSize >= 768 && viewSize < 960){ layoutSize = "large"; }
	else if (viewSize >= 960 && viewSize < 1280){ layoutSize = "x-large"; }
	else if (viewSize >= 1280){ layoutSize = "xx-large"; }

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
function adjustResponsiveCSS(viewSize, layoutSize){

	//! add admin status message
	addAdminMsg("status", "adjustResponsiveCSS", "adjustMinMax640(), adjustRightCol(), adjustResponseLayout(), appendResponsiveCSS()");

	if (viewSize < 640){ var minMax640 = "max"; } else { var minMax640 = "min"; }

	//?add admin case message
	addAdminMsg("case", "minMax640", "minMax640 layout size set to: <strong>" + minMax640 + "</strong>");

	//call to set page max width for page sizes under 640
	adjustMinMax640(minMax640);

	//call adjustments for rightcol layout for page view sizes under 640
	adjustRightCol(minMax640);

	//call to make specific responsive adjustments for layout size
	adjustResponseLayout(layoutSize);

	//call to append specific responsive css stylesheet for layout size
	appendResponsiveCSS(layoutSize);

	//! add admin status message
	addAdminMsg("status", "adjustResponsiveCSS", "Tasks complete!");

	//add admin message
	addAdminMsg("task", "adjustResponsiveCSS", "Responsive CSS adjustments made.");

}

//4. append specific responsive layout stylesheets based on response size
function appendResponsiveCSS(appendStyle){

	var cssRandomVersion = Math.floor((Math.random() * 100) + 1);
	var appendCSS = appendStyle + '.css';
	var head  = document.getElementsByTagName('head')[0];
	var link  = document.createElement('link');
	link.id   = appendStyle;
	link.rel  = 'stylesheet';
	link.type = 'text/css';
	link.href = 'library/css/' + appendCSS + '?ver=1.' + cssRandomVersion + '.26';
	link.media = 'all';
	head.appendChild(link);

	//add admin message
	addAdminMsg("task", "appendResponsiveCSS", "<strong>" + appendCSS + "</strong> response layout stylesheet has been appended.");

}

//adjust rightcol layout for page view sizes under 640
function adjustRightCol(minMax){

	if(minMax=="max"){

		//Collapse Layout Columns into Dual Columns
		collapseLayoutDualColumn();

		//?add admin case message
		addAdminMsg("case", "adjustRightCol", "Adjustments for <strong>right column UNDER 640</strong> activated.");

	}

	//add admin message
	addAdminMsg("task", "adjustRightCol", "<strong>Min Max 640</strong> right column adjustments made.");

}

//adjust rightcol layout for page view sizes under 640
function adjustMinMax640(minMax640){

		if(minMax640=="max"){ setMax640(); } else if (minMax640=="min"){ setMin640(); }

		//add admin message
		addAdminMsg("task", "adjustMinMax640", "<strong>Min Max 640</strong> page layout adjustments made.");

}


//Make specific responsive css adjustments according to page layout size
function adjustResponseLayout(layoutSize){

	if(layoutSize == "xx-small"){

		//prevent page from contracting less than 240 on xx-small screen sizes
		document.getElementById("page").style.minWidth = "240px";

	} else if(layoutSize == "x-small"){

		//prevent page from contracting less than 320 on xx-small screen sizes
		document.getElementById("page").style.minWidth = "320px";

	} else if(layoutSize == "small"){

		//prevent page from contracting less than 480 on xx-small screen sizes
		document.getElementById("page").style.minWidth = "480px";

	}  else if(layoutSize == "medium"){


	} else if(layoutSize == "large"){


	} else if(layoutSize == "x-large"){


	} else if(layoutSize == "xx-large"){


	}

	//?add admin case message
	addAdminMsg("task", "adjustResponseLayout", "Specific responsive adjustments made for layout size <strong>" + layoutSize + "</strong>");

}

function setMin640() {

	//set site region minimum widths
	document.getElementById("page").style.minWidth = "640px";
	document.getElementById("main").style.minWidth = "240px";

	if (regionRightcol == "active") {
		document.getElementById("rightcol").style.minWidth = "150px";
	}

	if (regionTopbar == "active") {
		document.getElementById("topbar").style.minWidth = "640px";
		document.getElementById("topbar-content").style.minWidth = "640px";
	}

	if (regionSubfooter == "active") {
		document.getElementById("subfooter").style.minWidth = "640px";
	}

	var pageWidth = document.getElementById('page').offsetWidth;

	if (pageWidth > viewSize){
		document.getElementById("page").style.width = viewSize + "px";
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

	document.getElementById("page").style.maxWidth = "640px";
	if (regionNavrow == "active") {
		document.getElementById("navrow").style.maxWidth = "640px";
		document.getElementById("collapse").style.maxWidth = "640px";
	}
	document.getElementById("page").style.width = "100%";
	document.getElementById("content").style.padding = "0";
	document.body.style.marginTop = "0";

	//Apply under 640 css
	appendResponsiveCSS('under640');

	if (regionHeaderThree == "active") {
		appendResponsiveCSS('header-collapse');
	}

	//Collapse Navigation Menu
	if (regionNavrow == "active") {
		document.getElementById("site-navigation").style.display = "none";
		appendResponsiveCSS('nav-collapse');
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

	if (regionHeaderOne== "active") {
		document.getElementById("header-region-one").style.maxWidth = "507px";
	}

	//?add admin case message
	addAdminMsg("case", "adjustMinMax640", "<strong>Max 640</strong> page view adjustments made.");

}

//Adjust Layout by regions (If Leftcol or Rightcol are turned off, default adjustments need to be made to remove content margins ect.)
function adjustLayoutByRegions(){
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

		//add admin message
		addAdminMsg("task", "adjustLayoutByRegions", "<strong>Adjust Layout By Regions</strong> page layout adjustments made.");
}

//Collapse Layout Columns into Single Stacked Column
function collapseLayoutSingleColumn(){

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
function collapseLayoutDualColumn(){

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
		if (viewSize <= 540){
			collapseLayoutSingleColumn();

			if (viewSize < 480){
				appendResponsiveCSS('header-collapse');
				//Apply under 480 css
				appendResponsiveCSS('under480');
				if (regionHeaderOne == "active") {
					document.getElementById("header-region-one").style.width = "100%";
				}
				if (regionHeaderTwo == "active") {
					document.getElementById("header-region-two").style.width = "100%";
				}
			}
		}
}

function setSeeRegionsByColor(){
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
function fixMinWidthForIE(){
   try{
      if(!document.body.currentStyle){return} //IE only
   }catch(e){return}
   var elems=document.getElementsByTagName("*");
   for(e=0; e<elems.length; e++){
      var eCurStyle = elems[e].currentStyle;
      var l_minWidth = (eCurStyle.minWidth) ? eCurStyle.minWidth : eCurStyle.getAttribute("min-width"); //IE7 : IE6
      if(l_minWidth && l_minWidth != 'auto'){
         var shim = document.createElement("DIV");
         shim.style.cssText = 'margin:0 !important; padding:0 !important; border:0 !important; line-height:0 !important; height:0 !important; BACKGROUND:RED;';
         shim.style.width = l_minWidth;
         shim.appendChild(document.createElement("&nbsp;"));
         if(elems[e].canHaveChildren){
            elems[e].appendChild(shim);
         }else{
            //??
         }
      }
   }
}

//Hover for page elements
hover = function() {
	if (regionSiteNavigation == "active") {
		var menuListItem = document.getElementById("site-navigation").getElementsByTagName("LI");
		for (var i=0; i<menuListItem.length; i++) {
			menuListItem[i].onmouseover=function() {
				this.className+=" hover";
			}
			menuListItem[i].onmouseout=function() {
				this.className=this.className.replace(new RegExp("hover\\b"), "");
			}
		}
	}
}

if (window.attachEvent) window.attachEvent("onload", hover);

// Read a page's GET URL variables and return them as an associative array.
function getQueryString(variable) {
     var queryString = window.location.search.substring(1);
     var vars = queryString.split("&");
    for(var i=0; i<vars.length; i++){
         var getValue = vars[i].split("=");
         if(getValue[0] == variable) return getValue[1];
    }
}
