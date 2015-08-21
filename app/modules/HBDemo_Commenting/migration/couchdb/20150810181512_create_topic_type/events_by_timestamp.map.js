function(event) {
    if (/^hbdemo\.commenting\.topic\-/.test(event._id) && event.seq_number) {
        emit(event.iso_date, 1);
    }
}
