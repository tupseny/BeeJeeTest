<?php

const USERNAME_KEY = ManagerModel::USERNAME_KEY;
const EMAIL_KEY = ManagerModel::EMAIL_KEY;
const STATE_KEY = ManagerModel::STATE_KEY;

const BODY_KEY = 'body';
const COMPLETED_FLAG_KEY = 'is_completed';
const EDITED_BY_KEY = 'edited_by';
const SORT_MODE_KEY = 'sort_mode';
const SORT_KEY_KEY = 'sort_key';

const TABLE_HEAD = [
    [
        'name' => 'Имя пользователя',
        'col' => 3,
        'is_sort_enabled' => true,
        'sort_key' => USERNAME_KEY,
    ],
    [
        'name' => 'Email',
        'col' => 3,
        'is_sort_enabled' => true,
        'sort_key' => EMAIL_KEY,
    ],
    [
        'name' => 'Текст задания',
        'col' => 3,
        'is_sort_enabled' => false,
        'sort_key' => '',
    ],
    [
        'name' => 'Статус',
        'col' => 3,
        'is_sort_enabled' => true,
        'sort_key' => STATE_KEY,
    ],
]
?>

<!--TABLE-->
<table class="table text-center">
    <thead class="">
    <form method="post" action="/manager/sort" novalidate>
        <tr class="row">

            <?php foreach (TABLE_HEAD as $item) : ?>
                <th class="col-<?= $item['col'] ?>">
                    <div class="">
                        <?= $item['name'] ?>
                        <?php if ($item['is_sort_enabled']):
                            if (isset($_COOKIE[SORT_KEY_KEY]) and isset($_COOKIE[SORT_MODE_KEY])){
                                $is_active_asc = $_COOKIE[SORT_KEY_KEY] === $item[SORT_KEY_KEY] ? $_COOKIE[SORT_MODE_KEY] == 1 : false;
                                $is_active_desc = $_COOKIE[SORT_KEY_KEY] === $item[SORT_KEY_KEY] ? $_COOKIE[SORT_MODE_KEY] == -1 : false;
                            }else{
                                $is_active_desc = false;
                                $is_active_asc = false;
                            }
                            ?>
                            <button class="btn btn-sm <?= $is_active_desc ? 'btn-outline-success disabled' : '' ?>"
                                <?= $is_active_desc ? 'disabled' : '' ?>
                                    type="submit" name="<?= $item[SORT_KEY_KEY] ?>" value="desc" aria-label="Desc">
                                <span aria-hidden="true">&darr;</span>
                                <span class="sr-only">Desc</span>
                            </button>
                            <button class="btn btn-sm <?= $is_active_asc ? 'btn-outline-success disabled' : '' ?>"
                                <?= $is_active_asc ? 'disabled' : '' ?>
                                    type="submit" name="<?= $item[SORT_KEY_KEY] ?>" value="asc" aria-label="Asc">
                                <span aria-hidden="true">&uarr;</span>
                                <span class="sr-only">Asc</span>
                            </button>
                        <?php endif; ?>
                    </div>
                </th>
            <?php endforeach; ?>

        </tr>
    </form>
    </thead>
    <tbody>

    <?php foreach ($data['tasks'] as $row) : ?>
        <tr class="row">
            <td class="col-3"><?= htmlspecialchars($row[USERNAME_KEY]) ?></td>
            <td class="col-3"><?= htmlspecialchars($row[EMAIL_KEY]) ?></td>
            <td class="col-3 text-justify ">
                <?php if ($isLogged) { ?>
                    <input class="form-control" id="body_<?= $row['id'] ?>" type="text"
                           value="<?= htmlspecialchars($row[BODY_KEY]) ?>">
                <?php } else {
                    echo "<span class='text text-info'>" . htmlspecialchars($row[BODY_KEY]) . "</span>";
                } ?>
            </td>
            <td class="col-1">
                <?php if ($isLogged) { ?>
                    <div class="form-check">
                        <input id="completed_<?= $row['id'] ?>" value="<?= $row['id'] ?>"
                               class="form-check-input position-static" type="checkbox"
                            <?= $row[COMPLETED_FLAG_KEY] ? 'checked' : '' ?> aria-label="...">
                    </div>
                <?php } else {
                    echo $row[COMPLETED_FLAG_KEY] ? 'OK' : 'In progress...';
                } ?>
            </td>
            <td class="col-2">
                <?= isset($row[EDITED_BY_KEY]) && $row[EDITED_BY_KEY] ? "Edited by '${row[EDITED_BY_KEY]}'" : "" ?>
            </td>
        </tr>
    <?php endforeach; ?>

    <tr class="row">
        <td class="col-10"></td>
        <td class="col-2">
            <button class="btn btn-outline-success btn-block btn-lg px-3"
                <?= $isLogged ? '' : 'hidden' ?> type="button" id="saveBtn" name="update">
                Save
            </button>
        </td>
    </tr>
    </tbody>
</table>

<!--  Pagination  -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <!--      Previous button      -->
        <li class="page-item <?= $data['page'] == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="/manager/index/<?= $data['page'] - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>

        <?php for ($i = 1; $i <= $data['page_count']; $i++): ?>
            <li class="page-item <?= $i == $data['page'] ? 'active' : '' ?>">
                <a class="page-link" href="/manager/index/<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>

        <!--      Next button      -->
        <li class="page-item <?= $data['page'] == $data['page_count'] ? 'disabled' : '' ?>">
            <a class="page-link" href="/manager/index/<?= $data['page'] + 1 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>