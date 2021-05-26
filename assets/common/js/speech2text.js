var recognition = {};
$(document).ready(function(){
    try {
        // new speech recognition object
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
        recognition = new SpeechRecognition();
        //configs
        recognition.lang = 'en-GB';
        recognition.continuous = true;
    } catch(err) {
        console.log(err.message);
    }
}).on("click", ".speech2text", function(){
    var selector = $(this);
    const output_container = selector.data('output');
    var output_container_id = '#'+output_container;
    let output_type = selector.data('output_type') || '';
    if (!output_type.length) {
        output_type= $(output_container_id).prop('tagName');
        output_type.toLowerCase();
    }

    var wrapper = selector.closest('.speech2text_wrapper');
    var icon = wrapper.find('.speech2text_icon');
    var speaking_indicator = wrapper.find('.speech2text_speaking');

    // This runs when the speech recognition service starts
    recognition.onstart = function() {
        icon.css('color', 'red');
        speaking_indicator.addClass('speech2text_pulsate stop_speech2text clickable');
        speaking_indicator.prop({title: 'Now speaking...click to stop'});
    };
    // This runs when the speech recognition service returns result
    recognition.onresult = function(event) {
        const total_results = event.results.length;
        let transcripts = '';
        for (let i = event.resultIndex; i < total_results; i++) {
            transcripts += event.results[i][0].transcript;
        }

        if (['input', 'textarea'].includes(output_type)) { //input elements
            let current_content = $(output_container_id).val() || '';
            const caret_pos = $(output_container_id)[0].selectionStart;
            const updated_content = current_content.substring(0, caret_pos) + (current_content.length ? ' ' : '') + transcripts.trim() + current_content.substring(caret_pos);
            $(output_container_id).val(capitalize(updated_content));
        } else if (output_type == 'ckeditor') { //CKEditor
            const editor_instance = CKEDITOR.instances[output_container];
            const current_content = editor_instance.getData() || '';
            const updated_content = current_content.trim() + (current_content.trim().length ? ' ' : '') + transcripts;
            editor_instance.setData(capitalize(updated_content));
        } else if (output_type == 'codemirror') { //Code Mirror
            const editor_instance = $('.CodeMirror')[0].CodeMirror;
            const current_content = editor_instance.getValue() || '';
            const updated_content = current_content.trim() + (current_content.trim().length ? ' ' : '') + transcripts;
            editor_instance.setValue(capitalize(updated_content));
        } else { //other elements
            $(output_container_id).append(capitalize(transcripts) + ' ');
        }

        //trigger output event handlers
        const output_events = $(output_container_id).data('speech2text_events') || '';
        const output_events_arr = output_events.split(',') || [];
        if (output_events_arr.length) {
            $.each(output_events_arr, function(i, event) {
                $(output_container_id).trigger(event);
            });
        }
    };
    //with a little delay...
    recognition.onspeechend = function() {
        icon.css('color', 'green');
        speaking_indicator.removeClass('speech2text_pulsate clickable');
        speaking_indicator.prop('title', '');
        recognition.stop();
    };
    // start recognition
    recognition.start();
}).on("click", ".stop_speech2text", function(){
    var wrapper = $(this).closest('.speech2text_wrapper');
    var icon = wrapper.find('.speech2text_icon');
    var speaking_indicator = wrapper.find('.speech2text_speaking');
    icon.css('color', 'green');
    speaking_indicator.removeClass('speech2text_pulsate');
    speaking_indicator.prop('title', '');
    recognition.stop();
});
