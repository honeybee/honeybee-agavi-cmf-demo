function(event) {
    if (/^hbdemo\.commenting\.comment\-/.test(event._id) && event.seq_number) {
        emit(event.iso_date, 1);
    }
}
