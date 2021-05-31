var recognition = {};
let final_transcript = ''; //we need this guy to persist
let final_output = ''; //we need this guy to persist
let output_container_id = '';
$(document).ready(function(){
    try {
        // new speech recognition object
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
        recognition = new SpeechRecognition();
        //configs
        recognition.lang = 'en-GB';
        recognition.continuous = true;
        // recognition.interimResults = true;
    } catch(err) {
        console.log(err.message);
    }
}).on("click", ".speech2text", function(){
    var selector = $(this);
    const output_container = selector.data('output');
    output_container_id = '#'+output_container;
    let output_type = selector.data('output_type') || '';
    if (!output_type.length) {
        output_type = $(output_container_id).prop('tagName');
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
        let transcript = '';
        let interim_transcript = ''; //local because we don't want it to persist like final transcript
        const total_results = event.results.length;
        for (let i = event.resultIndex; i < total_results; i++) {
            if (event.results[i].isFinal) {
                transcript = event.results[i][0].transcript;
                final_transcript += event.results[i][0].transcript;
            } else {
                transcript += event.results[i][0].transcript;
                interim_transcript += event.results[i][0].transcript;
            }
        }

        if (recognition.interimResults) {
            $(output_container_id).find('.final_content').eq(0).html(capitalize(final_transcript));
            $(output_container_id).find('.interim_content').eq(0).html(interim_transcript);
            final_output = $(output_container_id).find('.final_content').eq(0).text();
            final_output += $(output_container_id).find('.interim_content').eq(0).text();
            $(output_container_id).summernote('code', final_output);
        } else {
            if (['input', 'textarea'].includes(output_type)) { //input elements
                let current_content = $(output_container_id).val() || '';
                const caret_pos = $(output_container_id)[0].selectionStart;
                const updated_content = current_content.substring(0, caret_pos) + (current_content.length ? ' ' : '') + transcript.trim() + current_content.substring(caret_pos);
                $(output_container_id).val(capitalize(updated_content));
            } else if (output_type == 'summernote') { //Summernote
                let current_content = $(output_container_id).summernote('code');
                const updated_content = current_content.trim() + (current_content.trim().length ? ' ' : '') + transcript;
                $(output_container_id).summernote('code', capitalize(updated_content));
            } else if (output_type == 'ckeditor') { //CKEditor
                const editor_instance = CKEDITOR.instances[output_container];
                const current_content = editor_instance.getData() || '';
                const updated_content = current_content.trim() + (current_content.trim().length ? ' ' : '') + transcript;
                editor_instance.setData(capitalize(updated_content));
            } else if (output_type == 'codemirror') { //Code Mirror
                const editor_instance = $('.CodeMirror')[0].CodeMirror;
                const current_content = editor_instance.getValue() || '';
                const updated_content = current_content.trim() + (current_content.trim().length ? ' ' : '') + transcript;
                editor_instance.setValue(capitalize(updated_content));
            } else { //other elements
                $(output_container_id).append(capitalize(transcript) + ' ');
            }
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
        $(output_container_id).find('.final_content').eq(0).html(final_output);
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
    $(output_container_id).find('.final_content').eq(0).html(final_output);
    recognition.stop();
});