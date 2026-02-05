<?php

add_filter('the_content', 'do_shortcode');

date_default_timezone_set('America/Sao_Paulo');

show_admin_bar(false);

add_theme_support('menus', 'widget');

add_post_type_support('page', 'excerpt');

add_post_type_support('post', 'excerpt');

////remove_action('init', 'wp_admin_bar_init');

add_theme_support('menus', 'widget');

add_theme_support('title-tag');

/**********************************************************************/

register_nav_menu('menu_principal', 'Menu Principal - Topo');

add_theme_support('post-thumbnails');

/**********************************************************************/

function disable_block_library_css()

{

    wp_dequeue_style('wp-block-library');

    // wp_dequeue_style('wp-block-library-theme');

    // wp_dequeue_style('wc-block-style'); // Se estiver usando o WooCommerce

}

add_action('wp_enqueue_scripts', 'disable_block_library_css', 100);

/**********************************************************************/

$addr = get_template_directory();

$addr = str_replace("\\", "/", $addr);

require_once "" . $addr . "/funcoes/reduzir.php"; 
require_once "" . $addr . "/funcoes/imagemAgrupada.php"; 








/**********************************************************************/



//add_filter('jpeg_quality', function($arg){ return 50; });











































































/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/

/**********************************************************************/



require_once "" . $addr . "/funcoes/banners.php";

















//$conteudos_para_inserir[2] = Banner1(); // Conteúdo dinâmico para índice 2

//$conteudos_para_inserir[4] = Banner2(GetCategoria($categoria)); // Conteúdo dinâmico baseado na categoria













function inserir_html_no_meio_do_conteudo($content,$categoria)

{

    $result = "";

    $linha = 0;



    if (strpos($content, '</p>') !== false):

        $paragrafos = explode('</p>', $content);



        foreach ($paragrafos as $p):

            $result .= "<p>";

            $result .=  $p;

            $result .= "</p>";

           

            if ($linha === 0):

                $result.="<p>";

                $result.=Banner1();

                $result.="</p>";

            endif;



            if ($linha === 1):

                $result.="<p>";

                $result.=Banner2(GetCategoria($categoria));

                $result.="</p>";

            endif;



            $linha++;    

        endforeach;

    endif;

    return $result;

}

















function GetCategoria($categoria)

{

    if (isset($categoria[0]->name)) {

        $nome = $categoria[0]->name;

        $link = get_category_link($categoria[0]->term_id);

        return array($nome, $link);

    }

}

/****************************************************************************************/







function limpar_html_do_excerpt($excerpt)

{

    // Remove todas as tags HTML do resumo

    $excerpt_limpo = strip_tags($excerpt);

    return $excerpt_limpo;

}



//add_filter('the_excerpt', 'limpar_html_do_excerpt');