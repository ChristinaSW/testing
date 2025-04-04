<?php

get_header();

$layout = '
    <div class="content-sidebar-wrap">
        <main class="content">
            <article class="entry">
                <div class="entry-content">
                    <div style="display: flex; align-items: center; gap: 2em;">
                        <div style="text-align: center; flex-basis: 0; flex-grow: 1;">
                            <img src="https://anioncreative.s3.us-west-2.amazonaws.com/client_portal/admin_icons/404+Error.svg" />
                        </div>
                        <div style="text-align: center; flex-basis: 0; flex-grow: 1;">
                            <h1>Oops! Looks like the page you\'re looking for doesn\'t exist. Try <a href="'.site_url().'">starting over.</a></h1>
                        </div>
                    </div>
                </div>
            </article>
        </main>
    </div>
';

echo $layout;

get_footer();

?>