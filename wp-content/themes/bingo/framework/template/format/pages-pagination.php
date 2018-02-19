<div class="e-pagination">
    <?php wp_link_pages('before=<div class="post-pagination">&after=</div>&pagelink=Page %'); ?>
    <p class="prev_post"><?php previous_post_link('%link','<i class="fa fa-chevron-left"></i> Previous Post'); ?></p>
    <p class="next_post"><?php next_post_link('%link','Next Post <i class="fa fa-chevron-right"></i>'); ?></p>
<br>
</div>