tinyMCEPopup.requireLangPack('mm_forms');

var MM_FromsDialog = {
	init : function() {
		//var f = document.forms[0];
		// Get the selected contents as text and place it in the input
		//f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		//f.somearg.value = tinyMCEPopup.getWindowArg('some_custom_arg');
	},

	insert : function() {
		var f = document.forms[0];
		// Insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, f.mm_form.value);
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(MM_FromsDialog.init, MM_FromsDialog);