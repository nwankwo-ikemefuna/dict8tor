var recognition = {};
let final_transcript = ''; //we need this guy to persist
let output_container_id = '';
let last_debounce_transcript = '';
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
    output_container_id = '#'+output_container;
    let output_type = selector.data('output_type') || '';

    if (!output_type.length) {
        output_type = $(output_container_id).prop('tagName');
        output_type.toLowerCase();
    }

    //allow interim results?
    if (selector.data('with_interim') == 1) {
        recognition.interimResults = true;
    }

    //update final transcript from current content
    if ($(output_container_id).val().length) {
        final_transcript = $(output_container_id).val();
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
            let result = event.results[i];
            let isFinal = result.isFinal && (result[0].confidence > 0);
            if (isFinal) {
                transcript = result[0].transcript;
                final_transcript += (final_transcript.length ? '. ' : '') + capitalize2(result[0].transcript);
                if (transcript == last_debounce_transcript) {
                    return;
                }
                last_debounce_transcript = transcript;
            } else {
                transcript += result[0].transcript;
                interim_transcript += result[0].transcript;
            }
        }

        if (recognition.interimResults) {
            const interim_wrapper = $(output_container_id).closest('.speech2text_interim_wrapper');
            const final_ouput_span = interim_wrapper.find('span.final_output');
            const interim_ouput_span = interim_wrapper.find('span.interim_output');
            //set
            final_ouput_span.text(capitalize(final_transcript));
            interim_ouput_span.text(interim_transcript);
            //get
            const complete_output = final_ouput_span.text() + interim_ouput_span.text();
            if (output_type == 'summernote') {
                $(output_container_id).summernote('code', complete_output);
            } else {
                $(output_container_id).val(complete_output);
            }
            localStorage.setItem('s2t_dict8_note', complete_output);
        } else {
            if (['input', 'textarea'].includes(output_type)) { //input elements
                let current_content = $(output_container_id).val() || '';
                const caret_pos = $(output_container_id)[0].selectionStart;
                const updated_content = current_content.substring(0, caret_pos) + (current_content.length ? ' ' : '') + transcript.trim() + current_content.substring(caret_pos);
                $(output_container_id).val(capitalize2(updated_content));
            } else if (output_type == 'summernote') { //Summernote
                let current_content = $(output_container_id).summernote('code');
                const updated_content = current_content.trim() + (current_content.trim().length ? ' ' : '') + transcript;
                $(output_container_id).summernote('code', capitalize2(updated_content));
            } else if (output_type == 'ckeditor') { //CKEditor
                const editor_instance = CKEDITOR.instances[output_container];
                const current_content = editor_instance.getData() || '';
                const updated_content = current_content.trim() + (current_content.trim().length ? ' ' : '') + transcript;
                editor_instance.setData(capitalize2(updated_content));
            } else if (output_type == 'codemirror') { //Code Mirror
                const editor_instance = $('.CodeMirror')[0].CodeMirror;
                const current_content = editor_instance.getValue() || '';
                const updated_content = current_content.trim() + (current_content.trim().length ? ' ' : '') + transcript;
                editor_instance.setValue(capitalize2(updated_content));
            } else { //other elements
                $(output_container_id).append(capitalize2(transcript) + ' ');
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
        recognition.stop();
    };
    //on error
    recognition.onerror = function() {
        recognition.stop();
        alert('Something is not right! Check your internet connection or reload this page and try again.');
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
}).on("keyup", '#s2t_dict8_note', function(){
    //stop recognition
    recognition.stop();
    //update final output
    final_transcript = $(this).val();
    localStorage.setItem('s2t_dict8_note', final_transcript);
    const interim_wrapper = $(output_container_id).closest('.speech2text_interim_wrapper');
    interim_wrapper.find('span.final_output').text(final_transcript);
});

function capitalize2(s) {
    return s.replace(/\S/, function(m) { return m.toUpperCase(); });
}