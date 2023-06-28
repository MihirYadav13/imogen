(function() {
    tinymce.PluginManager.add( window.cta_button_shortcode_vars.class_name, function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton(window.cta_button_shortcode_vars.class_name, {
            title: 'Insert CTA Button',
            text: 'CTA',
            classes: ' fff-custom-cta-button-class ', 
            cmd: window.cta_button_shortcode_vars.class_name,
        });
        
        // Add Command when Button Clicked
        editor.addCommand(window.cta_button_shortcode_vars.class_name, function() {
            
            var getStyleArray = function(styles){
                var result = [];
                styles.forEach(function(el) {
                    var label = el.replace(/-/g, ' ').replace(/_/g, ' ');
                    label = label.replace(/(^\w{1})|(\s{1}\w{1})/g, match => match.toUpperCase());
                    result.push({
                        text: label,
                        value: el,
                    });
                });
                return result;
            }

            var body = [
                {
                    type: 'textbox', 
                    name: 'label', 
                    label: 'Label',
                },
                {
                    type   : 'listbox',
                    name   : 'cta_type',
                    label  : 'CTA Type',
                    values : [
                        { text: 'Internal Post/Page', value: 'post_id' },
                        { text: 'External URL', value: 'external_url' },
                    ],
                    value : 'post_id', // Sets the default
                },
                {
                    type: 'textbox', 
                    name: 'post_id_or_external_url', 
                    label: 'Post ID/External Url',
                },
                {
                    type   : 'listbox',
                    name   : 'style',
                    label  : 'Style',
                    values : getStyleArray(window.cta_button_shortcode_vars.styles),
                    value : window.cta_button_shortcode_vars.styles[0], // Sets the default
                },
                {
                    type   : 'checkbox',
                    name   : 'new_tab',
                    label  : 'Open in new tab?',
                },
                {
                    type   : 'checkbox',
                    name   : 'open_video_modal',
                    label  : 'Open video link in modal?',
                },
            ];
            
            editor.windowManager.open({
                title: 'Edit CTA Configuration',
                body: body,
                onsubmit: function(e) {
                    if(e.data.post_id_or_external_url.length == 0)
                        return;

                    var post_id_or_ext_url = e.data.post_id_or_external_url.replace(/(['"])/g, '\\$1');

                    var label = e.data.label.replace(/(['"])/g, '\\$1');

                    var type = e.data.open_video_modal ? 'external_url' : e.data.cta_type;

                    var shortcode = 'label="'+label+'" '+(type == 'post_id' ? 'post_id="'+post_id_or_ext_url+'"' : 'external_url="'+post_id_or_ext_url+'"')+ ' style="'+e.data.style+'"';
                    shortcode = window.cta_button_shortcode_vars.shortcode_tag + ' ' + shortcode;
                    shortcode += e.data.new_tab ? ' new_tab="true"' : ''; 
                    shortcode += e.data.open_video_modal ? ' open_video_modal="true"' : ''; 
                    shortcode = '[' + shortcode + ']';

                    editor.execCommand('mceInsertContent', true, shortcode);
                },
            });
        });
    });
})();