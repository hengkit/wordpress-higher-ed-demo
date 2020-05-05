#!/bin/bash
set -ex


if [ "$1" != "" ]; then
    echo "Using the site machine name ${1}"
    TERMINUS_SITE=${1}
else
    echo "No site machine name given"
    exit 1
fi

if [ "$2" != "" ]; then
    echo "Using the machine name ${2}"
    TERMINUS_LABEL=${2}
else
    echo "No site label given"
    exit 1
fi


# @todo, does this need to be a param?
export TERMINUS_ORG="Demo University"

export TERMINUS_ENV=dev

# @todo, param for upstream name?
terminus site:create ${TERMINUS_SITE} "${TERMINUS_LABEL}" wordpress-demo --org="${TERMINUS_ORG}"

# @todo, param for email?
terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- core install --url=https://dev-${TERMINUS_SITE}.pantheonsite.io --title="${TERMINUS_LABEL}" --admin_user=admin --admin_password=$(openssl rand -hex 12)      --admin_email=steve.persch@pantheon.io

sleep 5

terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- theme activate understrap-child


sleep 5

terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- widget add edu_demo_hero_header herocanvas


terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- menu create departmentheader
terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- menu item add-custom departmentheader "Majors"  "https://pantheon.io"
terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- menu item add-custom departmentheader "Faculty"  "https://pantheon.io"
terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- menu item add-custom departmentheader "Research"  "https://pantheon.io"
terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- menu item add-custom departmentheader "Undergraduate"  "https://pantheon.io"
terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- menu item add-custom departmentheader "Graduate"  "https://pantheon.io"
terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- menu item add-custom departmentheader "News & Events"  "https://pantheon.io"
terminus wp ${TERMINUS_SITE}.${TERMINUS_ENV} -- menu location assign departmentheader primary

sleep 10
terminus env:deploy ${TERMINUS_SITE}.test

sleep 10
terminus env:deploy ${TERMINUS_SITE}.live



