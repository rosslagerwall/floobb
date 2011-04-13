	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",

		plugins : "spellchecker,safari,table,advhr,advimage,advlink,emotions,inlinepopups,insertdatetime,preview,searchreplace,contextmenu,paste,template",

		// Theme options
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,pastetext,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,help,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,removeformat,visualaid,|,sub,sup,|,charmap,emotions,advhr,|,template,spellchecker",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "none",
		theme_advanced_resizing : false,
		spellchecker_languages : "+English=en",


		// Example content CSS (should be your site CSS)
		content_css : "tiny.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
	
	
	function verify(f)
	{
		tinyMCE.triggerSave();
		len = getLengthMCE("reply");
		if (len > 10000)
		{
			alert("Please shorten the post. Maximum length for content is 10000 characters.");
			return false;
		}

		return true;
	}
	
	function getLengthMCE(editorId)
	{

		// Get the editor instance that we want to interact with.
		var oEditor = tinyMCE.get(editorId) ;
	
		// Get the Editor Area DOM (Document object).
		var oDOM = oEditor.getDoc() ;
	
		var iLength ;
		// The are two diffent ways to get the text (without HTML markups).
		// It is browser specific.
		if (document.all)
		{
			// If Internet Explorer.
			iLength = oDOM.body.innerText.length;
		}
		else
		{
			// If Gecko.
			var r = oDOM.createRange() ;
			r.selectNodeContents(oDOM.body);
			iLength = r.toString().length;
		}
	
		return iLength;
	}
