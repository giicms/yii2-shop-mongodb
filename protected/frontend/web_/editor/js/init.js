$(document).ready(function () {
    var textarea = $('#text'),
            toolbar = $('<div class="markdown-editor" id="md-button-bar" />').insertBefore(textarea.parent())
    preview = $('<div id="md-preview" class="md-hidetab" />').insertAfter('.markdown-editor');

    var options = {};

    options.strings = {
        bold: '<strong> Ctrl+B',
        boldexample: 'Bold',
        italic: '<em> Ctrl+I',
        italicexample: 'Em',
        link: '<a> Ctrl+L',
        linkdescription: 'Link Description',
        quote: '<blockquote> Ctrl+Q',
        quoteexample: 'Quote',
        code: '<pre><code> Ctrl+K',
        codeexample: 'Code',
        image: '<img> Ctrl+G',
        imagedescription: 'Image Description',
        olist: '<ol> Ctrl+O',
        ulist: '<ul> Ctrl+U',
        litem: 'Item',
        heading: '<h1>/<h2> Ctrl+H',
        headingexample: 'Headling',
        hr: '<hr> Ctrl+R',
        more: '<!--more--> Ctrl+M',
        undo: 'Undo Ctrl+Z',
        redo: 'Redo Ctrl+Y',
        redomac: 'Redo Mac - Ctrl+Shift+Z',
        fullscreen: 'Fullscreen - Ctrl+J',
        exitFullscreen: 'Exit fullscreen - Ctrl+E',
        fullscreenUnsupport: 'Not support.',
        imagedialog: '<p><b>Insert An Image</b></p>',
        linkdialog: '<p><b>Insert A Link</b></p>',
        ok: 'Okey',
        cancel: 'Cancel'
    };

    var converter = new Markdown.Converter(),
            editor = new Markdown.Editor(converter, '', options),
            diffMatch = new diff_match_patch(), last = '', preview = $('#md-preview'),
            mark = '@mark' + Math.ceil(Math.random() * 100000000) + '@',
            span = '<span class="diff" />';

  
    Markdown.Extra.init(converter, {
        extensions: ["tables", "fenced_code_gfm", "def_list", "attr_list", "footnotes"]
    });

    converter.hooks.chain('postConversion', function (html) {
        // clear special html tags
        html = html.replace(/<\/?(\!doctype|html|head|body|link|title|input|select|button|textarea|style|noscript)[^>]*>/ig, function (all) {
            return all.replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/'/g, '&#039;')
                    .replace(/"/g, '&quot;');
        });

        // clear hard breaks
        html = html.replace(/\s*((?:<br>\n)+)\s*(<\/?(?:p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|address|form|fieldset|iframe|hr|legend|article|section|nav|aside|hgroup|header|footer|figcaption|li|dd|dt)[^\w])/gm, '$2');

        if (html.indexOf('<!--more-->') > 0) {
            var parts = html.split(/\s*<\!\-\-more\-\->\s*/),
                    summary = parts.shift(),
                    details = parts.join('');

            html = '<div class="summary">' + summary + '</div>'
                    + '<div class="details">' + details + '</div>';
        }


        var diffs = diffMatch.diff_main(last, html);
        last = html;

        if (diffs.length > 0) {
            var stack = [], markStr = mark;

            for (var i = 0; i < diffs.length; i++) {
                var diff = diffs[i], op = diff[0], str = diff[1]
                sp = str.lastIndexOf('<'), ep = str.lastIndexOf('>');

                if (op != 0) {
                    if (sp >= 0 && sp > ep) {
                        if (op > 0) {
                            stack.push(str.substring(0, sp) + markStr + str.substring(sp));
                        } else {
                            var lastStr = stack[stack.length - 1], lastSp = lastStr.lastIndexOf('<');
                            stack[stack.length - 1] = lastStr.substring(0, lastSp) + markStr + lastStr.substring(lastSp);
                        }
                    } else {
                        if (op > 0) {
                            stack.push(str + markStr);
                        } else {
                            stack.push(markStr);
                        }
                    }

                    markStr = '';
                } else {
                    stack.push(str);
                }
            }

            html = stack.join('');

            if (!markStr) {
                var pos = html.indexOf(mark), prev = html.substring(0, pos),
                        next = html.substr(pos + mark.length),
                        sp = prev.lastIndexOf('<'), ep = prev.lastIndexOf('>');

                if (sp >= 0 && sp > ep) {
                    html = prev.substring(0, sp) + span + prev.substring(sp) + next;
                } else {
                    html = prev + span + next;
                }
            }
        }

        return html;
    });

    editor.hooks.chain('onPreviewRefresh', function () {
        var diff = $('.diff', preview), scrolled = false;

        $('img', preview).load(function () {
            if (scrolled) {
                preview.scrollTo(diff, {
                    offset: -50
                });
            }
        });

        if (diff.length > 0) {
            var p = diff.position(), lh = diff.parent().css('line-height');
            lh = !!lh ? parseInt(lh) : 0;

            if (p.top < 0 || p.top > preview.height() - lh) {
                preview.scrollTo(diff, {
                    offset: -50
                });
                scrolled = true;
            }
        }
    });

    var input = $('#text'), th = textarea.height(), ph = preview.height();

    editor.hooks.chain('enterFakeFullScreen', function () {
        th = textarea.height();
        ph = preview.height();
        $(document.body).addClass('fullscreen');
        var h = $(window).height() - toolbar.outerHeight();

        textarea.css('height', h);
        preview.css('height', h);
    });

    editor.hooks.chain('enterFullScreen', function () {
        $(document.body).addClass('fullscreen');

        var h = window.screen.height - toolbar.outerHeight();
        textarea.css('height', h);
        preview.css('height', h);
    });

    editor.hooks.chain('exitFullScreen', function () {
        $(document.body).removeClass('fullscreen');
        textarea.height(th);
        preview.height(ph);
    });

    editor.run();

    var edittab = $('#md-button-bar').prepend('<div class="md-edittab"><a href="#md-editarea" class="active">Editor</a><a href="#md-preview">Preview</a></div>'),
            editarea = $(textarea.parent()).attr("id", "md-editarea");

    $(".md-edittab a").click(function () {
        $(".md-edittab a").removeClass('active');
        $(this).addClass("active");
        $("#md-editarea, #md-preview").addClass("md-hidetab");

        var selected_tab = $(this).attr("href"),
                selected_el = $(selected_tab).removeClass("md-hidetab");

 
        if (selected_tab == "#md-preview") {
            $("#md-button-row").addClass("md-visualhide");
        } else {
            $("#md-button-row").removeClass("md-visualhide");
        }

        $("#md-preview").outerHeight($("#md-editarea").innerHeight());

        return false;
    });
});