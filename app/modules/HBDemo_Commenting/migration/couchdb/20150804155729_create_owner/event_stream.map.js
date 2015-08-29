function(event) {
    if (/^hbdemo\.commenting\.owner\-/.test(event._id)) {
        emit([ event.aggregate_root_identifier, event.seq_number ], 1);
    }
}
