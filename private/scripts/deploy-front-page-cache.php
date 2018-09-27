<?php
echo "clear front page cache...\n";
passthru('wp pantheon cache purge-key front');
