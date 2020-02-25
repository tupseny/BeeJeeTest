<script>
    const url = '/manager/update';

    const data = [
        <?php foreach ($data['tasks'] as $row): ?>
        {
            id: <?=$row['id']?>,
            body_old: "<?=htmlspecialchars($row['body'])?>",
            completed: "<?=$row['is_completed'] ? true : false ?>",
        },
        <?php endforeach; ?>
    ];

    $(document).ready(function () {
        <?php
            if (isset($_COOKIE['feedback']) and $_COOKIE['feedback'] === 'success'){
                echo "success('Задача успешно добавлена')";
                setcookie('feedback', '');
            }
        ?>
    });

    $('#saveBtn').click(function () {
        console.log('Clicked');
        let changedData = [];

        for (let i = 0; i < data.length; i++) {
            const taskId = data[i].id;
            let dataObj = {id: taskId};

            const bodySearchId = 'body_' + taskId;
            const checkedSearchId = 'completed_' + taskId;

            const newCompleted = $('#' + checkedSearchId).is(':checked');
            const oldCompleted = data[i].completed;
            const flagCompletedUpdated = newCompleted ^ oldCompleted;

            const newBody = $('#' + bodySearchId).val();
            const oldBody = data[i].body_old;
            const flagBodyUpdated = newBody !== oldBody;

            addPropertyIfChanged('is_completed', flagCompletedUpdated, newCompleted);
            addPropertyIfChanged('body', flagBodyUpdated, newBody);

            changedData.push(dataObj);

            function addPropertyIfChanged(propKey, flag, value) {
                if (flag) {
                    dataObj = {...dataObj, [propKey]: value}
                }
            }
        }

        $('#saveBtn').attr('disabled', true);

        $.ajax({
            type: "POST",
            url: url,
            data: "data=" + JSON.stringify(changedData),
            success: saveSuccess
        });
    });

    function saveSuccess(result) {
        console.log(result);
        if (!result){
            success('Changes successfully updated!');
        }else{
            error(result);
        }

        $('#saveBtn').attr('disabled', false);

    }
</script>