$(document).ready(function(){
    //switch theme 
    switchTheme();
    //update current note
    const current_note = localStorage.getItem('s2t_dict8_note') || '';
    updateNote(current_note);
    //render saved notes
    renderSavedNotes();
}).on("change", "#theme_switcher", function(){
    const site_theme = $(this).is(':checked') ? 'dark' : 'light';
    localStorage.setItem('site_theme', site_theme);
    switchTheme();
}).on("click", "#copy_note", function(){
    const note = $('#s2t_dict8_note').val();
    copyToClickboard(note);
}).on("click", "#save_note", function(){
    const note = $('#s2t_dict8_note').val().trim();
    if (!note.length) {
        alert('Nothing to save!');
        return false;
    }
    const saved_notes_str = localStorage.getItem('saved_dict8_notes') || '';
    let saved_notes_arr = [];
    if (saved_notes_str.length) {
        saved_notes_arr = JSON.parse(saved_notes_str);
        if (!saved_notes_arr.includes(note)) {
            saved_notes_arr.unshift(note); //push to beginning
            localStorage.setItem('saved_dict8_notes', JSON.stringify(saved_notes_arr));
            //update saved notes
            renderSavedNotes();
        } else {
            alert('This note is already saved!');
        }
    } else {
        return false;
    }
}).on("click", "#clear_note", function(){
    if (confirm('Sure to clear notes field?')) {
        const interim_wrapper = $('.speech2text_interim_wrapper');
        interim_wrapper.find('span.final_output').empty();
        interim_wrapper.find('span.interim_output').empty();
        $('#s2t_dict8_note').val('');
        if (typeof final_transcript !== 'undefined') {
            final_transcript = ''; //reset final transcript
        }
        if (localStorage.getItem('s2t_dict8_note') !== null) {
            localStorage.removeItem('s2t_dict8_note');
        }
    }
}).on("click", ".edit_saved_note", function(){
    if (confirm('Sure to edit this note? You may lose any unsaved notes!')) {
        const index = $(this).data('index');
        const saved_notes_str = localStorage.getItem('saved_dict8_notes') || '';
        const saved_notes_arr = JSON.parse(saved_notes_str);
        const note = saved_notes_arr[index];
        updateNote(note);
    }
}).on("click", ".delete_saved_note", function(){
    if (confirm('Sure to delete this note?')) {
        const index = $(this).data('index');
        const saved_notes_str = localStorage.getItem('saved_dict8_notes') || '';
        const saved_notes_arr = JSON.parse(saved_notes_str);
        saved_notes_arr.splice(index, 1);
        localStorage.setItem('saved_dict8_notes', JSON.stringify(saved_notes_arr));
        //update saved notes
        renderSavedNotes();
    }
}).on("click", "#delete_all_saved_notes", function(){
    if (confirm('Sure to delete all saved notes?')) {
        if (localStorage.getItem('saved_dict8_notes') !== null) {
            localStorage.removeItem('saved_dict8_notes');
            $('#saved_notes_section').hide();
        }
    }
}).on("click", ".note_action", function(){
    const action = $(this).data('action');
    const note = $('#dict8_form').find('#s2t_dict8_note').val();
    var success_callback = function(jres) {
        if (jres.status) {
            if (action == 'export_pdf') {
                window.open(base_url+'note', '_self');
            }
        } else {
            status_box('status_msg', jres.error, 'danger', 'class', 10000, 'dict8_form');
        }
    };
    post_data_ajax(base_url+'api/web/note_actions', {action, note}, false, success_callback);
});

function switchTheme() {
    const site_theme = localStorage.getItem('site_theme') || 'light';
    if (site_theme == 'dark') {
        $('body').addClass('dark-theme');
        $('#theme_switcher').prop('checked', true);
    } else {
        $('body').removeClass('dark-theme');
        $('#theme_switcher').prop('checked', false);
    }
}

function renderSavedNotes() {
    //saved notes
    const saved_notes_str = localStorage.getItem('saved_dict8_notes') || '';
    if (saved_notes_str.length) {
        const saved_notes_arr = JSON.parse(saved_notes_str);
        const container = $('#saved_notes_section #saved_notes');
        container.empty();
        $.each(saved_notes_arr, function(index, note) {
            if (index >= 25) return false; //last 25 saved notes works great IMHO
            const truncated_note = truncateWords(note, 7);
            const item = $('<div>', {class: 'saved_note_item'}).text(truncated_note+'...');
            const edit_btn = $('<a>', {class: 'edit_saved_note text-info', 'data-index': index, href: 'javascript:;'}).text('Edit');
            const del_btn = $('<a>', {class: 'delete_saved_note text-danger m-l-10', 'data-index': index, href: 'javascript:;'}).text('Delete');
            const actions = $('<div>').append(edit_btn, del_btn).appendTo(item);
            container.append(item);
        });
        $('#saved_notes_section').show();
    } else {
        $('#saved_notes_section').hide();
    }
}

function updateNote(note) {
    if (note.length) {
        const interim_wrapper = $('.speech2text_interim_wrapper');
        interim_wrapper.find('span.final_output').text(note);
        $('#s2t_dict8_note').val(note);
    }
}