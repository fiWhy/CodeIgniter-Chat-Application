<?php
function message($type, $title, $msg){
    $html = '<div class="callout callout-danger">
             <h4>'.$title.'</h4>
             <p>'.$msg.'</p>
                  </div>';
    
    return $html;
}