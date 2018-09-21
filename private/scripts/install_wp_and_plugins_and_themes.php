<?php
$user_email = $_POST['user_email'];
$user_name = $_POST['user_fullname'];
$site_url = 'https://' . $_ENV['PANTHEON_ENVIRONMENT'] . '-' . $_ENV['PANTHEON_SITE_NAME'] . '.pantheonsite.io';
$title = $_ENV['PANTHEON_SITE_NAME'];

print("\n===== WP-CLI WP Install ====\n" );
passthru( "wp core install --url='$site_url' --title='$title' --admin_user=admin --admin_email='$user_email'" );
sleep(10);
print( "\n==== WP-CLI WP Install Complete ====\n" );

print( "\n===== Activate theme...\n" );
passthru('wp theme activate understrap-child');
sleep(8);

print( "\n===== Add widget...\n" );
passthru('wp widget add edu_demo_hero_header herocanvas');
sleep(8);

print( "\n===== Create Menu...\n" );
passthru('wp menu create departmentheader');
sleep(8);

print( "\n===== Create Menu Item ...\n" );
passthru('wp menu item add-custom departmentheader "Majors"  "https://pantheon.io"');
sleep(2);

print( "\n===== Create Menu Item ...\n" );
passthru('wp menu item add-custom departmentheader "Faculty"  "https://pantheon.io"');
sleep(2);

print( "\n===== Create Menu Item ...\n" );
passthru('wp menu item add-custom departmentheader "Research"  "https://pantheon.io"');
sleep(2);

print( "\n===== Create Menu Item ...\n" );
passthru('wp menu item add-custom departmentheader "Undergraduate"  "https://pantheon.io"');
sleep(2);

print( "\n===== Create Menu Item ...\n" );
passthru('wp menu item add-custom departmentheader "Graduate"  "https://pantheon.io"');
sleep(2);

print( "\n===== Create Menu Item ...\n" );
passthru('wp menu item add-custom departmentheader "News & Events"  "https://pantheon.io"');
sleep(2);

print( "\n===== Create Menu Item ...\n" );
passthru('wp menu location assign departmentheader primary');
sleep(2);

// Pantheon test tag
print( "\n===== Pushing the git tags ...\n" );
passthru('git tag pantheon_test_1');
sleep(8);

// Push the Commits Back to Code Server
print( "\n===== Pushing the git tags ...\n" );
passthru('git push origin --tags');
sleep(8);