function(event) {
    if (/^hbdemo\.commenting\.account\-/.test(event._id) && event.seq_number) {
        emit(event.iso_date, 1);
    }
}
