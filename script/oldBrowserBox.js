function get_browser(){
	var N=navigator.appName, ua=navigator.userAgent, tem;
	var M=ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
	if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
	M=M? [M[1], M[2]]: [N, navigator.appVersion, '-?'];
	return M[0];
}
function get_browser_version(){
	var N=navigator.appName, ua=navigator.userAgent, tem;
	var M=ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
	if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
	M=M? [M[1], M[2]]: [N, navigator.appVersion, '-?'];
	return M[1];
}
$.fn.oldBrowserBox = function(content){
	content = (typeof content === "undefined") ? this.html() : content;
	if(navigator.userAgent.indexOf('Firefox') != -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Firefox') + 8)) >= 3.6){
		this.hide();
	} else if(navigator.userAgent.indexOf('Chrome') != -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15){
		this.hide();
	} else if(navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Version') != -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Version') + 8).split(' ')[0]) >= 5){
		this.hide();
	} else{
		this.show();
		this.html(this.html()+content);
	}
}