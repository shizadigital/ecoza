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
    selector: 'textarea.tinymcesimple',
    height: 300,
    menubar: false,
    plugins: 'preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media hr anchor advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern code help responsivefilemanager',

    toolbar: [
        'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect fontselect fontsizeselect | hr',
        'bullist numlist | outdent indent blockquote | link unlink | image media cleanup | preview | forecolor backcolor | responsivefilemanager | code | fullscreen help'
    ],
    image_class_list: [
        { title: 'None', value: '' },
        { title: 'Img Responsive (Bootstrap 3)', value: 'img-responsive' },
        { title: 'Img Rounded Corners (Bootstrap 3)', value: 'img-rounded' },
        { title: 'Img Circle (Bootstrap 3)', value: 'img-circle' },
        { title: 'Img Thumbnail (Bootstrap 3)', value: 'img-thumbnail' },
        { title: 'Img Responsive (Bootstrap 4)', value: 'img-fluid' },
        { title: 'Img Rounded Corners (Bootstrap 4)', value: 'rounded' },
        { title: 'Img Circle (Bootstrap 4)', value: 'rounded-circle' },
        { title: 'Img Thumbnail (Bootstrap 4)', value: 'img-thumbnail' },
        { title: 'Image Center', value: 'aligncenter' }
    ],
    image_caption: true,
    content_style: "body.mce-content-body {font-family: sans-serif, Arial, Verdana, \"Trebuchet MS\";font-size: 13px;color: #444;line-height: 1.6;}",
    contextmenu: 'link image inserttable | cell row column deletetable',
    resize: true,
    branding: false,
    forced_root_block: 'p',
    disk_cache: false,
    debug: false,
    //document_base_url : thehost,
    image_advtab: true,

    external_filemanager_path: "../../assets/admin/vendors/filemanager/",
    filemanager_title: "Responsive Filemanager",
    external_plugins: { "filemanager": "../filemanager/plugin.min.js" },

    remove_script_host: false,
    relative_urls: false,
    init_instance_callback: 'initialiseInstance',
    setup: function(editor) {
        editor.on('change', function() {
            editor.save();
        });
    }
});