<?php

namespace VendorFPF;

/**
 * @var \WPDesk\Library\Marketing\Boxes\Abstracts\BoxInterface $box
 * @var \WPDesk\Library\Marketing\Boxes\Helpers\BBCodes $bbcodes
 * @var \WPDesk\Library\Marketing\Boxes\Helpers\Markers $markers
 */
?>
<div class="wpdesk-marketing-box wpdesk-marketing-box-simple wpdesk-marketing-box-<?php 
echo \esc_html($box->get_slug());
?>">
	<?php 
if (!empty($box->get_title())) {
    ?>
		<header>
			<h3>
				<?php 
    echo \esc_html($box->get_title());
    ?>
			</h3>
			<?php 
    if (!empty($box->get_description())) {
        ?>
			<p class="description">
				<?php 
        echo \wp_kses_post($bbcodes->replace($markers->replace(\wp_strip_all_tags($box->get_description()))));
        ?>
			</p>
			<?php 
    }
    ?>
		</header>
		<section>
			<?php 
    if (!empty($box->get_links())) {
        ?>
				<ul>
					<?php 
        foreach ($box->get_links() as $link) {
            ?>
						<li>
							<a href="<?php 
            echo \esc_url($markers->replace($link['url']));
            ?>" target="_blank"><?php 
            echo \wp_kses_post($bbcodes->replace($markers->replace(\wp_strip_all_tags($link['title']))));
            ?></a>
						</li>
					<?php 
        }
        ?>
				</ul>
			<?php 
    }
    ?>
			<?php 
    if (!empty($box->get_button()['name'])) {
        ?>
			<p class="box-button">
				<a
					class="button button-primary"
					href="<?php 
        echo \esc_url($box->get_button()['url']);
        ?>"
					target="_blank"
				>
					<?php 
        echo \wp_kses_post($box->get_button()['name']);
        ?>
				</a>
			</p>
			<?php 
    }
    ?>
		</section>
	<?php 
}
?>
</div>
<?php 
