<?php
function poll_embedder_init()
{
	global $CONFIG;

	include_once $CONFIG->pluginspath . 'poll_embedder/lib/poll_embedder.php';

	elgg_register_plugin_hook_handler('view', 'all', 'poll_embedder_rewrite');

	//Check where embed code - The wire
	$wire_show = elgg_get_plugin_setting('wire_show', 'poll_embedder');
	if($wire_show == 'yes'){
		elgg_register_plugin_hook_handler('view', 'object/thewire', 'poll_embedder_rewrite');
	}

	//Check where embed code - Blog posts
	$blog_show = elgg_get_plugin_setting('blog_show', 'poll_embedder');
	if($blog_show == 'yes'){
		elgg_register_plugin_hook_handler('view', 'object/blog', 'poll_embedder_rewrite');
	}

	//Check where embed code - Comments
	$comment_show = elgg_get_plugin_setting('comment_show', 'poll_embedder');
	if($comment_show == 'yes'){
		elgg_register_plugin_hook_handler('view', 'annotation/generic_comment', 'poll_embedder_rewrite');
		elgg_register_plugin_hook_handler('view', 'annotation/default', 'poll_embedder_rewrite');
	}

	//Check where embed code - Group topics
	$topicposts_show = elgg_get_plugin_setting('topicposts_show', 'poll_embedder');
	if($topicposts_show == 'yes'){
		elgg_register_plugin_hook_handler('view', 'object/groupforumtopic', 'poll_embedder_rewrite');
	}

	//Check where embed code - Messageboard
	$messageboard_show = elgg_get_plugin_setting('messageboard_show', 'poll_embedder');
	if($messageboard_show == 'yes'){
		elgg_register_plugin_hook_handler('view', 'annotation/default', 'poll_embedder_rewrite');
	}

	//Check where embed code - Pages
	$page_show = elgg_get_plugin_setting('page_show', 'poll_embedder');
	if($page_show == 'yes'){
		elgg_register_plugin_hook_handler('view', 'object/page_top', 'poll_embedder_rewrite');
	}

	//Check where embed code - Pages
	$page_show = elgg_get_plugin_setting('bookmark_show', 'poll_embedder');
	if($page_show == 'yes'){
		elgg_register_plugin_hook_handler('view', 'object/bookmarks', 'poll_embedder_rewrite');
	}
	elgg_extend_view('css','poll_embedder/css');

}

elgg_register_event_handler('init', 'system', 'poll_embedder_init');