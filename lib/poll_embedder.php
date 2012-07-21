<?php
function poll_embedder_rewrite($hook, $entity_type, $returnvalue, $params){
    global $CONFIG;

    $view = $params['view'];
    $context = elgg_get_context();

    $returnvalue = poll_embedder_parser(' ' . $returnvalue . ' ', $view, $context);

    return $returnvalue;
}

function poll_embedder_parser($input, $view, $context)
{
    if (($view == 'annotation/generic_comment' || $view == 'annotation/default') && ($context != 'blog' && $context != 'messageboard' && $context != 'widgets' && $context != 'pages' && $context != 'bookmarks')){
        return $input;
    }

    if($view == 'annotation/default' && elgg_get_plugin_setting('messageboard_show', 'poll_embedder') == 'no'){
        return $input;
    }


    //Find a poll
    $pattern = '/(\[)(polldaddy)(.*?)(=")(.*?)("\])/';

    if(preg_match_all($pattern, $input, $matches, PREG_SET_ORDER))
    {
        foreach($matches as $match)
        {
            $source = trim($match[2]); //polldaddy
            $type   = trim($match[3]); //poll, rating, etc
            $pollid = trim($match[5]);

            $input = str_replace($match[0], pollembed_create_embed_object($pollid, $source, $type), $input);
        }

    }

    return $input;
}

function pollembed_create_embed_object($id, $source, $type)
{
    if (!isset($id)) {
        return '<p><b>' . elgg_echo('poll_embedder:noid') . '</b></p>';
    }

    switch($source)
    {
    case "polldaddy":
        switch($type)
        {
        case "poll":
            $code = '<script type="text/javascript" charset="utf-8" src="http://static.polldaddy.com/p/'.$id.'.js"></script>
<noscript><a href="http://polldaddy.com/poll/'.$id.'/">View poll</a></noscript>';
            break;

        case "rating":
            $code = '<div id="pd_rating_holder_'.$id.'"></div><script type="text/javascript">PDRTJS_settings_'.$id.' = {"id" : "'.$id.'","unique_id" : "default","title" : "","permalink" : ""};</script><script type="text/javascript" src="http://i.polldaddy.com/ratings/rating.js"></script>';
            break;

        default:
            break;

        }

        break;

    default:
        break;

    }

    return $code;

}