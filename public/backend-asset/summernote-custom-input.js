
    (function ($) {

    // ---------------------------
    // Open modal for insert/edit
    // ---------------------------
    function openImageDialog(context) {
        const $editable = context.layoutInfo.editable;
        const $checked  = $($editable).find('img.note-image-checked').first();

        const editing = $checked.length > 0;

        // Reset fields
        $('#sn_src').val(editing ? ($checked.attr('src') || '') : '');
        $('#sn_alt').val(editing ? ($checked.attr('alt') || '') : '');
        $('#sn_title').val(editing ? ($checked.attr('title') || '') : '');

        // width/height (attr)
        const wAttr = editing ? ($checked.attr('width') || '') : '';
        const hAttr = editing ? ($checked.attr('height') || '') : '';
        $('#sn_w').val(wAttr);
        $('#sn_h').val(hAttr);

        // Caption detect: <figure><img>...<figcaption>
        let hasCaption = false;
        if (editing) {
        const $fig = $checked.closest('figure');
        hasCaption = $fig.length && $fig.find('figcaption').length;
        }
        $('#sn_caption').prop('checked', hasCaption);

        // Store context + selected img
        $('#snImageModal').data('context', context);
        $('#snImageModal').data('targetImg', editing ? $checked : null);

        // Ratio helper reset
        $('#sn_keep_ratio').prop('checked', true);
        $('#snImageModal').data('ratio', null);

        $('#snImageModal').modal('show');
    }

    // ---------------------------
    // Insert or update image
    // ---------------------------
    function applyImage(context, $target) {
        const src   = ($('#sn_src').val() || '').trim();
        const alt   = ($('#sn_alt').val() || '').trim();
        const title = ($('#sn_title').val() || '').trim();
        const w     = ($('#sn_w').val() || '').trim();
        const h     = ($('#sn_h').val() || '').trim();
        const capOn = $('#sn_caption').is(':checked');
        const captionText = title || alt;

        if (!src) return;

        // helper to set attrs
        const setAttrs = ($img) => {
        $img.attr('src', src);
        alt ? $img.attr('alt', alt) : $img.removeAttr('alt');
        title ? $img.attr('title', title) : $img.removeAttr('title');

        w ? $img.attr('width', w) : $img.removeAttr('width');
        h ? $img.attr('height', h) : $img.removeAttr('height');
        };

        // -----------------
        // EDIT mode
        // -----------------
        if ($target && $target.length) {
        const $fig = $target.closest('figure');
        setAttrs($target);

        if (capOn) {
            if ($fig.length) {
            if (!$fig.find('figcaption').length) $fig.append('<figcaption></figcaption>');
            $fig.find('figcaption').text(captionText);
            } else {
            $target.wrap('<figure class="sn-figure"></figure>');
            $target.after('<figcaption></figcaption>');
            $target.closest('figure').find('figcaption').text(captionText);
            }
        } else {
            // remove caption structure if exists
            if ($fig.length) {
            const $img = $fig.find('img').first();
            $fig.replaceWith($img); // unwrap
            }
        }
        return;
        }

        // -----------------
        // INSERT mode
        // -----------------
        if (capOn) {
        const safeSrc = $('<div>').text(src).html();
        const figHtml =
            '<figure class="sn-figure">' +
            '<img src="' + safeSrc + '">' +
            '<figcaption></figcaption>' +
            '</figure>';

        context.invoke('editor.pasteHTML', figHtml);

        // after insert apply attrs
        setTimeout(() => {
            const $lastFig = $(context.layoutInfo.editable).find('figure.sn-figure').last();
            const $img = $lastFig.find('img').first();
            setAttrs($img);
            $lastFig.find('figcaption').text(captionText);
        }, 0);

        } else {
        context.invoke('editor.insertImage', src, function ($img) {
            setAttrs($img);
        });
        }
    }

    // ---------------------------
    // Init Summernote
    // ---------------------------
    $('.summernote').summernote({
        height: 200,
        dialogsInBody: true,
        toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'customImage']], // ✅ default picture বাদ
        ['view', ['codeview']]
        ],
        buttons: {
        customImage: function (context) {
            const ui = $.summernote.ui;
            return ui.button({
            contents: '<i class="note-icon-picture"></i>',
            tooltip: 'Insert/edit image',
            click: function () {
                openImageDialog(context);
            }
            }).render();
        }
        },
        callbacks: {
        onChange: function(contents) {
            $(this).val(contents);
        }
        }
    });

    // ---------------------------
    // Browse button -> open file picker
    // ---------------------------
    $(document).on('click', '#sn_pick_btn', function () {
        $('#sn_file').val('');
        $('#sn_file').trigger('click');
    });

    // ---------------------------
    // File selected -> dataURL -> set Source
    // ---------------------------
    $(document).on('change', '#sn_file', function (e) {
        const file = e.target.files && e.target.files[0];
        if (!file) return;

        if (!file.type || !file.type.startsWith('image/')) {
        alert('Please select an image file.');
        return;
        }

        const reader = new FileReader();
        reader.onload = function (ev) {
        const dataUrl = ev.target.result;
        $('#sn_src').val(dataUrl);

        // set ratio + optional width/height
        const img = new Image();
        img.onload = function () {
            $('#snImageModal').data('ratio', img.width / img.height);

            if (!$('#sn_w').val()) $('#sn_w').val(img.width);
            if (!$('#sn_h').val()) $('#sn_h').val(img.height);
        };
        img.src = dataUrl;
        };
        reader.readAsDataURL(file);
    });

    // ---------------------------
    // Constrain proportions
    // ---------------------------
    $(document).on('input', '#sn_w, #sn_h', function () {
        if (!$('#sn_keep_ratio').is(':checked')) return;

        let ratio = $('#snImageModal').data('ratio');
        let w = parseFloat($('#sn_w').val());
        let h = parseFloat($('#sn_h').val());

        // ratio init only when both exist
        if (!ratio && w && h) {
        $('#snImageModal').data('ratio', w / h);
        return;
        }

        ratio = $('#snImageModal').data('ratio');
        if (!ratio) return;

        if (this.id === 'sn_w' && w) $('#sn_h').val(Math.round(w / ratio));
        if (this.id === 'sn_h' && h) $('#sn_w').val(Math.round(h * ratio));
    });

    // ---------------------------
    // OK button -> insert/update
    // ---------------------------
    $(document).on('click', '#sn_ok', function () {
        const context = $('#snImageModal').data('context');
        const $target = $('#snImageModal').data('targetImg');
        if (!context) return;

        applyImage(context, $target);
        $('#snImageModal').modal('hide');
    });

    })(jQuery);
