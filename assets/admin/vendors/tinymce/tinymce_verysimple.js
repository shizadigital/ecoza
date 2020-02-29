function initialiseInstance(editor) {  
	//This script taken from www.matthewkenny.com 
	var container = $('#' + editor.editorId);  
	$(editor.formElement).find("input[type=submit]").click(  
		function(event) {
			tinyMCE.triggerSave();
			$("#" + editor.id).valid();
				container.val(editor.getContent());  
		}  
	);  
}  

var protocol = location.protocol;
var slashes = protocol.concat("//");
var thehost = slashes.concat(window.location.hostname);

tinymce.init({ 
	selector:'textarea.tinymceverysimple',
	height: 300,
	menubar: false,
	plugins: 'preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media hr anchor advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern code help responsivefilemanager',
	
	toolbar: [
		'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect fontselect fontsizeselect',
		'bullist numlist | link unlink | code | fullscreen help'
	],
	image_caption: true,
	content_style: "body.mce-content-body {font-family: sans-serif, Arial, Verdana, \"Trebuchet MS\";font-size: 13px;color: #444;line-height: 1.6;}",
	contextmenu: 'link image inserttable | cell row column deletetable',
	resize: 'both',
	branding: false,
	forced_root_block : 'p',
	disk_cache : false,
	debug : false,
	//document_base_url : thehost,
	image_advtab: true,

	external_filemanager_path: "assets/vendors/filemanager/",
	filemanager_title: "Responsive Filemanager" ,
	external_plugins: { "filemanager" : "../filemanager/plugin.min.js" },

	remove_script_host: false,
	relative_urls : false, 
	init_instance_callback : 'initialiseInstance',
	setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});