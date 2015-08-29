function(event) {
    if (/^hbdemo\.commenting\.topic\-/.test(event._id)) {
        emit([ event.aggregate_root_identifier, event.seq_number ], 1);
    }
}
