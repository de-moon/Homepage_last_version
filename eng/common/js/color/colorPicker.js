// # Javascript Color Picker
var isIE = (window.navigator.appName.indexOf("Explorer") != -1) ? true : false; // ie ¿©ºÎ

var cpkLayerId = "layerColorPicker";
var cpkBodyUrl = "/common/js/color/colorPicker.html";
var cpkWidth = 214;
var cpkHeight = 318;

var cpkReturnExec;
var cpkElementNm;

function cpkRegistEvent() {
	if (isIE) {
		document.attachEvent('onclick', cpkHideLayer);
	}
	else if (document.addEventListener) {
		document.addEventListener('click', cpkHideLayer, false);
	}
	else if (document.attachEvent) {
		document.attachEvent('click', cpkHideLayer);
	}
}

function cpkUnregistEvent() {
	if (isIE) {
		document.detachEvent('onclick', cpkHideLayer);
	}
	else if (document.removeEventListener) {
		document.removeEventListener('click', cpkHideLayer, false);
	}
	else if (document.detachEvent) {
		document.detachEvent('click', cpkHideLayer);
	}
}

function openColorPicker(e, returnExec, elementNm) {
	var e = window.event || e;
	var stdBody = (document.documentElement || document.body);

	cpkReturnExec = returnExec;
	cpkElementNm = elementNm;

	var posX = (isIE) ? parseInt(document.body.scrollLeft, 10) + parseInt(e.clientX, 10) : parseInt(e.pageX, 10);
	if ((parseInt(stdBody.scrollWidth, 10) - posX) <= cpkWidth) posX -= cpkWidth;
	var posY = (isIE) ? parseInt(e.clientY, 10) + parseInt(document.body.scrollTop, 10) : parseInt(e.pageY, 10);
	if (isIE && parseInt(document.body.scrollTop, 10) == 0) posY += parseInt(document.documentElement.scrollTop, 10);

	cpkCheckLayer();

	setTimeout(function () { cpkShowLayer(posX, posY) }, 300);
}

function cpkSetColorPicker(color) {
	eval(cpkReturnExec+"('"+cpkElementNm+"', '"+color+"');");
	cpkHideLayer();
}

function cpkShowLayer(posX, posY) {
	var objLayer = document.getElementById(cpkLayerId);
	objLayer.style.left = posX+"px";
	objLayer.style.top = posY+"px";
	objLayer.style.display = "";

	cpkRegistEvent();
}

function cpkHideLayer() {
	cpkUnregistEvent();

	var objLayer = document.getElementById(cpkLayerId);
	if (objLayer) objLayer.style.display = "none";
}

function cpkCheckLayer() {
	var objDiv = document.getElementById(cpkLayerId);
	var objIfrm = document.getElementById(cpkLayerId+"Body");

	if (!objDiv) {
		objDiv = document.createElement('DIV');
		objDiv.id = cpkLayerId;
		objDiv.style.position = "absolute";
		objDiv.style.left = objDiv.style.top = "0px";
		objDiv.style.zIndex = 100;
		objDiv.style.display = "none";

			objIfrm = document.createElement("IFRAME");
			objIfrm.setAttribute("id", cpkLayerId+"Body");
			objIfrm.src = cpkBodyUrl;
			objIfrm.setAttribute("scrolling", "no");
			objIfrm.setAttribute("frameBorder", "0");
			objIfrm.setAttribute("marginWidth", "0");
			objIfrm.setAttribute("marginHeight", "0");
			objIfrm.style.width = cpkWidth+'px';
			objIfrm.style.height = cpkHeight+'px';

		objDiv.appendChild(objIfrm);

		document.body.appendChild(objDiv);
	}

	return objIfrm;
}
