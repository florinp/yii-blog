<?php

use yii\widgets\LinkPager;

?>

<h1 class="page-header">Posts</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="3%" class="text-center">#</th>
                <th width="50%" class="text-center">Title</th>
                <th width="20%" class="text-center">Created at</th>
                <th width="25%" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($posts)) { ?>
                <?php foreach($posts as $post) { ?>
                    <tr>
                        <td class="text-center"><?=$post->id?></td>
                        <td><?=$post->title?></td>
                        <td class="text-center"><?=date("Y-m-d H:i:s", $post->created_at)?></td>
                        <td class="text-center">
                            <?=\yii\helpers\Html::a("Edit", ["/admin/post/edit", "id" => $post->id], ['class' => 'btn btn-primary btn-sm'])?>
                            <?=\yii\helpers\Html::a("Delete", ["/admin/post/delete", "id" => $post->id], ['class' => 'btn btn-danger btn-sm'])?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class="text-center" colspan="4"><h2>No data found</h2></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="" colspan="4">
                    <?= LinkPager::widget(['pagination' => $pagination]) ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>