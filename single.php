<?php get_header('page');  ?>

<?php get_template_part('partes/menu/index'); ?>

<?php $idDaCategoria = null; ?>

<main id="page">
    <?php get_template_part('partes/pagina/index'); ?>
</main>


















<aside>

    <?php

   // $current_category = get_queried_object_id();
    $category_y_id = get_queried_object_id();
    $subcategories = get_term_children($category_y_id, 'category');
    $current_post_id = get_the_ID();

    $xx = get_the_category($id);
    $current_category = $xx[0]->term_id;
    $args = array(
        'cat' => $current_category,
        'posts_per_page' => 30,
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1 ,// Paginação
        'post__not_in' => array($current_post_id), // Exclui o post atual
    );
    $query = new WP_Query($args);
    while ($query->have_posts()) : $query->the_post(); ?>
        <section>
            <?php $img = get_the_post_thumbnail_url($id, 'thumbnail') ?>
            <?php if ($img): ?><img  title="clique e veja mais sobre <?php the_title(); ?>"  src="<?php echo "$img"; ?>" alt="teste"> <?php endif; ?>
            <h2><a title="clique e veja mais sobre <?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a>
        </section>
    <?php endwhile; ?>
</aside>










<?php //get_template_part('partes/contatos_/index'); ?>


<?php get_template_part('partes/footer/index'); ?> 
<?php get_footer(); ?>