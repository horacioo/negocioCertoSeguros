<!DOCTYPE html>
<html lang="pt-BR" itemscope itemtype="https://schema.org/CollectionPage">

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
            "@type": "CollectionPage",
            "name": "<?php single_cat_title(); ?>",
            "url": "<?php echo get_category_link(get_queried_object_id()); ?>",
            "description": "<?php echo category_description(); ?>",
            "hasPart": [
                <?php
                if (have_posts()) :
                    $posts_json = [];
                    while (have_posts()) : the_post();
                        $posts_json[] = json_encode([
                            "@type" => "BlogPosting",
                            "headline" => get_the_title(),
                            "author" => [
                                "@type" => "Person",
                                "name" => get_the_author()
                            ],
                            "datePublished" => get_the_date('c'),
                            "dateModified" => get_the_modified_date('c'),
                            "mainEntityOfPage" => [
                                "@type" => "WebPage",
                                "@id" => get_permalink()
                            ],
                            "url" => get_permalink(),
                            "description" => wp_strip_all_tags(get_the_excerpt(), true)
                        ]);
                    endwhile;
                    echo implode(',', $posts_json);
                endif;
                ?>
            ]
        }
    </script>


     <!----------chamando os arquivos de fontes----------------->
     <?php echo get_template_part( 'fontes' )?>




    <link rel="alternate" hreflang="pt-br" href="<?php echo home_url(); ?>" />

    <style>
        <?php echo file_get_contents(tema . "/css/category.css"); ?>
    </style>

    <?php wp_head(); ?>



</head>

<body class='wrapper'>