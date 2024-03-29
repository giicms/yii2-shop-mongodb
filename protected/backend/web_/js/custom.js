$(document).ready(function () {
    tinymce.init({
        selector: '.editor',
        height: 500,
        setup: function (editor) {
            editor.on("change", function (e) {
                var content = tinyMCE.activeEditor.getContent();
                if (content == "")
                    $("#product-content").val("");
                else
                    $("#product-content").val(content);
            });
        },
        plugins: [
            'advlist autolink autosave autoresize link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker responsivefilemanager textpattern'
        ],
        toolbar1: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect',
        toolbar2: 'bullist numlist | blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
        menubar: false,
        toolbar_items_size: 'small',
        style_formats: [{
                title: 'Bold text',
                inline: 'b'
            }, {
                title: 'Red text',
                inline: 'span',
                styles: {
                    color: '#ff0000'
                }
            }, {
                title: 'Red header',
                block: 'h1',
                styles: {
                    color: '#ff0000'
                }
            }, {
                title: 'Example 1',
                inline: 'span',
                classes: 'example1'
            }, {
                title: 'Example 2',
                inline: 'span',
                classes: 'example2'
            }, {
                title: 'Table styles'
            }, {
                title: 'Table row 1',
                selector: 'tr',
                classes: 'tablerow1'
            }],
        templates: [{
                title: 'Test template 1',
                content: 'Test 1'
            }, {
                title: 'Test template 2',
                content: 'Test 2'
            }],
        external_filemanager_path: "/libs/filemanager/",
        filemanager_title: "Filemanager",
        external_plugins: {"filemanager": "/libs/filemanager/plugin.min.js"}
    });
});