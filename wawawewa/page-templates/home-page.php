<?php

/**
 * Template Name: Homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RAD
 */


$id = get_the_ID();
$pageTitle = get_field('page_header', $id);
get_header();
?>
<main>
    <div class="page-hero">
        <h1><?php echo $pageTitle ?></h1>
    </div>

</main>
<?php
get_footer();
