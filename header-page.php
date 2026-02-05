<!DOCTYPE html>

<html lang="pt-BR">



<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <?php

    ob_start();



    $path_corrigido = str_replace('\\', '/', get_template_directory());

    define('pasta', $path_corrigido);

    define("tema", get_theme_file_uri());



    ?>





    <script type="application/ld+json">

        {

            "@context": "https://schema.org",

            "@type": "Organization",

            "name": "planos de saude do litoral",

            "url": "<?php echo home_url(); ?>",

            "logo": "<?php echo tema; ?>/imagens/logo.png",

            "contactPoint": {

                "@type": "ContactPoint",

                "telephone": "+55-13-99132-0809",

                "contactType": "Customer Service",

                "areaServed": "BR",

                "availableLanguage": ["Portuguese", "English"]

            }

        }

    </script>



     <!----------chamando os arquivos de fontes----------------->

     <?php echo get_template_part( 'fontes' )?>





    <link rel="stylesheet" href="<?php echo tema; ?>/css/slick/slick.css" media="all">

    <link rel="alternate" hreflang="pt-br" href="<?php echo home_url(); ?>" />



    <style>

        <?php echo file_get_contents(tema . "/css/page.css");

        if (is_single()) {

            echo file_get_contents(tema . "/css/single.css");

        }



        ?>

    </style>



    <?php wp_head(); ?>







</head>



<body class='wrapper'>