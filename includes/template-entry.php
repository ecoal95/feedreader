<li class="feed-entry author-<?php echo nameToId($entry->author) ?>">
	<h3 class="feed-entry-title"><a href="<?php echo getLink($entry->link); ?>" rel="nofollow" title="<?php $entry->title ?>"><?php echo $entry->title ?></a></h3>
	<h5 class="feed-entry-meta">Por <?php echo $entry->author ?> | <?php echo timeAgo(strtotime($entry->publishedDate)) ?></h5>
	<div class="feed-entry-content"><?php echo $entry->contentSnippet ?></div>
</li>