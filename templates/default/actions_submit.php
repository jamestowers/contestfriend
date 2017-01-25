<?php
/**
* Default actions after form submit template called by main widget.php template.
* @package chTemplate
*/
      
$widget = cf_Widget::current_widget();
$contest = $widget->contest;
$participant = $widget->participant;
$url = $widget->url;
$widget_id = $widget->widget_id;
                             
$url_enc = urldecode($url);
$ref_url = $url;

$out_actions_submit = '';

if($contest->cf_referral_field=='1')
{
    $short_ref = '';
    if(isset($participant->short_ref))
        $short_ref = $participant->short_ref;
        
    if(!empty($short_ref))
        $ref_url = $short_ref;
    else
        $ref_url = add_query_arg('ref', $participant->code, $ref_url);
         
    echo '<h2>'.__('Fingers crossed!', 'contestfriend').'</div><div class="social_message">'.
sprintf(_n('<p>Thanks for entering our competition. If you’re lucky enough to be a winner, we’ll let you know before February 5th.</p> <p>Increase your chances of winning by sharing the competition with friends and we’ll automatically re-enter you up to five times. </p>', '<p>Thanks for entering our competition. If you’re lucky enough to be a winner, we’ll let you know before February 5th.</p><p> Increase your chances of winning by sharing the competition with friends and we’ll automatically re-enter you up to five times. </p>', $contest->cf_referral_entries), $contest->cf_referral_entries).'</div>';
}

echo '<div class="share-boxes">';
if($contest->cf_referral_field=='1')
{   
    // TOOD move script to footer          
    echo '<div class="col6 flex-center flex-column" id="referral-code">
    <input type="text" value="'.$ref_url.'" style="text-align:center" />
    <div>Copy and share the link above</div>
    </div>';
} 

$social = $contest->cf_social;        

if(is_array($social))
{    
    echo '<div class="col6 flex-center flex-column last" id="social">';

    echo '<div>';
    foreach($social as $s)
    {
        // TODO
        // titles, descriptions, images, ...
        if($s=='googleplus')
        {
            $googleplus_url = urlencode($ref_url);
            $icon = cf_Manager::$plugin_url.'/img/google-plus.png';
            
            echo <<<HTML
        <a rel="nofollow" href="http://plusone.google.com/" onclick="popUp=window.open('https://plus.google.com/share?url={$googleplus_url}', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false"><img src="{$icon}" width="50" alt="Google+" /></a> 
HTML;
        }
        else if($s=='twitter')
        {
            $twitter_text = str_replace('{URL}', $ref_url, $contest->cf_twitter_text);
            $twitter_text = urlencode($twitter_text);
            $icon = cf_Manager::$plugin_url.'/img/twitter.png';
            
            echo <<<HTML
<a rel="nofollow" href="http://twitter.com/" onclick="popUp=window.open('http://twitter.com/home?status={$twitter_text}', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false"><img src="{$icon}" width="50" alt="Twitter"/></a> 
HTML;
        }
        else if($s=='facebook')
        {
            $facebook_url = urlencode($ref_url);
            $facebook_title = urlencode($contest->cf_facebook_title);
            $facebook_image = urlencode($contest->cf_facebook_image);
            $facebook_summary = urlencode($contest->cf_facebook_summary);
            $icon = cf_Manager::$plugin_url.'/img/facebook.png';
            
            echo <<<HTML
<a rel="nofollow" href="http://www.facebook.com/" onclick="popUp=window.open('http://www.facebook.com/sharer.php?s=100&p[url]={$facebook_url}&p[images][0]={$facebook_image}&p[title]={$facebook_title}&p[summary]={$facebook_summary}', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false"><img src="{$icon}" width="50" alt="Facebook" /></a>
HTML;
        }
        else if($s=='pinit')
        {
            $pinterest_url = $url_enc; 
            $pinterest_image = urlencode($contest->cf_pinit_image);
            $pinterest_description = urlencode($contest->cf_pinit_description);
            $icon = cf_Manager::$plugin_url.'/img/pinterest.png';
            
            echo <<<HTML
<a rel="nofollow" href="http://www.pinterest.com/" onclick="popUp=window.open('http://pinterest.com/pin/create/button/?url={$pinterest_url}&media={$pinterest_image}&description={$pinterest_description}', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false"><img src="{$icon}" width="50" alt="Pinterest" /></a>
HTML;
        }
        else if($s=='linkedin')
        {
            $linkedin_url = urlencode($ref_url);
            $linkedin_title = urlencode($contest->cf_linkedin_title);
            $linkedin_summary = urlencode($contest->cf_linkedin_summary);
            $linkedin_source = urlencode($contest->cf_linkedin_source);
            $icon = cf_Manager::$plugin_url.'/img/linkedin.png';
            
            echo <<<HTML
<a rel="nofollow" href="http://www.linkedin.com/" onclick="popUp=window.open('http://www.linkedin.com/shareArticle?mini=true&url={$linkedin_url}&title={$linkedin_title}&summary={$linkedin_summary}&source={$linkedin_source}', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false" target=”_new”><img src="{$icon}" width="50" alt="LinkedIn"/></a>
HTML;
        }
    }
    echo '</div>';
    echo '<div>Click to share on social media</div></div>';
} 

echo '</div><p class="pad">Follow <a href="https://instagram.com/sharestylist" target="_blank">@SHARESTYLIST</a> on social to see if you\'re a winner</p>';
           
