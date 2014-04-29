﻿$(document).ready(function(){
	$.fn.hasAttr = function(name){
		attr = this.attr(name);
		return typeof attr !== 'undefined' && attr !== false;
	};
	var ctrldown;
	$(document).keydown(function(e){
		if(e.keyCode === 17){
			ctrldown = true;
		}
	});
	$(document).keyup(function(e){
		if(e.keyCode === 17){
			ctrldown = false;
		}
	});
	$("head").append('<link rel="icon" href="../favicon.ico" type="image/x-icon"/><link rel="shortcut icon" type="image/png" href="../favicon.png"/>');
	$(document).keydown(function(e){
		if(ctrldown === true){
			if(e.keyCode === 70 || e.keyCode === 73){
				if($("input:focus").length > 0){
					$('html,body').animate({
						scrollTop: $("input:focus").offset().top},
					'slow');
				} else if($("textarea:focus")){
					$('html,body').animate({
						scrollTop: $("textarea:focus").offset().top},
					'slow');
				}
			}
		}
	});
	$("input#custom_page_name").hide();
	$("input#custom_page_name").prev().hide();
	$("input#custom_page_name2").hide();
	$("input#custom_page_name2").prev().hide();
	$("input#custom_page_name").next().hide();
	$("input#custom_page_name2").next().hide();
	$("#custom_page").click(function(){
		if($(this).is(":checked")){
			$("input#custom_page_name").show();
			$("input#custom_page_name").prev().show();
			$("input#custom_page_name").next().show();
			$("textarea#content_text").hide();
			$("textarea#content_text").val("");
			$("textarea#content_text").next().hide();
			$("textarea#content_text").prev().hide();
			$("textarea#content_text").prev().prev().hide();
			$("textarea#content_text").prev().prev().prev().hide();
		} else{
			$("input#custom_page_name").hide();
			$("input#custom_page_name").next().hide();
			$("input#custom_page_name").prev().hide();
			$("textarea#content_text").show();
			$("textarea#content_text").next().show();
			$("textarea#content_text").prev().show();
			$("textarea#content_text").prev().prev().show();
			$("textarea#content_text").prev().prev().prev().show();
		}
	});
	$("#custom_page2").click(function(){
		if($(this).is(":checked")){
			$("input#custom_page_name2").show();
			$("input#custom_page_name2").prev().show();
			$("input#custom_page_name2").next().show();
			$("textarea#content_text2").hide();
			$("textarea#content_text2").val("");
			$("textarea#content_text2").next().hide();
			$("textarea#content_text2").prev().hide();
			$("textarea#content_text2").prev().prev().hide();
			$("textarea#content_text2").prev().prev().prev().hide();
		} else{
			$("input#custom_page_name2").hide();
			$("input#custom_page_name2").prev().hide();
			$("input#custom_page_name2").next().hide();
			$("textarea#content_text2").show();
			$("textarea#content_text2").next().show();
			$("textarea#content_text2").prev().show();
			$("textarea#content_text2").prev().prev().show();
			$("textarea#content_text2").prev().prev().prev().show();
		}
	});
	$("input").attr("autocomplete", "off");
	$("form").attr("autocomplete", "off");
	$("#oldBrowserBox").oldBrowserBox("Please get a newer browser for the best of this site.");
	$('.tip').tipr({
		'speed': 300,
		'mode': 'bottom'
	});

	$(window).bind('beforeunload', function(e){ 
		if($('input:focus:not([type=submit])').length > 0 || $('textarea:focus').length > 0){
			return "Are you sure you want to exit, because you can lose many things you have edited and changed.";
		}
	});
	$('div.tipr_container_bottom').hover(function(){
		$(this).show();
	});
	var d = new Date();

	var month = d.getMonth()+1;
	var day = d.getDate();

	var output = d.getFullYear() + '-' +
		(month<10 ? '0' : '') + month + '-' +
		(day<10 ? '0' : '') + day;
	$("input.date").datepicker({
		dateFormat: 'yy-mm-dd',
		inline: true,
		showOtherMonths: true
	});
	$('input.date').on("focus", function(){
		$('html,body').animate({
			scrollTop: $(".ui-datepicker").offset().top},
			'slow');
	});
	$("a.showNotifications").on('click', function(e){
		e.stopPropagation();
		$("div#notifications").slideToggle("slow");
	});
	$(document).on('click', function(e) {
		if( $(e.target).hasClass('showNotifications') || $(e.target).attr('id') === 'notifications' || $(e.target).parent().attr('id') === 'notifications' || $(e.target).parent().parent().attr('id') === 'notifications' || $(e.target).parent().parent().parent().attr('id') === 'notifications'){
			
		}
		else{
		  $('#notifications').slideUp("fast");     
		}
	});
	$.fn.selectRange = function(start, end) {
		if(!end) end = start; 
		return this.each(function() {
			if (this.setSelectionRange) {
				this.focus();
				this.setSelectionRange(start, end);
			} else if (this.createTextRange) {
				var range = this.createTextRange();
				range.collapse(true);
				range.moveEnd('character', end);
				range.moveStart('character', start);
				range.select();
			}
		});
	};
	$('a.addToDo').click(function(){
		
		var txt = $('form#addToDo').is(':hidden') ? 'Hide' : 'Add Note';
		$(this).text(txt);
		$("#addToDo").slideToggle("medium");
		$('html,body').animate({
			scrollTop: $("a.addToDo").offset().top},
			'slow');
	});
	$("button.close").click(function(){
		$(this).parent().hide();
	});
	$("span#toTop").click(function(){
		$('html,body').animate({
			scrollTop: 0},
			200);
	});
	$(".ui-datepicker-next span").text(">");
	$('.hideScroll').hide();
	$(window).scroll( function(){
		$('.hideScroll').each( function(i){
			if($(window).scrollTop() > 245){
				$(this).fadeIn(200);
			} else{
				$(this).fadeOut(200);
			}
		});
	});
	
	if(!$("#ui-datepicker-div").is(":hidden")){
		$(window).scroll(function(){
			$("#ui-datepicker-div").show();
		});
	}
	$("textarea.edit").parent().submit(function(e){
		$("textarea.edit", this).val(marked($("textarea.edit", this).val()));
	});
	$("textarea.edit").before("<div class='textarea_edit_buttons'><a href='#' data-edit='add-link'><img src='../img/link-icon.png'/></a> <a href='#' data-edit='add-bold'><img src='../img/bold-icon.png'/></a> <a href='#' data-edit='add-italic'><img src='../img/italic-icon.png'/></a> <a href='#' data-edit='add-underline'><img src='../img/underline-icon.png'/></a><select class='horizontal'><option>1</option><option>2</option><option>3</option><option>4</option></select></div>");
	$("textarea.edit").after("<div class='preview'></div>");
	$("textarea.edit").on("change", function(){
		$(this).next().html(marked($(this).val()));
	});
	$("textarea.edit").on("keyup", function(){
		$(this).next().html(marked($(this).val()));
	});
	$("a[data-edit]").click(function(e){
		$('html,body').animate({
			scrollTop: $("div.textarea_edit_buttons").offset().top},
		'slow');
		var data_edit = $(this).attr("data-edit");
		if(data_edit === "add-link"){
			var options = {
				buttons: {
					confirm: {
						text: 'Submit',
						action: function(e) {
							if(e.input !== "null"){
								$(this).parent().next().val($(this).parent().next().val() + "["+e.input+"]("+e.input+")").selectRange($("textarea.edit").val().length-6, $("textarea.edit").val().length-2).change();
							}
							Apprise('close');
						}
					},
				},
				input: true,
			};
			Apprise('Link URL', options);
		} else if(data_edit === "add-bold"){
			$(this).parent().next().val($(this).parent().next().val() + "**Text**").selectRange($("textarea.edit").val().length-6, $("textarea.edit").val().length-2).change();
		} else if(data_edit === "add-italic"){
			$(this).parent().next().val($(this).parent().next().val() + "_Text_").selectRange($("textarea.edit").val().length-5, $("textarea.edit").val().length-1).change();
		} else if(data_edit === "add-underline"){
			$(this).parent().next().val($(this).parent().next().val() + "<span style='text-decoration: underline;'>Text</span>").selectRange($("textarea.edit").val().length-11, $("textarea.edit").val().length-7).change();
		}
	});
	$("a.editPage").click(function(e){
		console.log("edit page");
		$("input.pageID").val($(this).attr("data-store"));
		$("div#loading").show();
		
		$.ajax({
			type: "POST",
			url: "data.php",
			data: { row:"id", row2:"name",  val:$(this).attr("data-store"), table:"pages"  },
			beforeSend: function(){
				$("form#edit-page").hide();
			},
			success: function(data){
				$("#page-name2").val(data);
			}
		});
		$.ajax({
			type: "POST",
			url: "data.php",
			data: { row:"id", row2:"in_nav",  val:$(this).attr("data-store"), table:"pages"  },
			success: function(data){
				if(data === '1'){
					$("#in-nav2").attr("checked", true);
				} else{
					if($("#in_nav2").hasAttr("checked")){
						$("#in-nav2").removeAttr("checked");
					}
				}
			}
		});
		$.ajax({
			type: "POST",
			url: "data.php",
			data: { row:"id", row2:"use_page",  val:$(this).attr("data-store"), table:"pages"  },
			success: function(data){
				if(data === '1'){
					$("#custom_page2").attr("checked", true);
				} else{
					if($("#custom_page2").hasAttr("checked")){
						$("#custom_page2").removeAttr("checked");
					}
				}
			}
		});
		$.ajax({
			type: "POST",
			url: "data.php",
			data: { row:"id", row2:"page_name",  val:$(this).attr("data-store"), table:"pages"  },
			success: function(data){
				if($("#custom_page2").is(":checked")){
					$("#custom_page_name2").val(data);
				}
			}
		});
		$.ajax({
			type: "POST",
			url: "data.php",
			data: { row:"id", row2:"content",  val:$(this).attr("data-store"), table:"pages"  },
			success: function(data){
				tinyMCE.get('content_text2').setContent(data);
				$("div#loading").hide();
				$("form#edit-page").show();
			}
		});
	});
	function addSession(nam, val, don){
		$.ajax({
			type: "POST",
			url: "session.php",
			data: { name: nam, value: val  },
		}).done(don);
	}
	$("[data-toggle]").each(function(){
		
		var togglel = $(this).attr("data-toggle");
		$(togglel).hide();
		$(togglel).addClass("shown");
		var before_txt = $(this).html(),
			change_txt = $(this).attr("data-change-text");
		
		$(this).click(function(e){ 
			$(togglel).slideToggle("fast");
			
			$(togglel).toggleClass("shown");
			if(change_txt === 'true'){
				if($(togglel).hasClass("shown")){
					$(this).html(before_txt);
					
				} else{
					$(this).html("Hide");
				}
			}
			if(!$(togglel).hasClass("shown")){
				$('html,body').animate({
					scrollTop: $(togglel).offset().top},
				'slow');
			} else{
				$('html,body').animate({
					scrollTop: $(this).offset().top},
				'slow');
			}
		});
	});
	$("[data-hide]").each(function(){
		var hidel = $(this).attr("data-hide");
		$(this).click(function(e){ e.preventDefault(); $(hidel).hide("fast"); });
	});
	$("[data-show]").each(function(){
		var showl = $(this).attr("data-show");
		$(this).click(function(e){ e.preventDefault(); $(showl).show("fast"); });
	});
	$("a.toggle_div").click(function(){
		var div = $(this).attr("data-div");
		$(div).slideToggle("fast");
	});
	$(window).ready(function() {
		$('.bxslider').bxSlider();
	});
	function newTab(url){
		var win=window.open(url, '_blank');
	}
	$("a[data-path]").click(function(e){
		e.preventDefault();
		document.location.href = $(this).attr("data-path");
	});
	tinymce.init({
		mode : "textareas",
		theme_advanced_buttons3_add : "fullscreen",
		height: 400,
		selector:'textarea.editor',
		plugins: "image, link, table, jbimages, fullscreen, table, emoticons, contextmenu, autosave, wordcount, anchor, code, media, bbcode, textcolor, insertdatetime",
		toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image emoticons | jbimages | fullscreen anchor | media | forecolor backcolor | fontselect fontsizeselect | insertdatetime",
		insertdatetime_formats: ["%Y/%m/%d", "%H:%M:%S", "%Y/%m/%d %H:%M:%S", "%d %B %Y", "%I:%M:%S %p", "%d %B %Y %I:%M:%S %p"],
		contextmenu: "cut copy paste | delete | link image inserttable | cell row column deletetable",
		font_formats: "Andale Mono=andale mono,times;"+
		"Arial=arial,helvetica,sans-serif;"+
			"Arial Black=arial black,avant garde;"+
				"Book Antiqua=book antiqua,palatino;"+
					"Comic Sans MS=comic sans ms,sans-serif;"+
					"Courier New=courier new,courier;"+
					"Georgia=georgia,palatino;"+
					"Handwrting=lucida handwriting,french script mt,monotype corsiva,papyrus;"+
					"Helvetica=helvetica;"+
					"Impact=impact,chicago;"+
					"Symbol=symbol;"+
					"Tahoma=tahoma,arial,helvetica,sans-serif;"+
					"Terminal=terminal,monaco;"+
					"Times New Roman=times new roman,times;"+
					"Trebuchet MS=trebuchet ms,geneva;"+
				"Verdana=verdana,geneva;"+
			"Webdings=webdings;"+
		"Wingdings=wingdings,zapf dingbats",
		custom_undo_redo_levels: 100,
		relative_urls: false,
		tools: "inserttable"
	});
	$(function() { $('body').hide().show(); });
});