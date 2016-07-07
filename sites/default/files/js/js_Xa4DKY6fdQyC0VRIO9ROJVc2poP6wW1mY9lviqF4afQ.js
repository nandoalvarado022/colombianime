
/**
 *  @file
 *  Attach Media ckeditor behaviors.
 */

(function ($) {
  Drupal.media = Drupal.media || {};

  Drupal.settings.ckeditor.plugins['media'] = {
    /**
     * Execute the button.
     */
    invoke: function (data, settings, instanceId) {
      if (data.format == 'html') {
        if (jQuery(data.node).is('[data-media-element]')) {
          // Change the view mode for already-inserted media.
          var mediaFile = Drupal.media.filter.extract_file_info(jQuery(data.node));
          Drupal.media.popups.mediaStyleSelector(mediaFile, function (mediaFiles) {
            Drupal.settings.ckeditor.plugins['media'].insertMediaFile(mediaFile, mediaFiles, CKEDITOR.instances[instanceId]);
          }, settings['global']);
        }
        else {
          Drupal.media.popups.mediaBrowser(function (mediaFiles) {
            Drupal.settings.ckeditor.plugins['media'].mediaBrowserOnSelect(mediaFiles, instanceId);
          }, settings['global']);
        }
      }
    },

    /**
     * Respond to the mediaBrowser's onSelect event.
     */
    mediaBrowserOnSelect: function (mediaFiles, instanceId) {
      var mediaFile = mediaFiles[0];
      var options = {};
      Drupal.media.popups.mediaStyleSelector(mediaFile, function (formattedMedia) {
        Drupal.settings.ckeditor.plugins['media'].insertMediaFile(mediaFile, formattedMedia, CKEDITOR.instances[instanceId]);
      }, options);

      return;
    },

    insertMediaFile: function (mediaFile, formattedMedia, ckeditorInstance) {
      // Customization of Drupal.media.filter.registerNewElement().
      var element = Drupal.media.filter.create_element(formattedMedia.html, {
        fid: mediaFile.fid,
        view_mode: formattedMedia.type,
        attributes: formattedMedia.options
      });

      // Use own wrapper element to be able to properly deal with selections.
      // Check prepareDataForWysiwygMode() in plugin.js for details.
      var wysiwygHTML = Drupal.media.filter.getWysiwygHTML(element);

      // Insert element. Use CKEDITOR.dom.element.createFromHtml to ensure our
      // custom wrapper element is preserved.
      if (wysiwygHTML.indexOf("<!--MEDIA-WRAPPER-START-") !== -1) {
        ckeditorInstance.plugins.media.mediaLegacyWrappers = true;
        wysiwygHTML = wysiwygHTML.replace(/<!--MEDIA-WRAPPER-START-(\d+)-->(.*?)<!--MEDIA-WRAPPER-END-\d+-->/gi, '');
      } else {
        wysiwygHTML = '<mediawrapper data="">' + wysiwygHTML + '</mediawrapper>';
      }

      var editorElement = CKEDITOR.dom.element.createFromHtml(wysiwygHTML);
      ckeditorInstance.insertElement(editorElement);

      // Initialize widget on our html if possible.
      if (parseFloat(CKEDITOR.version) >= 4.3 && typeof(CKEDITOR.plugins.registered.widget) != 'undefined') {
        ckeditorInstance.widgets.initOn( editorElement, 'mediabox' );
      }
    },

    /**
     * Forces custom attributes into the class field of the specified image.
     *
     * Due to a bug in some versions of Firefox
     * (http://forums.mozillazine.org/viewtopic.php?f=9&t=1991855), the
     * custom attributes used to share information about the image are
     * being stripped as the image markup is set into the rich text
     * editor.  Here we encode these attributes into the class field so
     * the data survives.
     *
     * @param imgElement
     *   The image
     * @fid
     *   The file id.
     * @param view_mode
     *   The view mode.
     * @param additional
     *   Additional attributes to add to the image.
     */
    forceAttributesIntoClass: function (imgElement, fid, view_mode, additional) {
      var wysiwyg = imgElement.attr('wysiwyg');
      if (wysiwyg) {
        imgElement.addClass('attr__wysiwyg__' + wysiwyg);
      }
      var format = imgElement.attr('format');
      if (format) {
        imgElement.addClass('attr__format__' + format);
      }
      var typeOf = imgElement.attr('typeof');
      if (typeOf) {
        imgElement.addClass('attr__typeof__' + typeOf);
      }
      if (fid) {
        imgElement.addClass('img__fid__' + fid);
      }
      if (view_mode) {
        imgElement.addClass('img__view_mode__' + view_mode);
      }
      if (additional) {
        for (var name in additional) {
          if (additional.hasOwnProperty(name)) {
            switch (name) {
              case 'field_file_image_alt_text[und][0][value]':
                imgElement.attr('alt', additional[name]);
                break;
              case 'field_file_image_title_text[und][0][value]':
                imgElement.attr('title', additional[name]);
                break;
              default:
                imgElement.addClass('attr__' + name + '__' + additional[name]);
                break;
            }
          }
        }
      }
    },

    /**
     * Retrieves encoded attributes from the specified class string.
     *
     * @param classString
     *   A string containing the value of the class attribute.
     * @return
     *   An array containing the attribute names as keys, and an object
     *   with the name, value, and attribute type (either 'attr' or
     *   'img', depending on whether it is an image attribute or should
     *   be it the attributes section)
     */
    getAttributesFromClass: function (classString) {
      var actualClasses = [];
      var otherAttributes = [];
      var classes = classString.split(' ');
      var regexp = new RegExp('^(attr|img)__([^\S]*)__([^\S]*)$');
      for (var index = 0; index < classes.length; index++) {
        var matches = classes[index].match(regexp);
        if (matches && matches.length === 4) {
          otherAttributes[matches[2]] = {
            name: matches[2],
            value: matches[3],
            type: matches[1]
          };
        }
        else {
          actualClasses.push(classes[index]);
        }
      }
      if (actualClasses.length > 0) {
        otherAttributes['class'] = {
          name: 'class',
          value: actualClasses.join(' '),
          type: 'attr'
        };
      }
      return otherAttributes;
    },

    sortAttributes: function (a, b) {
      var nameA = a.name.toLowerCase();
      var nameB = b.name.toLowerCase();
      if (nameA < nameB) {
        return -1;
      }
      if (nameA > nameB) {
        return 1;
      }
      return 0;
    }
  };

})(jQuery);
;
/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
if (typeof window.CKEDITOR_BASEPATH === 'undefined') {
  window.CKEDITOR_BASEPATH = Drupal.settings.ckeditor.editor_path;
}
(function ($) {
  Drupal.ckeditor = (typeof(CKEDITOR) != 'undefined');
  Drupal.ckeditor_ver = false;

  Drupal.ckeditorToggle = function(textarea_ids, TextTextarea, TextRTE){
    if (!CKEDITOR.env.isCompatible) {
      return;
    }

    for (i=0; i<textarea_ids.length; i++){
      if (typeof(CKEDITOR.instances) != 'undefined' && typeof(CKEDITOR.instances[textarea_ids[i]]) != 'undefined'){
        Drupal.ckeditorOff(textarea_ids[i]);
        $('#switch_' + textarea_ids[i]).text(TextRTE);
      }
      else {
        Drupal.ckeditorOn(textarea_ids[i]);
        $('#switch_' + textarea_ids[i]).text(TextTextarea);
      }
    }
  };

  /**
 * CKEditor starting function
 *
 * @param string textarea_id
 */
  Drupal.ckeditorInit = function(textarea_id) {
    var ckeditor_obj = Drupal.settings.ckeditor;
    $("#" + textarea_id).next(".grippie").css("display", "none");
    $("#" + textarea_id).addClass("ckeditor-processed");

    var textarea_settings = false;
    ckeditor_obj.input_formats[ckeditor_obj.elements[textarea_id]].toolbar = eval(ckeditor_obj.input_formats[ckeditor_obj.elements[textarea_id]].toolbar);
    textarea_settings = ckeditor_obj.input_formats[ckeditor_obj.elements[textarea_id]];

    var drupalTopToolbar = $('#toolbar, #admin-menu', Drupal.overlayChild ? window.parent.document : document);

    textarea_settings['on'] =
    {
      configLoaded  : function(ev)
      {
        Drupal.ckeditor_ver = CKEDITOR.version.split('.')[0];
        if (Drupal.ckeditor_ver == 3) {
          ev.editor.addCss(ev.editor.config.extraCss);
        }
        else {
          CKEDITOR.addCss(ev.editor.config.extraCss);
        }
        // Let Drupal trigger formUpdated event [#1895278]
        ev.editor.on('change', function(ev) {
          $(ev.editor.element.$).trigger('change');
        });
        ev.editor.on('blur', function(ev) {
          $(ev.editor.element.$).trigger('blur');
        });
        ev.editor.on('focus', function(ev) {
          $(ev.editor.element.$).trigger('click');
        });
      },
      instanceReady : function(ev)
      {
        var body = $(ev.editor.document.$.body);
        if (typeof(ev.editor.dataProcessor.writer.setRules) != 'undefined') {
          ev.editor.dataProcessor.writer.setRules('p', {
            breakAfterOpen: false
          });

          if (typeof(ckeditor_obj.input_formats[ckeditor_obj.elements[textarea_id]].custom_formatting) != 'undefined') {
            var dtd = CKEDITOR.dtd;
            for ( var e in CKEDITOR.tools.extend( {}, dtd.$block, dtd.$listItem, dtd.$tableContent ) ) {
              ev.editor.dataProcessor.writer.setRules( e, ckeditor_obj.input_formats[ckeditor_obj.elements[textarea_id]].custom_formatting);
            }
            ev.editor.dataProcessor.writer.setRules( 'pre',
            {
              indent: ckeditor_obj.input_formats[ckeditor_obj.elements[textarea_id]].output_pre_indent
            });
          }
        }

        if (ev.editor.config.bodyClass)
          body.addClass(ev.editor.config.bodyClass);
        if (ev.editor.config.bodyId)
          body.attr('id', ev.editor.config.bodyId);
        if (typeof(Drupal.smileysAttach) != 'undefined' && typeof(ev.editor.dataProcessor.writer) != 'undefined')
          ev.editor.dataProcessor.writer.indentationChars = '    ';

        // Let Drupal trigger formUpdated event [#1895278]
        ((ev.editor.editable && ev.editor.editable()) || ev.editor.document.getBody()).on( 'keyup', function() {
          $(ev.editor.element.$).trigger('keyup');
        });
        ((ev.editor.editable && ev.editor.editable()) || ev.editor.document.getBody()).on( 'keydown', function() {
          $(ev.editor.element.$).trigger('keydown');
        });
      },
      focus : function(ev)
      {
        Drupal.ckeditorInstance = ev.editor;
        Drupal.ckeditorActiveId = ev.editor.name;
      },
      afterCommandExec: function(ev)
      {
        if (ev.data.name != 'maximize') {
          return;
        }
        if (ev.data.command.state == CKEDITOR.TRISTATE_ON) {
          drupalTopToolbar.hide();
        } else {
          drupalTopToolbar.show();
        }
      }
    };

    if (typeof Drupal.settings.ckeditor.scayt_language != 'undefined'){
      textarea_settings['scayt_sLang'] = Drupal.settings.ckeditor.scayt_language;
    }

    if (typeof textarea_settings['js_conf'] != 'undefined'){
      for (var add_conf in textarea_settings['js_conf']){
        textarea_settings[add_conf] = eval(textarea_settings['js_conf'][add_conf]);
      }
    }

    //remove width 100% from settings because this may cause problems with theme css
    if (textarea_settings.width == '100%') textarea_settings.width = '';

    if (CKEDITOR.loadFullCore) {
      CKEDITOR.on('loaded', function() {
        textarea_settings = Drupal.ckeditorLoadPlugins(textarea_settings);
        Drupal.ckeditorInstance = CKEDITOR.replace(textarea_id, textarea_settings);
      });
      CKEDITOR.loadFullCore();
    }
    else {
      textarea_settings = Drupal.ckeditorLoadPlugins(textarea_settings);
      Drupal.ckeditorInstance = CKEDITOR.replace(textarea_id, textarea_settings);
    }
  }

  Drupal.ckeditorOn = function(textarea_id, run_filter) {

    run_filter = typeof(run_filter) != 'undefined' ? run_filter : true;

    if (typeof(textarea_id) == 'undefined' || textarea_id.length == 0 || $("#" + textarea_id).length == 0) {
      return;
    }
    if ((typeof(Drupal.settings.ckeditor.load_timeout) == 'undefined') && (typeof(CKEDITOR.instances[textarea_id]) != 'undefined')) {
      return;
    }
    if (typeof(Drupal.settings.ckeditor.elements[textarea_id]) == 'undefined') {
      return;
    }
    var ckeditor_obj = Drupal.settings.ckeditor;

    if (!CKEDITOR.env.isCompatible) {
      return;
    }

    if (run_filter && ($("#" + textarea_id).val().length > 0) && typeof(ckeditor_obj.input_formats[ckeditor_obj.elements[textarea_id]]) != 'undefined' && ((ckeditor_obj.input_formats[ckeditor_obj.elements[textarea_id]]['ss'] == 1 && typeof(Drupal.settings.ckeditor.autostart) != 'undefined' && typeof(Drupal.settings.ckeditor.autostart[textarea_id]) != 'undefined') || ckeditor_obj.input_formats[ckeditor_obj.elements[textarea_id]]['ss'] == 2)) {
      $.ajax({
        type: 'POST',
        url: Drupal.settings.ckeditor.xss_url,
        async: false,
        data: {
          text: $('#' + textarea_id).val(),
          input_format: ckeditor_obj.textarea_default_format[textarea_id],
          token: Drupal.settings.ckeditor.ajaxToken
        },
        success: function(text){
          $("#" + textarea_id).val(text);
          Drupal.ckeditorInit(textarea_id);
        }
      })
    }
    else {
      Drupal.ckeditorInit(textarea_id);
    }
  };

  /**
 * CKEditor destroy function
 *
 * @param string textarea_id
 */
  Drupal.ckeditorOff = function(textarea_id) {
    if (!CKEDITOR.instances || typeof(CKEDITOR.instances[textarea_id]) == 'undefined') {
      return;
    }
    if (!CKEDITOR.env.isCompatible) {
      return;
    }
    if (Drupal.ckeditorInstance && Drupal.ckeditorInstance.name == textarea_id)
      delete Drupal.ckeditorInstance;

    $("#" + textarea_id).val(CKEDITOR.instances[textarea_id].getData());
    CKEDITOR.instances[textarea_id].destroy(true);

    $("#" + textarea_id).next(".grippie").css("display", "block");
  };

  /**
* Loading selected CKEditor plugins
*
* @param object textarea_settings
*/
  Drupal.ckeditorLoadPlugins = function(textarea_settings) {
    if (typeof(textarea_settings.extraPlugins) == 'undefined') {
      textarea_settings.extraPlugins = '';
    }
    if (typeof CKEDITOR.plugins != 'undefined') {
      for (var plugin in textarea_settings['loadPlugins']) {
        textarea_settings.extraPlugins += (textarea_settings.extraPlugins) ? ',' + textarea_settings['loadPlugins'][plugin]['name'] : textarea_settings['loadPlugins'][plugin]['name'];
        CKEDITOR.plugins.addExternal(textarea_settings['loadPlugins'][plugin]['name'], textarea_settings['loadPlugins'][plugin]['path']);
      }
    }
    return textarea_settings;
  };

  /**
 * Returns true if CKEDITOR.version >= version
 */
  Drupal.ckeditorCompareVersion = function (version){
    var ckver = CKEDITOR.version;
    ckver = ckver.match(/(([\d]\.)+[\d]+)/i);
    version = version.match(/((\d+\.)+[\d]+)/i);
    ckver = ckver[0].split('.');
    version = version[0].split('.');
    for (var x in ckver) {
      if (ckver[x]<version[x]) {
        return false;
      }
      else if (ckver[x]>version[x]) {
        return true;
      }
    }
    return true;
  };

  Drupal.ckeditorInsertHtml = function(html) {
    if (!Drupal.ckeditorInstance)
      return false;

    if (Drupal.ckeditorInstance.mode == 'wysiwyg') {
      Drupal.ckeditorInstance.insertHtml(html);
      return true;
    }
    else {
      alert(Drupal.t('Content can only be inserted into CKEditor in the WYSIWYG mode.'));
      return false;
    }
  };

  /**
 * Ajax support
 */
  if (typeof(Drupal.Ajax) != 'undefined' && typeof(Drupal.Ajax.plugins) != 'undefined') {
    Drupal.Ajax.plugins.CKEditor = function(hook, args) {
      if (hook === 'submit' && typeof(CKEDITOR.instances) != 'undefined') {
        for (var i in CKEDITOR.instances)
          CKEDITOR.instances[i].updateElement();
      }
      return true;
    };
  }

  //Support for Panels [#679976]
  Drupal.ckeditorSubmitAjaxForm = function () {
    if (typeof(CKEDITOR.instances) != 'undefined' && typeof(CKEDITOR.instances['edit-body']) != 'undefined') {
      Drupal.ckeditorOff('edit-body');
    }
  };

  function attachCKEditor(context) {
    // make sure the textarea behavior is run first, to get a correctly sized grippie
    if (Drupal.behaviors.textarea && Drupal.behaviors.textarea.attach) {
      Drupal.behaviors.textarea.attach(context);
    }

    $(context).find("textarea.ckeditor-mod:not(.ckeditor-processed)").each(function () {
      var ta_id=$(this).attr("id");
      if (CKEDITOR.instances && typeof(CKEDITOR.instances[ta_id]) != 'undefined'){
        Drupal.ckeditorOff(ta_id);
      }

      if ((typeof(Drupal.settings.ckeditor.autostart) != 'undefined') && (typeof(Drupal.settings.ckeditor.autostart[ta_id]) != 'undefined')) {
        Drupal.ckeditorOn(ta_id);
      }

      if (typeof(Drupal.settings.ckeditor.input_formats[Drupal.settings.ckeditor.elements[ta_id]]) != 'undefined') {
        $('.ckeditor_links').show();
      }

      var sel_format = $("#" + ta_id.substr(0, ta_id.lastIndexOf("-")) + "-format--2");
      if (sel_format && sel_format.not('.ckeditor-processed')) {
        sel_format.addClass('ckeditor-processed').change(function() {
          Drupal.settings.ckeditor.elements[ta_id] = $(this).val();
          if (CKEDITOR.instances && typeof(CKEDITOR.instances[ta_id]) != 'undefined') {
            $('#'+ta_id).val(CKEDITOR.instances[ta_id].getData());
          }
          Drupal.ckeditorOff(ta_id);
          if (typeof(Drupal.settings.ckeditor.input_formats[$(this).val()]) != 'undefined'){
            if ($('#'+ta_id).hasClass('ckeditor-processed')) {
              Drupal.ckeditorOn(ta_id, false);
            }
            else {
              Drupal.ckeditorOn(ta_id);
            }
            $('#switch_'+ta_id).show();
          }
          else {
            $('#switch_'+ta_id).hide();
          }
        });
      }
    });
  }

  /**
 * Drupal behaviors
 */
  Drupal.behaviors.ckeditor = {
    attach:
    function (context) {
      // If CKEDITOR is undefined and script is loaded from CDN, wait up to 15 seconds until it loads [#2244817]
      if ((typeof(CKEDITOR) == 'undefined') && Drupal.settings.ckeditor.editor_path.match(/^(http(s)?:)?\/\//i)) {
        if (typeof(Drupal.settings.ckeditor.loadAttempts) == 'undefined') {
          Drupal.settings.ckeditor.loadAttempts = 50;
        }
        if (Drupal.settings.ckeditor.loadAttempts > 0) {
          Drupal.settings.ckeditor.loadAttempts--;
          window.setTimeout(function() {
            Drupal.behaviors.ckeditor.attach(context);
          }, 300);
        }
        return;
      }
      if ((typeof(CKEDITOR) == 'undefined') || !CKEDITOR.env.isCompatible) {
        return;
      }
      attachCKEditor(context);
    },
    detach:
    function(context, settings, trigger){
      $(context).find("textarea.ckeditor-mod.ckeditor-processed").each(function () {
        var ta_id=$(this).attr("id");
        if (CKEDITOR.instances[ta_id])
          $('#'+ta_id).val(CKEDITOR.instances[ta_id].getData());
        if(trigger != 'serialize') {
          Drupal.ckeditorOff(ta_id);
          $(this).removeClass('ckeditor-processed');
        }
      });
    }
  };

  // Support CTools detach event.
  $(document).bind('CToolsDetachBehaviors', function(event, context) {
    Drupal.behaviors.ckeditor.detach(context, {}, 'unload');
  });
})(jQuery);

/**
 * IMCE support
 */
var ckeditor_imceSendTo = function (file, win){
  var cfunc = win.location.href.split('&');

  for (var x in cfunc) {
    if (cfunc[x].match(/^CKEditorFuncNum=\d+$/)) {
      cfunc = cfunc[x].split('=');
      break;
    }
  }
  CKEDITOR.tools.callFunction(cfunc[1], file.url);
  win.close();
}

;
