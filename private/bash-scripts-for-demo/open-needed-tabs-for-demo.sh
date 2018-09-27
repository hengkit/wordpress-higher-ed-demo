#!/bin/bash

# Let's open all the needed links for the demo in a single Firefox window

open -a /Applications/Firefox.app \
    https://dashboard.pantheon.io/organizations/89353d44-3e31-4fb0-b9c9-c8b21d9bdbda#sites \
    https://live-hed-creative-writing.pantheonsite.io/ \
    https://live-hed-ee.pantheonsite.io/ \
    https://live-hed-anthropology.pantheonsite.io/ \
    https://github.com/stevector/wordpress-higher-ed-demo/edit/master/wp-content/mu-plugins/hero.php \
    "https://dashboard.pantheon.io/sites/e81c14ec-b39c-4295-b2da-d17ef30d692f#dev/code" \
    "https://live-hed-anthropology.pantheonsite.io/platform/index.html#/diagram/live" \
    "https://dashboard.pantheon.io/organizations/89353d44-3e31-4fb0-b9c9-c8b21d9bdbda#support" \
    https://pantheon.io/edu \



export LOGIN1=$(terminus wp hed-creative-writing.live --  user one-time-login admin)
export LOGIN2=$(terminus wp hed-ee.live               --  user one-time-login admin)
export LOGIN3=$(terminus wp hed-anthropology.live     --  user one-time-login admin)

open -a /Applications/Firefox.app $LOGIN1 $LOGIN2 $LOGIN3
