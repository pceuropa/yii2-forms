#!/bin/sh

while inotifywait -r -e modify .
  do
    clear
    ../../bin/codecept run
  done
