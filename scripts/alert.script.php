<script>
    const successFeedbackId = 'success-feedback';
    const errorFeedbackId = 'error-feedback';

    function success(value) {
        alertMessage(value, successFeedbackId);
    }

    function error(value) {
        alertMessage(value, errorFeedbackId);
    }

    function alertMessage(value, id) {
        $('#' + id)
            .text(value)
            .attr('hidden', false);
    }
</script>