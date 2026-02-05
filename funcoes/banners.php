<?php


function Banner1()
{
    // Pega a URL principal do site
    $url_principal = get_home_url();

    // Pega o título do site
    $titulo_site = get_bloginfo('name');

    $banner1 = "";
    $banner1 .= "Saiba mais sobre ";
    $banner1 .= "<a title='Saiba mais sobre $titulo_site' href='" . $url_principal . "'>" . $titulo_site . "</a>";
    $banner1 .= "";

    return $banner1;
}




function Banner2($categoria)
{
    if(isset($categoria[1]) && isset($categoria[0]) ){}else{ return $banner2="";}
    $url_principal = $categoria[1];
    $titulo_site = $categoria[0];

    ///echo "$&@@@".$url_principal."#$%%$";

    $banner2 = "";
    $banner2 .= "Veja mais sobre ";
    $banner2 .= "<a title='veja mais sobre $titulo_site' href='" . $url_principal . "'>" . $titulo_site . "</a>";
    $banner2 .= "";

    return $banner2;
}
