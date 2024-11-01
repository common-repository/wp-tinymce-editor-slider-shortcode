(function() {
    
    tinymce.PluginManager.add('upload_mce_button', function( editor, url ) {
        editor.addButton( 'upload_mce_button', {
            text: 'Add Slider images',
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: 'Insert Media',
                    body: [
                        {
                            type: 'textbox',
                            name: 'tab1content',
                            label: ' class name',
                            value: '',
                            classes: 'img_title',
                        },
                        {
                            type: 'textbox',
                            name: 'img',
                            label: 'Image',
                            readonly:'readonly',
                            value: '',
                            classes: 'my_input_image',
                        },
                        {
                            type: 'button',
                            name: 'my_upload_button',
                            label: '',
                            text: 'Upload image',
                            classes: 'my_upload_button',
                        },
                    ],
                    onsubmit: function(e) {
                        //alert(e.data.img)
                        editor.insertContent( '[slider-shortcode img="' + e.data.img + '" classname="' +e.data.tab1content +'"]');
                    }
                });
            },
        });
    });

})();

jQuery(document).ready(function($){
   
    $(document).on('click', '.mce-my_upload_button', upload_image_tinymce);

    function upload_image_tinymce(e) {
        e.preventDefault();
        var $input_field = $('.mce-my_input_image');
        var custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Add Image',
            button: {
                text: 'Add Image'
            },
            multiple: true
        });
        custom_uploader.on('select', function() {
           // var attachment = custom_uploader.state().get('selection').toJSON();
            //console.log(attachment);
            //return attachment;
            //$input_field.val(attachment.url);
            var attachments = custom_uploader.state().get('selection').map( 
            function( attachment ) {

                    attachment.toJSON();
                    console.log(attachment);
                    return attachment;

            });
              var i;
              var arr=[];
           for (i = 0; i < attachments.length; ++i) {
           arr.push(attachments[i].attributes.id);
            //arr.push(attachments[i].attributes.url);
            var image_id = arr.toString();
            $input_field.val(image_id);


            }



        });
        custom_uploader.open();
    }
});