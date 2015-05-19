<?php

use yii\widgets\LinkPager;

?>

<h1 class="page-header">Users</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th width="3%" class="text-center">#</th>
            <th width="40%" class="text-center">Username</th>
            <th width="20%" class="text-center">Created at</th>
            <th width="20%" class="text-center">Updated at</th>
            <th width="25%" class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($users)) { ?>
            <?php foreach($users as $user) { ?>
                <tr>
                    <td class="text-center"><?=$user->id?></td>
                    <td><?=$user->username?></td>
                    <td class="text-center"><?=date("Y-m-d H:i:s", $user->created_at)?></td>
                    <td class="text-center"><?=date("Y-m-d H:i:s", $user->updated_at)?></td>
                    <td class="text-center">
                        <?php if(!$user->hasRole('admin')): ?>
                            <?=\yii\helpers\Html::a("Edit", ["/admin/user/edit", "id" => $user->id], ['class' => 'btn btn-primary btn-sm'])?>
                            <?=\yii\helpers\Html::a("Delete", ["/admin/user/delete", "id" => $user->id], ['class' => 'btn btn-danger btn-sm'])?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td class="text-center" colspan="5"><h2>No data found</h2></td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr>
            <td class="" colspan="5">
                <?= LinkPager::widget(['pagination' => $pagination]) ?>
            </td>
        </tr>
        </tfoot>
    </table>
</div>