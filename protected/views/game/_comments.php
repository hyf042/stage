<?php foreach($comments as $comment): ?>
<div class="comment" id="c<?php echo $comment->comment_id; ?>">

<div class="slide alert alert-success">
	<div class="author">
		<span class="name">
		<?php
		echo $comment->user->nickname; ?>
		</span> says:
	</div>

	<div class="content">
		<?php echo nl2br(CHtml::encode($comment->content)); ?>
	</div>
</div>

</div><!-- comment -->
<?php endforeach; ?>