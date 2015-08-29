function(event) {
    if (/^hbdemo\.commenting\.comment\-/.test(event._id)) {
        emit([ event.aggregate_root_identifier, event.seq_number ], 1);
    }
}
