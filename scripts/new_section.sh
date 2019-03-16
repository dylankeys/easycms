#!/bin/bash
# Add a new section to SimpleCMS

while [ "$1" != "" ]; do
    case $1 in
			-s | --section )   shift
									SECTION=$1
									;;
			-d | --dataroot ) shift
									DATAROOT=$1
									;;
        esac
    shift
done

create_section() {
    	mkdir $DATAROOT/sections/$SECTION
	symlink_section
}

symlink_section() {
	ln -s $DATAROOT/sections/$SECTION ../
}

create_section
