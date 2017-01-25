<?php
/**
* Default actions template called by main widget.php template.
* @package chTemplate
*/

$widget = cf_Widget::current_widget();
$contest = $widget->contest;
$participant = $widget->participant;
$url = $widget->url;
$widget_id = $widget->widget_id;
$widget_errors = $widget->error;
$ref = isset($_GET[$contest->ref_variable]) ? $_GET[$contest->ref_variable] : '';

echo '<form id="'.$widget_id.'_form" method="post">';
echo '<input type="hidden" name="contest_id" class="cf_contest_id" value="'.$contest->ID.'" /><input type="hidden" name="cf_ref" class="cf_ref" value="'.esc_attr($ref).'" /><input type="hidden" name="url" class="cf_url" value="'.$url.'" />';

// first/last name field     
if($contest->cf_name_field=='1') 
{
    $first_name_css = 'first_name';
    $last_name_css = 'last_name';
    
    if($contest->cf_name_field_req=='1')
    {
        $first_name_css .= ' cf_required';
        $last_name_css .= ' cf_required';
    }   
   
    if(!empty($widget_errors['first_name']))
        $first_name_css .= ' error_req';
    
    if(!empty($widget_errors['last_name']))
        $last_name_css .= ' error_req';    
    
    echo '<div class="names"><div class="cf_first_name"><input type="text" class="'.$first_name_css.'" name="first_name" placeholder="First name" /></div>
<div class="cf_last_name"><input type="text" class="'.$last_name_css.'" name="last_name" placeholder="Last name" /></div><div class="cf_clear"></div></div>';
}

$email_css = 'cf_email';
if(!empty($widget_errors['email']))
    $email_css .= ' error_req';
    
echo '<div><input type="text" class="'.$email_css.'" name="email" placeholder="email@address.com" /></div>';

$terms = get_terms( array(
    'taxonomy' => 'contest_category',
    'hide_empty' => false,
) );

echo '<div class="checkbox-group text-center">';
foreach($terms as $term){
    echo '<div class="checkbox">';
    echo '<input id="prize-cat-' . $term->term_id . '" type="checkbox" name="prize-categories[]" value="' . $term->term_id . '" /> <label for="prize-cat-' . $term->term_id . '">' . $term->name . '</label>';
    echo '</div>';
}
echo '</div>';

if(!empty($widget_errors['prize-categories']))
    echo '<span class=" error_req cf_clear">Please choose at least one prize category</span>';

echo '<div class="checkbox checkbox-small">';
    echo '<input id="accept-terms" type="checkbox" name="prize-categories[]" value="i" /> <label for="accept-terms">Tick box to accept <a href="/terms" class="" id="" target="_blank">Ts & Cs</a></label>';
echo '</div>';

echo '<div class="clear group"><input type="submit" class="cf_submit" value="'.esc_attr($contest->cf_submit_text).'" /></div></form>';
